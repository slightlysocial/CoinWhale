<?php

	include_once('facebook.php');

	class Facebook_connect {

		private $_obj;
		private $_app_id		= NULL;
		private $_api_key		= NULL;
		private $_secret_key	= NULL;
		public 	$user 			= NULL;
		public 	$user_id 		= FALSE;
		
		private $facebook;	
	
		private $session;
		
		private $uid=NULL;
		
		private $fbme;	

		function Facebook_connect()
		{
			$this->_obj =& get_instance();

			$this->_obj->load->config('facebook');
			//$this->_obj->load->library('session');
			$this->_app_id	= $this->_obj->config->item('facebook_app_id');
			$this->_api_key		= $this->_obj->config->item('facebook_api_key');
			$this->_secret_key	= $this->_obj->config->item('facebook_secret_key');

			$this->facebook = new Facebook(
			array(
			  'appId'  => $this->_app_id,
			  'secret' => $this->_secret_key,
			  'cookie' => true
			));
		
			$this->setSession();
	
			$this->checkSession();
		}
	
		/**
	* Save the Session
	*
	* @access private
	*
	*/ 
	private function setSession(){
		$this->session = $this->facebook->getSession();
	}	
	
	/**
	* Return the Session
	*
	* @access public
	*
	*/ 
	public function getSession(){
		return $this->session;
	}
	
	/**
	* Check the Session and redirect the user if not valid
	*
	* @param string $perms required extended permissions
	* @access public
	*
	*/ 
		public function checkSession(){
		
		if($this->session){
			
			try{
				$this->uid = $this->facebook->getUser();
				$this->setUserInfo();				
			}catch(FacebookApiException $e){
				
			}
		}
	}
	
	public function getLoginUrl($perms)
	{
		$loginUrl = $this->facebook->getLoginUrl(
			array(
				'canvas'    => 0,
				'fbconnect' => 0,
				'req_perms' => $perms
			)
		);
		
		return $loginUrl;
	}
	
	public function getLogoutUrl()
	{
		$logoutUrl = $this->facebook->getLogoutUrl();
		
		return $logoutUrl;
	}
	
	/**
	* Make a Graph API call
	*
	* @param string $path the Graph Path
	* @access public
	* @return mixed
	*
	*/
	public function api($path){
		return $this->facebook->api($path);
	}	
	
	/**
	* Set the User Info
	*
	* @access public
	*
	*/
	public function setUserInfo(){		
		$this->fbme = $this->api('/me');
	}
	
	/**
	* Get the Facebook User ID
	*
	* @access public
	* @return int $uid
	*
	*/
	public function getUserId(){
		return $this->uid;
	}
	
	/**
	* Get the User Email
	*
	* @access public
	* @return string $email
	*
	*/
	public function getEmail(){
		if(!$this->fbme){
			$this->setUserInfo();
		}
		return $this->fbme['email'];
	}	
	
	/**
	* Make an OLD FQL Query call
	*
	* @param string $fql the FQL Query
	* @access public
	* @return array
	*
	*/
	public function fql($fql){
		$param  =   array(
			'method'    => 'fql.query',
			'query'     => $fql,
			'callback'  => ''
		);
		return $this->api($param);
	}
	
	/**
	* Get the Info of the given User
	*
	* @param int $uid the Facebook User ID
	* @access public
	* @return array
	*
	*/
	public function getUserInfo($uid = 'me'){
		if($uid == 'me'){
			if(!$this->fbme){
				$this->setUserInfo();
			}
			return $this->fbme;
		}
		return $this->api('/' + $uid);
	}
	
	/**
	* Get the Friends List
	*
	* @param int $limit number of Friends to be returned
	* @access public
	* @return array
	*
	*/
	public function getFriends($limit = null){
		$rs = $this->api('/me/friends' . (isset($limit) ? '?limit=' . $limit : ''));
		return $rs['data'];
	}
	
	/**
	* Check if the User is Fan of the given Page
	*
	* @param id $page_id Facebook Page ID
	* @access public
	* @return bool
	*
	*/
	public function isFan($page_id){
		$param  =   array(
		   'method'  => 'pages.isFan',
		   'page_id' => $page_id,
		   'uid'     => $this->uid
		);
		return $this->api($param);
	}
	
	/**
	*appfriend
	*
	*/
	public function friends_getAppUsers(){
		$param  =   array(
		   'method'  => 'friends.getAppUsers',
		   'uid'     => $this->uid
		);
		return $this->api($param);
	}
	
	public function friends_get(){
		$param  =   array(
		   'method'  => 'friends.get',
		   'uid'     => $this->uid
		);
		return $this->api($param);
	}
	
	
	public function users_getInfo($uids){
		$param  =   array(
		   'method'  => 'users.getInfo',
		   'uids'    => $uids,
		   'fields'	 => array('uid', 'first_name', 'last_name', 'name')
		);
		return $this->api($param);
	}
	/**
	* Update the User status
	*
	* @param string $status the Status to post
	* @param id $uid the target User ID
	* @access public
	*
	*/
	public function updateStatus($status, $uid = 'me'){
		$status = htmlentities($status, ENT_QUOTES);
		$this->facebook->api("/$uid/feed", 'post', array('message'=> $status, 'cb' => ''));
	}
	
	/**
	* Publish on the User Stream
	*
	* @param string $title Title of the post
	* @param string $link Link of the post
	* @param string $message Custom User Message
	* @param string $image Image URl of the image to attach
	* @param id $uid the target User ID
	* @access public
	*
	*/
	public function streamPublish($title, $link, $message, $image, $uid = 'me'){
		$attachment =  array(
			'name' => $title,
			'link' => $link,
			'description' => $message,
			'picture' => $image
		);		
		$this->facebook->api("/$uid/feed", 'POST', $attachment);
	}
	
	function destroyFacebookSession()
	{
		 $this->facebook->clear_cookie_state();
	}
	
	function parse_signed_request($signed_request, $secret="") {
		$secret=$this->_secret_key;
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = $this->base64_url_decode($encoded_sig);
  $data = json_decode($this->base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}


	}