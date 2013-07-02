<?php

class Account extends Controller {

	function Account()
	{
		parent::Controller();	
		$this->load->model('deal_model');
		$this->load->model('user_model');
		parse_str($_SERVER['QUERY_STRING'],$_GET);
	}
	
	function index()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		$success=$this->input->get('success');
		if($user_id)
		{
				$data=array();
				$user_info=array();
				$summery=array();
				$account=array();
				$data['m']=0;
				$data['isLogin']=TRUE;
				$data['success']=$success;
				
				if($success==1)
				{
					$deal_status=$this->user_model->userGetLastDealStatus($user_id);
					$data['last_deal_status']=$deal_status['count'];
					$data['last_buy_id']=$deal_status['buy_id'];
				}
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				$user_info=$this->user_model->getUserInfo($user_id);
				$account=$this->user_model->accountInfo($user_id);
				
				$session=$this->facebook_connect->getSession();

				$summery=$this->deal_model->getDealSummery();
				//$data['userInfo']=$user_info;
				$data['uid']=$user_info["fb_id"];
				
				$this->load->vars($data);
				$this->load->vars($account);
				$this->load->vars($user_info);
				$this->load->vars($summery);
				$this->load->view('header');
				$this->load->view('account');
				$this->load->view('footer');
		}else
		{
			redirect(base_url());
		}
		//exit;
		
	}
	
	function testSession()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		$success=$this->input->get('success');
		if($user_id)
		{
				$data=array();
				$user_info=array();
				$summery=array();
				$account=array();
				$data['m']=0;
				$data['isLogin']=TRUE;
				$data['success']=$success;
				
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				$user_info=$this->user_model->getUserInfo($user_id);
				$account=$this->user_model->accountInfo($user_id);
				
				$session=$this->facebook_connect->getSession();

				$summery=$this->deal_model->getDealSummery();
				//$data['userInfo']=$user_info;
				$data['uid']=$user_info["fb_id"];
				
				$this->load->vars($data);
				$this->load->vars($account);
				$this->load->vars($user_info);
				$this->load->vars($summery);
				$this->load->view('header');
				$this->load->view('sessiontest');
				$this->load->view('footer');
		}else
		{
			redirect(base_url());
		}
		//exit;
		
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */