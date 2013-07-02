<?php

class ZferralConnector extends ZferralBase
{
  /**
   * API Key
   * @var string
   */
  private $api_key      = '';

  /**
   * zferral subdomain company
   * @var string
   */
  private $subdomain    = '';

  /**
   * API client version
   * @var string
   */
  private $version      = '0.2';

  private $controller   = '';
  private $format       = 'XML';
  private $response     = null;
  private $code         = '';
  private $meta         = '';
  private $header       = '';



  /**
   * Connect to the zferral API. All zferral API calls require $api_key and $subdomain before functioning
   *
   * @param string $api_key   Your zferral API key - always required
   * @param string $subdomain Your zferral subdomain company, e.g. if company have [subdomain].zferral.com, then enter "subdomain" only - always required
   */
  public function __construct($api_key, $subdomain)
  {
    $this->api_key   = $api_key;
    $this->subdomain = $subdomain;
  }

  /**
   * @param string  $base_url  base url of api call ex. /affiliate/create
   * @param string  $method Available methods: POST, GET, DELETE, PUT
   * @return array  array represents custom object or array of errors
   */
  public function custom($base_url, $method)
  {
    $this->_sendRequest($base_url, strtoupper($method));
    $result = ApiConvert::convert($this->format, $this->response);

    return $result;
  }

  /**
   * @param string  $module  Available modules: affiliate, campaign, event, commission, payout, company, plan
   * @param int     $id
   * @return array  array represents module object or array of errors
   */
  public function get($module, $id)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/$id" . $extension;

    $this->_sendRequest($base_url, 'GET');
    $result = ApiConvert::convert($this->format, $this->response);

    return $result[$module];
  }

  /**
   * @param string $module   Available modules: affiliate, campaign, event, commission, payout, company, plan
   * @param array $array     Parameters filter
   * @param string $base_url ex. analytics/date
   *
   * @return array  array of arrays represents module objects or array of errors
   */
  public function getList($module, $array = array(), $base_url = null)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = is_null($base_url) ? ("/$module" . $extension) : ($base_url.$extension);

    array_walk($array , create_function('&$v, $k', '$v = $k."=".$v;'));
    $data = "?" . implode("&", $array);

    $response = $this->_sendRequest($base_url, 'GET', $data);
    $result   = ApiConvert::convert($this->format, $response->response);

    if(isset($result[$module . 's'][$module]) && !isset($result[$module . 's'][$module][0]))
      $result[$module . 's'][$module] = array(0 => $result[$module . 's'][$module]);

    return isset($result[$module . 's'][$module]) ? $result[$module . 's'][$module] : array();
  }

  /**
   * @param string $module   Available modules: affiliate, campaign, event, commission, payout, company, plan
   * @param array $array     Fields create object
   * @param string $base_url ex. marketing/create/banner
   *
   * @return array  array of arrays represents module objects or array of errors
   */
  public function create($module, $array, $base_url = null)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = is_null($base_url) ? ("/$module/create" . $extension) : ($base_url.$extension);

    $arrayModule[$module] = $array;

    if ($this->format == 'XML')
    {
      $xml = new Xml();
      $xml->setArray($arrayModule);

      $content = $xml->outputXML('return');
    }
    else $content = json_encode($arrayModule);

    $response = $this->_sendRequest($base_url, 'POST', $content);
    $result   = ApiConvert::convert($this->format, $response->response);

    return $result;
  }

  /**
   * @param string $module  Available modules: affiliate, campaign, event, commission, payout, company, plan
   * @param int $id         ID object
   * @param array $array    Fields update object
   *
   * @return int id of updated object or array of errors
   */
  public function update($module, $id, $array)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/$id" . $extension;

    $arrayModule[$module] = $array;

    if ($this->format == 'XML')
    {
      $xml = new Xml();
      $xml->setArray($arrayModule);

      $content = $xml->outputXML('return');
    }
    else $content = json_encode($arrayModule);

    $response = $this->_sendRequest($base_url, 'PUT', $content);
    $result   = ApiConvert::convert($this->format, $response->response);

    if ($response->code == 200)
    {
      return (int)$result[$module]['id'];
    }
    else return $result;
  }

  /**
   * @param string $module  Available modules: affiliate, campaign, event, commission, payout, company, plan
   * @param int $id         ID object
   *
   * @return int id of deleted object or array of errors
   */
  public function delete($module, $id)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/$id" . $extension;

    $response = $this->_sendRequest($base_url, 'DELETE');
    $result   = ApiConvert::convert($this->format, $response->response);

    if ($response->code == 200)
    {
      return (int)$result[$module]['id'];
    }
    else return $result;
  }

  /**
   * @param string $module  Available modules: event
   * @param array $array    Parameters action
   * @param bool $debug     Debug mode
   *
   * @return bool Commission sum - Only if $debug=true
   */
  public function call($module = 'event', $array, $debug = false)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/call" . $extension;

    if ($debug === true) $array = array_merge(array('debug' => 'on'), $array);

    if (isset($array['ref']) && $array['ref']) {
      $array = array_merge(array('referer' => $array['ref']), $array);
    } else {
      $array = array_merge(array('referer' => $_COOKIE['hash']), $array);
    }
    $array = array($module => $array);

    if ($this->format == 'XML')
    {
      $xml = new Xml();
      $xml->setArray($array);

      $content = $xml->outputXML('return');
    }
    else $content = json_encode($array);

    $response = $this->_sendRequest($base_url, 'POST', $content);
    $result   = ApiConvert::convert($this->format, $response->response);

    if ($response->code == 200)
    {
      return $result;
    }
  }

  /**
   * @param  string  $module  Available modules: company
   * @param  array   $array   Action parameters
   * @return string  Auth token
   */
  public function getAuthToken($module = 'company')
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/getAuthToken" . $extension;

    $this->_sendRequest($base_url, 'GET');
    $result = ApiConvert::convert($this->format, $this->response);

    return $result[$module]['auth_token'];
  }

  /**
   * @param  string  $module  Available modules: company
   * @param  array   $array   Action parameters
   * @return int     1 if success
   */
  public function generateAuthToken($module = 'company')
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/generateAuthToken" . $extension;

    $this->_sendRequest($base_url, 'GET');

    $result = ApiConvert::convert($this->format, $this->response);

    return $result[$module]['auth_token_generate'];
  }

  /**
   * @param  string  $module  Available modules: affiliate
   * @param  array   $array   Action parameters (username, password, iv)
   * @return bool    Whether is authenticated or not
   */
  public function zfAuth($module = 'affiliate', $array)
  {
    $extension = '.' . strtolower($this->format);
    $base_url  = "/$module/zfAuth" . $extension;

    $array = array($module => $array);

    if ($this->format == 'XML')
    {
      $xml = new Xml();
      $xml->setArray($array);

      $content = $xml->outputXML('return');
    }
    else $content = json_encode($array);

    $response = $this->_sendRequest($base_url, 'POST', $content);
    $result   = ApiConvert::convert($this->format, $response->response);

    if ($response->code == 200)
    {
      return $result[$module]['authenticated'];
    }
  }

  public function getVersion()
  {
    return $this->version;
  }

  protected function _sendRequest($uri, $method = 'GET', $data = '')
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,
      sprintf('http://%s.zferral.com/%sapi/%s%s%s',
      $this->subdomain, $this->controller, $this->api_key, $uri, ($method == 'GET' ? $data : '')
    )); // https
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, sprintf("zferral API/%s", $this->version));

    if ($this->format === 'XML')
    {
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: text/xml; charset=utf-8',
        'Accept: text/xml; charset=utf-8'
      ));
    }
    else
    {
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
      ));
    }

    $method = strtoupper($method);

    if ($method === 'POST')
    {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    else if ($method === 'PUT')
    {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    else if ($method !== 'GET')
    {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $this->response = curl_exec($ch);
    $this->code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $this->meta     = curl_getinfo($ch);
    $this->header   = curl_getinfo($ch , CURLINFO_CONTENT_TYPE);

    $curl_error = ($this->code > 0 ? null : curl_error($ch) . ' (' . curl_errno($ch) . ')');

    curl_close($ch);

    if ($curl_error)
    {
      throw new Exception('An error occurred while connecting to zferral: ' . $curl_error);
    }

    return $this;
  }
}