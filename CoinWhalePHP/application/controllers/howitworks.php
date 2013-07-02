<?php

class Howitworks extends Controller {

	function Howitworks()
	{
		parent::Controller();	
		$this->load->model('deal_model');
		$this->load->model('user_model');
		//$this->load->model('user_model');
	}
	
	function index()
	{
		
		//print_r($_GET);
		$data=array();
		$user_info=array();
		$summery=array();
		$deal=array();
		$data['m']=2;
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
		$this->load->vars($data);
		//$this->load->vars($deal);
		$this->load->vars($user_info);
		$this->load->vars($summery);
		$this->load->view('header');
		$this->load->view('howworks');
		$this->load->view('footer');
		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */