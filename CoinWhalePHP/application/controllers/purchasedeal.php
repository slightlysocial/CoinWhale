<?php

class Purchasedeal extends Controller {

	function Purchasedeal()
	{
		parent::Controller();	
		$this->load->model('purchase_model');
		//$this->load->model('user_model');
	}
	
	function index()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		
		
		
		//print_r($this->facebook_connect);
		
		
		
		
		//echo 'NUM:'.$summery->num_rows();
	
		
		
		
		//echo "logot:".$logOut;
		if($user_id)
		{
				
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				
				$bid=$this->uri->segment(3,0);
				//echo $did;
				$purchase=$this->purchase_model->getDealInfo($bid);
				//$data['userInfo']=$user_info;
		
				
				$this->load->vars($purchase);
				$this->load->view('header_short');
				$this->load->view('purchasedeal');
				$this->load->view('footer_short');
		}else
		{
			redirect(base_url());
		}
		//exit;
		
	}
	
	
	function sentdeal()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		
		
		
		//print_r($this->facebook_connect);
		
		
		
		
		//echo 'NUM:'.$summery->num_rows();
	
		
		
		
		//echo "logot:".$logOut;
		if($user_id)
		{
				
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				
				$bid=$this->uri->segment(3,0);
				//echo $did;
				$purchase=$this->purchase_model->getSentDealInfo($bid);
				//$data['userInfo']=$user_info;
		
				
				$this->load->vars($purchase);
				$this->load->view('header_short');
				$this->load->view('sentdeal');
				$this->load->view('footer_short');
		}else
		{
			redirect(base_url());
		}
		//exit;
		
	}
	
	
	function showNotInstall()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		
		
		
		//print_r($this->facebook_connect);
		
		
		
		
		//echo 'NUM:'.$summery->num_rows();
	
		
		
		
		//echo "logot:".$logOut;
		if($user_id)
		{
				
				
				//$data['fbme']=$this->facebook_connect->getUserInfo();
				//$user_id=$this->user_model->getUserId($data['uid'],$data['fbme']);
				
				$bid=$this->uri->segment(3,0);
				//echo $did;
				$purchase=$this->purchase_model->getDealInstallInfo($bid);
				//$data['userInfo']=$user_info;
		
				
				$this->load->vars($purchase);
				$this->load->view('header_short');
				$this->load->view('notinstalldeal');
				$this->load->view('footer_short');
		}else
		{
			redirect(base_url());
		}
		//exit;
		
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */