<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();	
		$this->load->model('deal_model');
		$this->load->model('user_model');
		$this->load->model('ajax_model');
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		//echo "<pre>";
		//print_r($_COOKIE);
	//	
		//print_r($_SESSION);
	}
	
	function showEmail()
	{
		$user_id=$this->phpsession->userdata('uid');
		
		if($user_id)
		{
					$data=array();
					$user_info=array();
					$summery=array();
					//$deal=array();
					$data['m']=0;
					
					//$data['isValid']=FALSE;
					//$deal_id=$this->input->get('did');
					//$success=$this->input->get('success');
					
					$data['isLogin']=TRUE;
					$session=$this->facebook_connect->getSession();
					
					$user_info=$this->user_model->getUserInfo($user_id);
					//$deal=$this->deal_model->getDeal($deal_id);
			
			
					$summery=$this->deal_model->getDealSummery();
			
					$data['uid']=$user_info["fb_id"];
					$this->load->vars($data);
					//$this->load->vars($deal);
					$this->load->vars($user_info);
					$this->load->vars($summery);
					$this->load->view('header');
					$this->load->view('showEmail');
					$this->load->view('footer');
					//$this->getDeal($deal_id);
			
			
			
			
			
			//echo 'NUM:'.$summery->num_rows();
		
			//$this->phpsession->set_userdata('uid',1);
			
			//exit;
			//echo "val".$this->common_functions->current_date_diff($deal["end_date"]);
			
		
		}else
		{
			redirect("".base_url());
		}
	}
	
	function logout()
	{
		$isLogout=$this->uri->segment(2,'');
		
		if($isLogout=='logout')
		{
			//$this->facebook_connect->destroyFacebookSession();
			$this->phpsession->unset_userdata('uid');
			$this->phpsession->set_userdata('logout',1);
		}
		//$this->index();
		redirect(base_url());
		
	}
	
	function login()
	{
		$isLogin=$this->uri->segment(2,'');
		
		if($isLogin=='login')
		{
			//$this->facebook_connect->destroyFacebookSession();
			//$this->phpsession->unset_userdata('uid');
			$this->phpsession->unset_userdata('logout');
		}
		
		
		redirect(base_url());
	}
	
	function index()
	{
		
		//print_r($_GET);
		
		//print_r($this->facebook_connect);
		//$this->phpsession->set_userdata("lp_status",0);
		//$this->resetCookie('user_status');
		
		//print_r($_COOKIE);
		//print_r($_SESSION);
		
		$gift_code=$this->input->get('giftcode');
		if($gift_code)
		{
			
			$cookie = array(
                   'name'   => 'giftcode',
                   'value'  => ''.$gift_code,
                   'expire' => '86500',
                   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($cookie); 
		}else
		{
			$gift_code=get_cookie("coin_giftcode");
			
			//echo "refer $refer";
		}
		
		
		
		$refer=$this->input->get('refer');
		
		if($refer)
		{
			$cookie = array(
                   'name'   => 'refer',
                   'value'  => ''.$refer,
                   'expire' => '86500',
                   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($cookie); 
		}else
		{
			$refer=get_cookie("coin_refer");
			
			//echo "refer $refer";
		}
		
		$signed_request=$this->input->post('signed_request');
		
		//echo "<pre>";
		//print_r($signed_request);
		if($signed_request)
		{
			$this->register($signed_request,$refer);
		}
		
		$signin=$this->input->get('signin');
		$step=$this->input->post('step');
		$email=$this->input->post('email');
		if($email)
		{
			$this->setCoinCookie('email',$email);
		}else
		{
			$email=get_cookie("coin_email");
		}
		
		$message_status=0;
		$profile_status=0;
		$user_status=get_cookie("coin_user_status");
		$user_id=$this->phpsession->userdata('uid');
		//echo "email".$step;
		if($step==1)
		{
			$message_status=$this->submitLandingEmail();
			if($message_status!=3)
			{
				$user_status=1;
				$this->phpsession->set_userdata("lp_status",0);
			}
				
		}
		else if($step==5)
		{
			
				if($user_id)
				{
					$merge=$this->input->post('merge');
					if($merge==1)
					{
						$message_status=$this->submitRegisterEmail($user_id,$email);
					}
					//if($message_status!=3)
					//{
					$user_status=3;
					$this->setCoinCookie("user_status",3);
						//$this->phpsession->set_userdata("lp_status",0);
					//}
				}
				
			
		}else if($step==6)
		{
			
				if($user_id)
				{
					$merge=$this->input->post('merge');
					if($merge==2)
					{
						$message_status=$this->submitRegisterEmail($user_id,$email);
					}
					//if($message_status!=3)
					//{
					$user_status=3;
					$this->setCoinCookie("user_status",3);
						//$this->phpsession->set_userdata("lp_status",0);
					//}
				}
				
			
		}
		
		//$email="raymon007@gmail.com";
		
		//echo "user status: $user_status";
		
		
		
		
		$lp_status=$this->phpsession->userdata("lp_status",0);
		
		//echo "Status".$lp_status;
		$param=array("message"=>$message_status,
						"email"=>$email,
						"user_status"=>$user_status,
						"lp_status"=>$lp_status,
						"profile_status"=>$profile_status,
						"signin"=>$signin);
		
					
		if($user_status)
		{
			
			
			$this->renderHome($param,$gift_code);
			
			
		}else
		{
			
			$email=$this->input->get('email');
			if($email)
			{
				$this->setCoinCookie('email',$email);
				$lp_status=0;
					
			}
			if($lp_status)
			{
		
		
				$this->renderHome($param,$gift_code);
				
			}else
			{
				
				$data['email']=$email;
				$this->load->vars($data);
				$this->load->view('header_splash');
				$this->load->view('landinghome');
				$this->load->view('footer_short');
				$this->phpsession->set_userdata("lp_status",1);
				//$this->renderHome($refer);
				
			}
		}
	}
	
	function renderHome($param=array(),$gift_code)
	{
				$data=array();
				$user_info=array();
				$summery=array();
				$deal=array();
				$data['m']=0;
				$data['gift_status']=0;
				$data['isRegistered']=TRUE;
				//$data['profile_status']=0;
				$session=$this->facebook_connect->getSession();
				$deal=$this->deal_model->getCurrentDeal();
				//echo "<pre>";
				//print_r($session);
				
				//$data["deal"]=$deal;
				$summery=$this->deal_model->getDealSummery();
				
				//echo 'NUM:'.$summery->num_rows();
			
				//$this->phpsession->set_userdata('uid',1);
				$user_id=$this->phpsession->userdata('uid');
				$logOut=$this->phpsession->userdata('logout');
				
				$mail=$param['email'];
				
				
				//echo "logot:".$logOut;
				if($user_id)
				{
						$data['isLogin']=TRUE;
						
						//$data['fbme']=$this->facebook_connect->getUserInfo();
						//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
						
						
						$user_info=$this->user_model->getUserInfo($user_id);
						//$data['userInfo']=$user_info;
						$data['uid']=$user_info["fb_id"];
						$user_status=$param["user_status"];
						if($user_status<3)
						{
							$user_status=3;
							$param["user_status"]=3;
							$this->setCoinCookie('user_status',3);
							//$this->phpsession->set_userdata("lp_status",0);
						}
						
						if($gift_code)
						{
							$gift_status=$this->isValidCode($gift_code,$user_id);
							if($gift_status==1)
							{
								if($this->claimGift($gift_code,$user_id))
								{
									$data["gift_status"]=1;
								}else
								{
									$data["gift_status"]=4;
								}
								
							}else
							{
								if($gift_status==0)
								{
									$data["gift_status"]=2;
									
								}else if($gift_status==2)
								{
									$data["gift_status"]=3;
								}else if($gift_status==3)
								{
									$data["gift_status"]=6;
								}
							}
							
							
						}
				}else
				{
					//echo "Coin";
					
					//print_r($session);
					if($session)
					{
						//echo "Coin2";
						//$params='email,publish_stream,status_update,user_birthday';
						if($logOut)
						{
							//echo "Coin3";
							$params='email,publish_stream,status_update,user_birthday';
							$data['isLogin']=false;
							//$data['uid']=$this->facebook_connect->getUserId();
							//$data['fbme']=$this->facebook_connect->getUserInfo();
							$data['loginURL']=$this->facebook_connect->getLoginUrl($params);
							$data['logoutURL']='';	
						}else
						{
							try{
							
							
							//$data['isLogin']=TRUE;
							//$data['profile_status']=$this->user_model->getUserProfileStatus($user_id,$mail);
							$data['uid']=$this->facebook_connect->getUserId();
							//$data['fbme']=$this->facebook_connect->getUserInfo();
							$user_id=$this->user_model->getUserId($data['uid']);
							
							//echo "UID:$user_id";
							
							$user_info=$this->user_model->getUserInfo($user_id);
							//$old_user=$this->user_model->isNewUser($user_id);
							$data['loginURL']='';
							$data['logoutURL']=$this->facebook_connect->getLogoutUrl();
							//$data['userInfo']=$user_info;
							//echo "<pre>";
							$this->phpsession->set_userdata('uid',$user_id);
							//print_r($data);
							if($user_id)
							{
								$data['isLogin']=TRUE;
								$user_status=$param["user_status"];
								if($user_status<2)
								{
									$user_status=2;
									$param["user_status"]=2;
									$param["lp_status"]=0;
									$this->setCoinCookie('user_status',2);
									$this->phpsession->set_userdata("lp_status",0);
								}
								
								if($gift_code)
								{
									$gift_status=$this->isValidCode($gift_code,$user_id);
									if($gift_status==1)
									{
										if($this->claimGift($gift_code,$user_id))
										{
											$data["gift_status"]=1;
										}else
										{
											$data["gift_status"]=4;
										}
										
									}else
									{
										if($gift_status==0)
										{
											$data["gift_status"]=2;
											
										}else if($gift_status==2)
										{
											$data["gift_status"]=3;
											
										}else if($gift_status==3)
										{
											$data["gift_status"]=6;
										}
									}
									
									
								}
							}else
							{
								$data['isLogin']=FALSE;
								$data['isRegistered']=FALSE;
								$params='email,publish_stream,status_update,user_birthday';
								$data['isLogin']=false;
								//$data['uid']=$this->facebook_connect->getUserId();
								//$data['fbme']=$this->facebook_connect->getUserInfo();
								$data['loginURL']=$this->facebook_connect->getLoginUrl($params);
								$data['logoutURL']='';
								if($gift_code)
								{
									$data["gift_status"]=5;
								}	
								//print_r($session);
								
							}
							
							}catch(FacebookApiException $e){
								
							}
						}
					}else
					{
						//$this->phpsession->set_
						$params='email,publish_stream,status_update,user_birthday';
						$data['isLogin']=false;
						//$data['uid']=$this->facebook_connect->getUserId();
						//$data['fbme']=$this->facebook_connect->getUserInfo();
						$data['loginURL']=$this->facebook_connect->getLoginUrl($params);
						$data['logoutURL']='';
						if($gift_code)
						{
							$data["gift_status"]=5;
						}	
					}
				}
				
				$mail=$param["email"];
				if($mail)
				{
					$profile_status=$this->user_model->getUserProfileStatus($user_id,$mail);
					//echo "profile $profile_status";
					$param["profile_status"]=$profile_status;
				}
				//echo "profile2 $profile_status";
				//exit;
				/*if(!$old_user)
				{
					redirect(base_url()."/home/showEmail/");
					//exit(0);
				}*/
				//print_r($param);
				
				$this->load->vars($data);
				$this->load->vars($deal);
				$this->load->vars($user_info);
				$this->load->vars($param);
				//echo "Name$name";
				$this->load->vars($summery);
				$this->load->view('header');
				$this->load->view('home');
				$this->load->view('footer');
				if(!$lp_status)
				{
					$this->phpsession->set_userdata("lp_status",1);
				}
			
	}
	
	
	
	
	function resetCookie($name)
	{
		$user_status=0;
				$user_cookie = array(
                   'name'   => ''.$name,
                   'value'  => ''.$user_status,
                   'expire' => '2592000',
                   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($user_cookie); 
	}
	
	function setCoinCookie($name,$value)
	{
		
				$email_cookie = array(
                   'name'   => ''.$name,
                   'value'  => ''.$value,
                   'expire' => '2592000',
                   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($email_cookie); 
	}
	
	function submitLandingEmail($step=1)
	{
		$ret_val=0;
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$email=$this->input->post('email');
		$merge=array("FNAME"=>$fname,
					"LNAME"=>$lname);
		
		//print_r($merge);
		
		
			$this->load->helper('email');
			$value=$email;
			if(valid_email($value))
			{
				
				//$success=$this->ajax_model->insertUnregisteredEmail($value,$fname,$lname);
				if($this->ajax_model->insertUnregisteredEmail($value,$fname,$lname)!=0)
				{
					$this->common_functions->storeAddress($value,"934d229e2c",$merge);
					
					$ret_val=1;
				}else
				{
					$ret_val=2;
				}
								
			}else
			{
				$ret_val= 3;
			}
			
			if($ret_val!=3)
			{
				
				
				$user_status=$step;
				
				$user_cookie = array(
                   'name'   => 'user_status',
                   'value'  => ''.$user_status,
                   'expire' => '2592000',
                   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($user_cookie); 
			}
			
			return $ret_val;
		
	}
	
	function submitRegisterEmail($user_id,$value)
	{
		//$ret_val=0;
		
		$user_info=$this->user_model->getUserInfo($user_id);
			$fname=$user_info['fname'];
			$lname=$user_info['lname'];
			$merge=array("FNAME"=>$fname,
					"LNAME"=>$lname);
			$this->load->helper('email');	
			if(valid_email($value))
			{
				
					if($this->ajax_model->insertUserEmail($user_id,$value))
					{
						$this->common_functions->storeAddress($value,"934d229e2c",$merge);
						return 1;
					}
			
			}else
			{
				return 3;
			}
		
	}
	
	function isValidCode($code,$user_id)
	{
		$status=$this->user_model->isValidCode($code,$user_id);
		
		if($status!=1)
		{
			$this->mdelete_cookie("giftcode",NULL,NULL,NULL,TRUE);
		}
		
		return $status;
	}
	
	function claimGift($code,$user_id)
	{
		
		if($this->user_model->claimGift($code,$user_id))
		{
			$this->mdelete_cookie("giftcode");
			return TRUE;
		}else
		{
			return FALSE;
		}
	}
	
	function mdelete_cookie($name)
	{
		$cookie = array(
                   'name'   => ''.$name,
                   'value'  => NULL,
                   'expire' => NULL,
				   'domain' => '.coinwhale.com',
                   'path'   => '/',
                   'prefix' => 'coin_',
               );

			set_cookie($cookie); 
	}
	
	function register($signed_request,$refer)
	{
		
			//$signed_request=$_POST['signed_request'];
			//echo "<pre>";
			//print_r($signed_request);
			$response=$this->facebook_connect->parse_signed_request($signed_request);
			//print_r($response);
			
			
			if($response)
			{
				$uinfo=$response['registration'];
				//echo "<pre>";
				//print_r($uinfo);
				$uid=$response['user_id'];
				$email=$uinfo['email'];
				$user_id=$this->user_model->registerUser($uid,$uinfo,$refer);
				
				if($user_id>0)
				{
					//$this->submitRegisterEmail($user_id,$email);
					$this->submitRegisterEmail($user_id,$email);
					$this->phpsession->set_userdata('uid',$user_id);
					
					echo '<img src="http://coinwhale.zferral.com/e/3?rev=$rev&customerId='.$user_id.'&uniqueId='.md5($user_id).'" style="border: none; display: none" alt=""/>';
				}
			}
			
		
	}
	function test()
	{
		$merge=array("FNAME"=>"Mobarak",
					"LNAME"=>"Chowdhury");
		echo $this->common_functions->storeAddress("wasim@slightlysocial.com","934d229e2c",$merge);
	}
	
	function submitSplash()
	{
		
		$step=$this->input->post('step');
		$email=$this->input->post('email');
		$refer=$this->input->post('refer');
		
		if($email)
		{
			$this->setCoinCookie('email',$email);
		}else
		{
			$email=get_cookie("coin_email");
		}
		
		$message_status=0;
		$profile_status=0;
		//$user_status=get_cookie("coin_user_status");
		//$user_id=$this->phpsession->userdata('uid');
		//echo "email".$step;
		if($step==1)
		{
			$message_status=$this->submitLandingEmail();
			if($message_status!=3)
			{
				$user_status=1;
				$this->phpsession->set_userdata("lp_status",0);
			}
				
		}
		if($refer)
		{
			redirect($refer);
		}else
		{
			redirect("".base_url()."/home/");
		}
		
	}
	
}

