<?php

class Ajax extends Controller {

	function Ajax()
	{
		parent::Controller();	
		$this->load->model('ajax_model');
		$this->load->model('user_model');
		$this->load->model('deal_model');
		parse_str($_SERVER['QUERY_STRING'],$_GET);
	}
	
	function showEmail()
	{
		//$this->load->library('store-address');
		$data=array();
		$user_info=array();
		$summery=array();
		$deal=array();
		$data['m']=0;
		$session=$this->facebook_connect->getSession();
		$deal=$this->deal_model->getCurrentDeal();
		
		
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
					$user_id=$this->user_model->getUserId($data['uid'],$data['fbme'],$refer);
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
		$this->load->vars($data);
		$this->load->vars($deal);
		$this->load->vars($user_info);
		$this->load->vars($summery);
		$this->load->view('header');
		$this->load->view('email');
		$this->load->view('footer');
	}
	
	function mylink()
	{
		$user_id=$this->phpsession->userdata('uid');
		if($user_id>0)
		{
			$data['refer']=$this->ajax_model->myLink($user_id);
			$this->load->vars($data);
			$this->load->view('header_short');
			$this->load->view('refer');
			$this->load->view('footer_short');
			
		}else
		{
			echo "<div style='height:100px'>";
			echo "<div style='text-align:center;'>To get your referal link please login first</div>";
			echo "</div>";
		}
	}
	
	
	function redeemCoin()
	{
		$user_id=$this->phpsession->userdata('uid');
		if($user_id>0)
		{
			$value=$this->input->post('clid');
			$status=$this->ajax_model->redeemCoin($value);
			
			if($status)
			{
				echo "CLAIMED";
			}else
			{
				echo "<div style='color:#ff0000'>Error! Please try again later!</div>";
			}
			//$this->load->vars($data);
			//$this->load->view('header_short');
			//$this->load->view('refer');
			//$this->load->view('footer_short');
			
		}else
		{
			echo "<div style='height:100px'>";
			echo "<div style='text-align:center;'>To claim your coins please login first</div>";
			echo "</div>";
		}
	}
	
	
	
	
	function submitEmail()
	{
		
		//$this->phpsession->set_userdata('uid',1);
		$user_id=$this->phpsession->userdata('uid');
		
		
		//echo 'value:'.$value;
		
		//print_r($this->facebook_connect);
		
		
		
		
		//echo 'NUM:'.$summery->num_rows();
	
		
		
		
		//echo "logot:".$logOut;
		if($user_id)
		{
			$this->load->helper('email');
			$value=$this->input->post('email');
			$user_info=$this->user_model->getUserInfo($user_id);
			$fname=$user_info['fname'];
			$lname=$user_info['lname'];
			$merge=array("FNAME"=>$fname,
					"LNAME"=>$lname);
					
			if(valid_email($value))
			{
				
					if($this->ajax_model->insertUserEmail($user_id,$value))
					{
						echo "<p>".$this->common_functions->storeAddress($value,"934d229e2c",$merge)."</p>";
					}
				
			}else
			{
				echo "<div>Sorry invalid email address!!</div>";
				echo "<div class='sp'>&nbsp;</div>";
				echo '<div id="member-email">
        		<input type="text" class="input" value="" name="email" id="email" />
            <input type="image" class="submit" src="'.base_url().'images/submit.png" alt="submit" onclick="submitEmail()">
        </div>';
			}
				
		}else
		{
			//redirect(base_url());
			$this->load->helper('email');
			$value=$this->input->post('email');
			if(valid_email($value))
			{
				$this->setAjaxCookie('email',$value);
				$success=$this->ajax_model->insertUnregisteredEmail($value);
				if($success==1)
				{
					$this->setAjaxCookie('user_status',1);
					echo "<p>".$this->common_functions->storeAddress($value)."</p>";
					
					//echo "<p>Congratulation!! Your email address has been successfully subscribed!!</p>";
				}else if($success==2)
				{
					$this->setAjaxCookie('user_status',1);
					$this->common_functions->storeAddress($value);
					echo "Congratulation! Your information has been updated.";
					
				}else
				{
					echo "<p>Sorry !! This email address already in use !! Try another one!!</p>";
				}
			}else
			{
				echo "<div>Sorry invalid email address!!</div>";
				echo "<div class='sp'>&nbsp;</div>";
				echo '
					<div id="member-email">
						<input type="text" class="input" value="" name="email" id="email" />
						<input type="image" class="submit" src="'.base_url().'images/submit.png" alt="submit" onclick="submitEmail()">
					</div>';
			}
		}
	}
	
	function registerUser()
	{
		
		//echo "1";
		//exit;
		//$user_id=0;
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$email=$this->input->post('email');
		$var = array(array("groups"=>"Facebook Page"));
		
		$merge=array("FNAME"=>$fname,
					"LNAME"=>$lname,
						'GROUPINGS'=>array(array('name'=>'Facebook Page','groups'=>'Signup')));
		//print_r($merge);
		//$uid=$this->input->post('uid');
		
		//$name="".$fname." ".$lname;
		//$user_id=$this->ajax_model->registerUser($uid,$name,$fname,$lname,"");
		
		
		
			$this->load->helper('email');
			$value=$email;
			if(valid_email($value))
			{
				$success=$this->ajax_model->insertUnregisteredEmail($value);
				if($success==1)
				{
					//echo $this->common_functions->storeAddress($value,"8c5ca7fb55",$merge);
					echo $this->common_functions->storeAddress($value,"934d229e2c",$merge);
					
				}else if($success==2)
				{
					
					$this->common_functions->storeAddress($value,"934d229e2c",$merge);
					echo "Congratulation! Your information has been updated.";
					
				}else
				{
					echo "Sorry !! This email address already in use !! Try another one!!";
				}
					//echo "1";
					//echo "<p>Congratulation!! your email address has been updated !! You have been rewarded <span class='coin'>+ 1 CoinWhale Credit </p>";
				
			}else
			{
				echo "Sorry invalid email address!";
			}
				
		
		//exit;
		
	}
	
	function registerEmail()
	{
		
		//echo "1";
		//exit;
		//$user_id=$this->input->post('uid');
		$email=$this->input->post('email');
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		//$uid=$this->input->post('uid');
		
		//$name="".$fname." ".$lname;
		//$user_id=$this->ajax_model->registerUser($uid,$name,$fname,$lname,"");
		//echo $fname
		$merge=array("FNAME"=>$fname,
					"LNAME"=>$lname);
								
								
		
			$this->load->helper('email');
			$value=$email;
			if(valid_email($value))
			{
				
					echo $this->common_functions->storeAddress($value,"8c5ca7fb55",$merge);
					//echo "1";
					//echo "<p>Congratulation!! your email address has been updated !! You have been rewarded <span class='coin'>+ 1 CoinWhale Credit </p>";
				
			}else
			{
					echo "Sorry! Invalid email address!";
			}
				
		
		//exit;
		
	}
	
	function showsteptwo()
	{
		$data['email']=$this->input->get('email');
				//echo $did;
				
				//$data['userInfo']=$user_info;
		
				
		$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('lpsteptwo');
		$this->load->view('footer_short');
	}
	
	function showstepthree()
	{
		
		//$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('lpstepthree');
		$this->load->view('footer_short');
	}
	
	function showpopupname()
	{
		
		//$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('popupname');
		$this->load->view('footer_short');
	}
	
	function showlogin()
	{
		
		//$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('loginpopup');
		$this->load->view('footer_short');
	}
	
	function showregistration_test()
	{
		
		//$this->load->vars($data);,
		//$email=get_cookie("coin_email");
		
		$array=array(
		array("name"=>"name"),
		array("name"=>"email"),
		array("name"=>"first_name"),
		array("name"=>"last_name")
		);
		$data['fields']=json_encode($array);
		
		$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('registerpopup');
		$this->load->view('footer_short');
	}
	
	function showregistration()
	{
		
		//$this->load->vars($data);,
		//$email=get_cookie("coin_email");
		
		
		
		//$this->load->vars($data);
		$this->load->view('header_short');
		$this->load->view('registerpopup_test');
		$this->load->view('footer_short');
	}
	
	function showpopupmerge()
	{
		
		//$this->load->vars($data);
		$user_id=$this->phpsession->userdata('uid');
		$data['email']=$this->input->get('email');
		
		
		if($user_id)
		{
			$this->load->helper('email');
			$value=$this->input->post('email');
			$user_info=$this->user_model->getUserInfo($user_id);
			$this->load->vars($user_info);
			$this->load->vars($data);
			$this->load->view('header_short');
			$this->load->view('popupmerge');
			$this->load->view('footer_short');
		}else
		{
			echo "<div align='center'>Please login first!</div>";
		}
	}
	
	function setAjaxCookie($name,$value)
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
	
	function resendGift()
	{
		$user_id=$this->phpsession->userdata('uid');
		$email=$this->input->post('email');
		$buy_id=$this->input->post('bid');
		$deal_id=$this->input->post('did');
		
		
		if($user_id)
		{
			//$this->load->helper('email');
			
			if(!$this->deal_model->hasGift($deal_id,$email))
			{
				if(!$this->deal_model->isMyEmail($user_id,$email))
				{
					
					if($this->deal_model->resendGift($buy_id,$email))
					{
						$code=$this->deal_model->getVerificationCode($buy_id);
						$this->resendEmail($user_id,$email,$code,$deal_id);
						echo "Congratulation ! Gift successfully sent to your friend!";
					}
				}else
				{
					echo "Sorry! You can't send gift to yourself, but to your friends. Send some gifts to your friends and make them happy!";
				}
			}else
			{
				echo "Sorry! Your friend already received this gift. Send some gifts to your other friends and make them happy!";
			}
			
		}else
		{
			echo "<div align='center'>Please login first!</div>";
		}
	}
	
	function testAjaxSession()
	{
		echo "<div>";
		echo "<pre>";
		print_r($_SESSION);
		
		echo "<div>Problem</div>";
		echo "</div>";
	}
	
	function resendEmail($user_id,$mail,$code,$deal_id)
	{
		$this->load->library('email');
		$user_info=$this->user_model->getUserInfo($user_id);
		$from="support@coinwhale.com";
		$name="CoinWhale Gift Bundle";
		
			$name=$user_info["name"];
			$not_email=$user_info["not_email"];
			 if(isset($not_email) && !empty($not_email))
			 {
				 $from=$not_email;
			}
		
		try
		{
		$this->email->set_mailtype("html");
		$this->email->from($from,$name);
		$this->email->to($mail);
		
		$this->email->subject($name.' has bought you a gift.');
		$deal_content=$this->deal_model->getDealTextContent($deal_id);
		$message="<p>You just received a gift at CoinWhale from $name, aren't you lucky to have awesome friends like $name!</p>"; 
		$message.="<p>Your CoinWhale Gift Bundle contains goodies for $deal_content</p>";
		//$message.="<p>&nbsp;</p>";
		$message.="<p>To claim your CoinWhale Gift, please follow this link.</p>";
		//$message.="<p>&nbsp;</p>";
		//$message.="$deal_content";
		//$message.="<p>&nbsp;</p>";
		//$message.="<p>To claim your CoinWhale Gift Bundle, please follow this link.</p>";
		//$message.="<p>&nbsp;</p>";
		$message.="(<a href='http://www.coinwhale.com/?giftcode=$code'>http://www.coinwhale.com/?giftcode=$code</a>)";
		$message.="<p>If you have any problems, you can try to manually claim the deal with the code '$code'. If that doesn't work, you can send us an email at <a href='mailto:support@coinwhale.com'>support@coinwhale.com</a> and we'd be happy to help you.</p>";
		$this->email->message($message);
		$this->email->send();
		}catch(Exception $e)
		{
			//echo $e;
		}
	}
}



/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */