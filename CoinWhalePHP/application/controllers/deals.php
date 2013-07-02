<?php

class Deals extends Controller {

	function Deals()
	{
		parent::Controller();	
		$this->load->model('deal_model');
		$this->load->model('user_model');
		parse_str($_SERVER['QUERY_STRING'],$_GET);
	}
	
	
	function index()
	{
		$deal_id=$this->input->get('did');
		if($deal_id)
		{
			$this->getDeal($deal_id);
		}else
		{
			$this->recentDeals();
		}
	}
	
	function process()
	{
		$user_id=$this->phpsession->userdata('uid');
		$purchase_type=$this->input->post('purchase_type');
		$friend_email=$this->input->post('friend_email');
		//print_r($_POST);
		
		//if(isset())
		
		if($user_id)
		{
			$data=array();
			$data["user_id"]=$user_id;
			
			$deal_id=$this->input->post('deal_id');
			if($deal_id>0)
			{
				if($purchase_type==1)
				{
					if(!$this->deal_model->hasGift($deal_id,$friend_email))
					{
						if(!$this->deal_model->isMyEmail($user_id,$friend_email))
						{
							$deal=$this->deal_model->getDeal($deal_id);
							
							$buy_id=$this->deal_model->processDeal($deal_id,$user_id,$deal);
							if($buy_id>0)
							{
								$data["buy_id"]=$buy_id;
								$this->load->vars($data);
								$this->load->vars($deal);
							//$this->load->view('header');
								if($user_id==3155)
								{
									$this->load->view('process_test');
								}else
								{
									$this->load->view('process');
								}
							}else
							{
								redirect("".base_url()."deals/buy/?success=-2&did=$deal_id");	
							}
						}else
						{
							redirect("".base_url()."deals/buy/?success=-4&did=$deal_id");
						}
					}else
					{
						redirect("".base_url()."deals/buy/?success=-3&did=$deal_id");	
					}
				}else
				{
							$deal=$this->deal_model->getDeal($deal_id);
							
							$buy_id=$this->deal_model->processDeal($deal_id,$user_id,$deal);
							if($buy_id>0)
							{
								$data["buy_id"]=$buy_id;
								$this->load->vars($data);
								$this->load->vars($deal);
							//$this->load->view('header');
								if($user_id==3155)
								{
									$this->load->view('process_test');
								}else
								{
									$this->load->view('process');
								}
							}else
							{
								redirect("".base_url()."deals/buy/?success=-2&did=$deal_id");	
							}
				}
				
			}else
			{
				redirect("".base_url()."deals/buy/?success=-1&did=$deal_id");
			}	
		}else
		{
			redirect(base_url());
		}
	}
	
	
	function sparechange()
	{
		$user_id=$this->phpsession->userdata('uid');
		$purchase_type=$this->input->post('purchase_type');
		$friend_email=$this->input->post('friend_email');
		$custom="";
		if(isset($_COOKIE['hash']))
		{
			$custom=$_COOKIE['hash'];
		}
		
		if($user_id)
		{
			$data=array();
			$user_info=array();
			
			$summery=array();
			
			$data['m']=0;
			$data['isLogin']=TRUE;
			$user_info=$this->user_model->getUserInfo($user_id);
				//$account=$this->user_model->accountInfo($user_id);
			$session=$this->facebook_connect->getSession();

			$summery=$this->deal_model->getDealSummery();
				//$data['userInfo']=$user_info;
			$data['uid']=$user_info["fb_id"];
				
				
			
			$data["user_id"]=$user_id;
			
			$deal_id=$this->input->post('deal_id');
			if($deal_id>0)
			{
				
				if($purchase_type==1)
				{
					if(!$this->deal_model->hasGift($deal_id,$friend_email))
					{
						if(!$this->deal_model->isMyEmail($user_id,$friend_email))
						{
							$deal=$this->deal_model->getDeal($deal_id);
							$buy_id=$this->deal_model->processDeal($deal_id,$user_id,$deal,2);
							if($buy_id>0)
							{
								$this->deal_model->processHash($buy_id,$custom);
								$data["buy_id"]=$buy_id;
								$this->load->vars($data);
								$this->load->vars($deal);
								$this->load->vars($user_info);
								$this->load->vars($summery);
								$this->load->view('header');
								$this->load->view('sparechange');
								$this->load->view('footer');
							}else
							{
								redirect("".base_url()."deals/buy/?success=-2&did=$deal_id");	
							}
						}else
						{
							redirect("".base_url()."deals/buy/?success=-4&did=$deal_id");
						}
					}else
					{
						redirect("".base_url()."deals/buy/?success=-3&did=$deal_id");	
					}
				}else
				{
							$deal=$this->deal_model->getDeal($deal_id);
							$buy_id=$this->deal_model->processDeal($deal_id,$user_id,$deal,2);
							if($buy_id>0)
							{
								$this->deal_model->processHash($buy_id,$custom);
								$data["buy_id"]=$buy_id;
								$this->load->vars($data);
								$this->load->vars($deal);
								$this->load->vars($user_info);
								$this->load->vars($summery);
								$this->load->view('header');
								$this->load->view('sparechange');
								$this->load->view('footer');
							}else
							{
								redirect("".base_url()."deals/buy/?success=-2&did=$deal_id");	
							}
				}
				
			}else
			{
				redirect("".base_url()."deals/buy/?success=-1&did=$deal_id");	
			}
		}else
		{
			redirect(base_url());
		}
	}
	
	function buy()
	{
		
		$user_id=$this->phpsession->userdata('uid');
		
		if($user_id)
		{
					$data=array();
					$user_info=array();
					$summery=array();
					$deal=array();
					$data['m']=0;
					
					$data['isValid']=FALSE;
					$deal_id=$this->input->get('did');
					$success=$this->input->get('success');
					if($deal_id)
					{
						$data['isValid']=TRUE;
					}
					$data['success']=$success;
					$data['isLogin']=TRUE;
					$session=$this->facebook_connect->getSession();
					
					$user_info=$this->user_model->getUserInfo($user_id);
					$deal=$this->deal_model->getDeal($deal_id);
			
			
					$summery=$this->deal_model->getDealSummery();
					if(isset($deal['deal_status']))
					{
						if($deal['deal_status']==1)
						{
							$data['isValid']=TRUE;
						}else
						{
							$data['isValid']=FALSE;
						}
					}else
					{
						$data['isValid']=FALSE;
					}
					$data['uid']=$user_info["fb_id"];
					$this->load->vars($data);
					$this->load->vars($deal);
					$this->load->vars($user_info);
					$this->load->vars($summery);
					$this->load->view('header');
					$this->load->view('buy');
					$this->load->view('footer');
					//$this->getDeal($deal_id);
			
			
			
			
			
			//echo 'NUM:'.$summery->num_rows();
		
			//$this->phpsession->set_userdata('uid',1);
			
			//exit;
			//echo "val".$this->common_functions->current_date_diff($deal["end_date"]);
			
		
		}else
		{
			redirect("".base_url()."/?signin=1");
		}
		
	}
	
	
	
	function sparetestbuy()
	{
		
		$user_id=1;//$this->phpsession->userdata('uid');
		
		if($user_id)
		{
					$data=array();
					$user_info=array();
					$summery=array();
					$deal=array();
					$data['m']=0;
					
					$data['isValid']=FALSE;
					$deal_id=$this->input->get('did');
					$success=$this->input->get('success');
					if($deal_id)
					{
						$data['isValid']=TRUE;
					}
					$data['success']=$success;
					$data['isLogin']=TRUE;
					$session=$this->facebook_connect->getSession();
					
					$user_info=$this->user_model->getUserInfo($user_id);
					$deal=$this->deal_model->getDeal($deal_id);
			
			
					$summery=$this->deal_model->getDealSummery();
			
					$data['uid']=$user_info["fb_id"];
					$this->load->vars($data);
					$this->load->vars($deal);
					$this->load->vars($user_info);
					$this->load->vars($summery);
					$this->load->view('header');
					$this->load->view('sparebuy');
					$this->load->view('footer');
					//$this->getDeal($deal_id);
			
			
			
			
			
			//echo 'NUM:'.$summery->num_rows();
		
			//$this->phpsession->set_userdata('uid',1);
			
			//exit;
			//echo "val".$this->common_functions->current_date_diff($deal["end_date"]);
			
		
		}else
		{
			redirect("".base_url()."/?signin=1");
		}
		
	}
	
	function recentDeals()
	{
		
		//print_r($_GET);
		$data=array();
		$user_info=array();
		$summery=array();
		$deal=array();
		$data['isRegistered']=TRUE;
		$data['m']=1;
		//$deal_id=$this->input->get('did');
		//echo "deal:".$deal_id;
		//print_r($this->facebook_connect);
		
		
		$session=$this->facebook_connect->getSession();
		$deal["all_deal"]=$this->deal_model->getRecentDeals();
		
		//$data["deal"]=$deal;
		$summery=$this->deal_model->getDealSummery();
		
		//echo 'NUM:'.$summery->num_rows();
	
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		$logOut=$this->phpsession->userdata('logout');
		
		//echo "logot:".$logOut;
		if($user_id)
		{
				$data['isLogin']=TRUE;
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				$user_info=$this->user_model->getUserInfo($user_id);
				//$data['userInfo']=$user_info;
				$data['uid']=$user_info["fb_id"];
		}else
		{
			if($session)
			{
				//$params='email,publish_stream,status_update,user_birthday';
				if($logOut)
				{
					$params='email,publish_stream,status_update,user_birthday';
					$data['isLogin']=false;
					//$data['uid']=$this->facebook_connect->getUserId();
					//$data['fbme']=$this->facebook_connect->getUserInfo();
					$data['loginURL']=$this->facebook_connect->getLoginUrl($params);
					$data['logoutURL']='';	
				}else
				{
					try{
					$data['isLogin']=TRUE;
					$data['uid']=$this->facebook_connect->getUserId();
					//$data['fbme']=$this->facebook_connect->getUserInfo();
					$user_id=$this->user_model->getUserId($data['uid']);
					$user_info=$this->user_model->getUserInfo($user_id);
					$data['loginURL']='';
					$data['logoutURL']=$this->facebook_connect->getLogoutUrl();
					//$data['userInfo']=$user_info;
					//echo "<pre>";
					if($user_id)
					{
						$this->phpsession->set_userdata('uid',$user_id);
					//print_r($data);
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
			}
		}
		//exit;
		//echo "val".$this->common_functions->current_date_diff($deal["end_date"]);
		$this->load->vars($data);
		$this->load->vars($deal);
		$this->load->vars($user_info);
		$this->load->vars($summery);
		$this->load->view('header');
		$this->load->view('recentdeals');
		$this->load->view('footer');
	}
	
	function getDeal($deal_id)
	{
		
		//print_r($_GET);
		$data=array();
		$user_info=array();
		$summery=array();
		$deal=array();
		$data['m']=1;
		
		//echo "deal:".$deal_id;
		//print_r($this->facebook_connect);
		
		
		$session=$this->facebook_connect->getSession();
		$deal=$this->deal_model->getDeal($deal_id);
		
		//$data["deal"]=$deal;
		$summery=$this->deal_model->getDealSummery();
		
		//echo 'NUM:'.$summery->num_rows();
	
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		$logOut=$this->phpsession->userdata('logout');
		
		//echo "logot:".$logOut;
		if($user_id)
		{
				$data['isLogin']=TRUE;
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				$user_info=$this->user_model->getUserInfo($user_id);
				//$data['userInfo']=$user_info;
				$data['uid']=$user_info["fb_id"];
		}else
		{
			if($session)
			{
				//$params='email,publish_stream,status_update,user_birthday';
				if($logOut)
				{
					$params='email,publish_stream,status_update,user_birthday';
					$data['isLogin']=false;
					//$data['uid']=$this->facebook_connect->getUserId();
					//$data['fbme']=$this->facebook_connect->getUserInfo();
					$data['loginURL']=$this->facebook_connect->getLoginUrl($params);
					$data['logoutURL']='';	
				}else
				{
					try{
					$data['isLogin']=TRUE;
					$data['uid']=$this->facebook_connect->getUserId();
					//$data['fbme']=$this->facebook_connect->getUserInfo();
					$user_id=$this->user_model->getUserId($data['uid']);
					$user_info=$this->user_model->getUserInfo($user_id);
					$data['loginURL']='';
					$data['logoutURL']=$this->facebook_connect->getLogoutUrl();
					//$data['userInfo']=$user_info;
					//echo "<pre>";
					$this->phpsession->set_userdata('uid',$user_id);
					//print_r($data);
					
					
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
			}
		}
		//exit;
		//echo "val".$this->common_functions->current_date_diff($deal["end_date"]);
		$this->load->vars($data);
		$this->load->vars($deal);
		$this->load->vars($user_info);
		$this->load->vars($summery);
		$this->load->view('header');
		$this->load->view('deals');
		$this->load->view('footer');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */