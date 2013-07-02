<?php

class Others extends Controller {

	function Others()
	{
		parent::Controller();	
		$this->load->model('deal_model');
		$this->load->model('user_model');
		$this->load->model('ajax_model');
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		//$this->load->model('user_model');
	}
	
	function index()
	{
		
		//print_r($_GET);
		$data=array();
		$user_info=array();
		$summery=array();
		$deal=array();
		$data['m']=0;
		//$deal_id=$this->input->get('did');
		//echo "deal:".$deal_id;
		//print_r($this->facebook_connect);
		
		
		$session=$this->facebook_connect->getSession();
		//$deal["all_deal"]=$this->deal_model->getRecentDeals();
		
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
					$data['fbme']=$this->facebook_connect->getUserInfo();
					$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
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
		$page=$this->input->get('page');
		
		if(!isset($page))
		{
			$page="about";
		}
		$this->load->vars($data);
		//$this->load->vars($deal);
		$this->load->vars($user_info);
		$this->load->vars($summery);
		$this->load->view('header');
		if($page=='about')
		{
			$this->load->view('about');
			
		}else if($page=='buylater')
		{
			if(isset($_GET['deal_id']))
			{
				$deal_id = $_GET['deal_id'];
			}
			$dInfo = $this->deal_model->getDeal($deal_id);
			
			$msg['msg'] = "";
			if(isset($_POST['Submit']))
			{
				$this->load->helper('email');
				$deal_id = $_POST['deal_id'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$cause = $_POST['cause'];
				if($name != "" && $email != "")
				{
					if(!($this->ajax_model->checkLateReq($deal_id,$email)))
					{
						if(valid_email($email))
						{
							$msg['msg']  = $this->ajax_model->lateRequest($deal_id,$name,$email,$cause);
						}
						else
						{
							$msg['msg']  = "<font class='error'>Sorry invalid email address!!!</font>";
						}
					}
					else
					{
						$msg['msg']  = "<font class='error'>Your had requested already!!!</font>";
					}
				}
				else
				{
					$msg['msg']  = "<font class='error'>You have to provide your name and email!!!</font>";
				}
			}
			$this->load->vars($msg);
			$this->load->vars($dInfo);
			$this->load->view('buylater');
		}
		else if($page=='jobs')
		{
			$this->load->view('jobs');
			
		}else if($page=='press')
		{
			$this->load->view('press');
			
		}else if($page=='legal')
		{
			$this->load->view('legal');
			
		}
		else if($page=='privacy')
		{
			$this->load->view('privacy');
			
		}else if($page=='faq')
		{
			$this->load->view('faq');
			
		}else if($page=='api')
		{
			$this->load->view('api');
			
		}else if($page=='affiliate')
		{
			$this->load->view('affiliate');
			
		}else if($page=='widget')
		{
			$this->load->view('widget');
			
		}else if($page=='suggestion')
		{
			$this->load->view('suggestion');
			
		}else if($page=='featured')
		{
			$this->load->view('featured');
			
		}else if($page=='blog')
		{
			$this->load->view('blog');
			
		}else if($page=='rules')
		{
			$this->load->view('rules');
			
		}else if($page=='winnerslist')
		{
			$this->load->view('winnerslist');
			
		}
		
		$this->load->view('footer');
		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */