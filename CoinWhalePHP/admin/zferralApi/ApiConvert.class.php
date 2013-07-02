<?php

require_once 'Xml2Array.class.php';

class ApiConvert
{
  public static function convert($format, $content)
  {
    $format = strtoupper($format);

    switch ($format)
    {
      case 'XML':
        return self::convertXML($content);
        break;
      case 'JSON':
        return self::convertJSON($content);
        break;
    }
  }

  public static function convertXML($content)
  {
    return Xml2Array::convert($content);
  }

  public static function convertJSON($content)
  {
    return json_decode($content, true);
  }
}
