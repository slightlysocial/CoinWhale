<?
error_reporting(0);
include_once("dbInteracter.php");
include_once("functions.php");
include_once('Email.php');
function insertCallbacklog($buy_id,$game_id)
{
	$date = getSystemDate();
	$q = "insert into callback_log values('','$buy_id','$game_id',0,'$date')";
	executeQuery($q);
}

function insertErrorCallbacklog($buy_id,$game_id)
{
	$date = getSystemDate();
	$q = "insert into callback_log values('','$buy_id','$game_id',-1,'$date')";
	executeQuery($q);
}

function updateCallbacklog($buy_id,$game_id)
{
	$q = "update callback_log set status=1 where buy_id='$buy_id' AND game_id='$game_id'";
	executeQuery($q);
}
function insertLog($item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$user_id,$status,$date)
{
	$q = "insert into paypal_log values('','$item_number','$payment_status','$payment_amount','$payment_currency','$txn_id','$receiver_email','$payer_email','$user_id','$status','$date')";
	executeQuery($q);
}
function call_callback($deal_id,$buy_id)
{
	$games = getGameByDeal($deal_id);
	$buyInfo = getUserBuyInfo($buy_id);
	$userInfo=getUserInfo($buyInfo['user_id']);
	//echo '<pre>';
	
	for($i=0; $i<count($games); $i++)
	{
		$gamesInfo = getGameInfo($games[$i]);
		//echo "<pre>";
		//print_r($gamesInfo);
			
		$path="";
		if(strstr($gamesInfo['callback_url'],"?"))
		{
			$path=$gamesInfo['callback_url']."&";
		}else
		{
			$path=$gamesInfo['callback_url']."?";
		}
		$signature=md5($deal_id."".$buy_id."".$gamesInfo['credit_amt']."".$userInfo['fb_id']);
		$path = $path."deal_id=".$deal_id."&buy_id=".$buy_id."&point=".$gamesInfo['credit_amt']."&user_id=".$userInfo['fb_id']."&signature=$signature";
		//echo $path; //exit(0);
		
		try{
				$handle = fopen($path, "r");
				$blank=true;
				if($handle) 
				{
					while (!feof($handle)) 
					{
						insertCallbacklog($buy_id,$gamesInfo['serial']);
						$blank=false;
						$buffer = fgets($handle, 4096);
						if($buffer == '1')
						{
							updateCallbacklog($buy_id,$gamesInfo['serial']);
							//echo '1';
						}
						else{
							//echo '0';
						}
					}
					if($blank)
					{
						insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
					}
					fclose($handle);
				}
				else{
					//echo '0';
					insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
					
				}	
		}catch(Exception $e)
		{
			insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
		}
	}
}

function sendEmail($user_id,$mail,$code,$deal_id)
{
	$from="support@coinwhale.com";
	$name="CoinWhale Gift Bundle";
	$q="select name,not_email from user where user_id=$user_id";
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
		$name=$d[0];
		$not_email=$d[1];
		 if(isset($not_email) && !empty($not_email))
		 {
			 $from=$not_email;
		}
	}
	$content="";
	$q="select game_name,game_url from deal_content where deal_id=$deal_id";
	$r=executeQuery($q);
	$count=1;
	while($d=getRecords($r))
	{
		$gname=$d[0];
		$url=$d[1];
		if($count==1)
		{
			$content.="<a href='$url'>$gname</a>";
		}else
		{
		
			$content.=", <a href='$url'>$gname</a>";
		}
		$count++;
	}
	
	try
	{
	$email=new Email();
	$email->set_mailtype("html");
	$email->from($from,$name);
	$email->to($mail);
	
	$email->subject($name.' has bought you a gift.');
	$message="<p>You just received a gift at CoinWhale from $name, aren't you lucky to have awesome friends like $name!</p>"; 
	$message.="<p>Your CoinWhale Gift Bundle contains goodies for $content</p>";
	//$message.="<p>&nbsp;</p>";
	//$message.="<p>Your CoinWhale Gift Bundle contains coins for following Facebook applications:</p>";
	//$message.="<p>&nbsp;</p>";
	//$message.="$content";
	//$message.="<p>&nbsp;</p>";
	$message.="<p>To claim your CoinWhale Gift, please follow this link.</p>";
	//$message.="<p>&nbsp;</p>";
	$message.="(<a href='http://www.coinwhale.com/?giftcode=$code'>http://www.coinwhale.com/?giftcode=$code</a>)";
	$message.="<p>If you have any problems, you can try to manually claim the deal with the code '$code'. If that doesn't work, you can send us an email at <a href='mailto:support@coinwhale.com'>support@coinwhale.com</a> and we'd be happy to help you.</p>";

	$email->message($message);
	$email->send();
	}catch(Exception $e)
	{
		//echo $e;
	}
}

function processDeal($deal_id,$user_id,$buy_id)
{
	$q="update user_buy set status=1 where deal_id=$deal_id and user_id=$user_id and buy_id=$buy_id";
	
	$r=executeQuery($q);
	if($r)
	{
		
		$q="SELECT friend_email,varification_code from friend_gift fg,user_buy ub where ub.user_id=fg.user_id and ub.deal_id=fg.deal_id and ub.buy_id=fg.buy_id and ub.buy_for=1 and ub.buy_id=$buy_id and ub.deal_id=$deal_id and ub.user_id=$user_id";
		$r=executeQuery($q);
		$d=getRecords($r);
		if($d)
		{
			
			$email=$d[0];
			$code=$d[1];
			
			sendEmail($user_id,$email,$code,$deal_id);
		}else
		{
		
			call_callback($deal_id,$buy_id);
		}
		$q="select refer_id from user_refer where user_id=$user_id";
		$r=executeQuery($q);
		$d=getRecords($r);
		
		if($d)
		{
			$refer_id=$d[0];
			$date=getSystemDateOnly();
			$q="insert into buy_refer values(null,$buy_id,$refer_id,'$date')";
			if(executeQuery($q))
			{
				
				$q="update user set credit=credit+1000 where user_id=$refer_id";
				executeQuery($q);
			}
		}
	}
	//mailchimp integration
	$userInfo = getUserInfo($user_id);
	if($userInfo['not_email'] != "" || $userInfo['not_email'] != NULL)
	{
		//listUnsubscribe($userInfo['not_email'],"934d229e2c");
		//$merge = array("FNAME"=>$userInfo['fname'],"LNAME"=>$userInfo['lname']);
		$merge=array("FNAME"=>$userInfo['fname'],
					"LNAME"=>$userInfo['lname'],
						'GROUPINGS'=>array(array('name'=>'VIP Users','groups'=>'Paid Users')));
		listSubscribe($userInfo['not_email'], "934d229e2c", $merge, false);
	}
	
	try
	{
		trackSales();
		
	}catch(Exception $ee)
	{
		
	}
}

function testMailChimp()
{
	error_reporting(2047);
	//$merge = array("FNAME"=>"Wasim","LNAME"=>"Chowdhury");
	$merge=array("FNAME"=>"Wasim",
					"LNAME"=>"Chowdhury");
	$val = listSubscribe("wasim@slightlysocial.com", "934d229e2c", $merge, false);
	echo $val;
}
function listSubscribe($email,$list_id="934d229e2c",$merge='',$double_optin=true)
{	
	// Validation
	//if(!$_GET['email']){ return "No email address provided"; } 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email)) {
		return "Email address is invalid"; 
	}

	require_once('MCAPI.php');
	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI('d5aceafc493bcad5615c9c66ef3ef969-us2');
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
	

	if($api->listSubscribe($list_id, $email, $merge, 'html', $double_optin) === true) {
		// It worked!	
		return 'Congratulation! Check your email to confirm sign up.';
	}else{
		// An error ocurred, return error message	
		//return 'Error: ' . $api->errorMessage;
		//return false;
		$date = date("Y-m-d H:i:s");
		$q = "insert into mailchimp_error values('','List Subscribe','$email','".$api->errorCode."','".$api->errorMessage."','$date')";
		executeQuery($q);
		if($api->errorCode == 214)
		{
			if($api->listUpdateMember($list_id, $email, $merge) === true) 
			{
				// It worked! 
				return 'Congratulation! Your information has been updated.';
			}else{
				// An error ocurred, return error message 
				return 'Error: ' . $api->errorMessage;
			}
		}else
		{
			return 'Error: ' . $api->errorMessage;
		}
	}	
}
function listUnsubscribe($email,$list_id="934d229e2c")
{
	// Validation
	//if(!$_GET['email']){ return "No email address provided"; } 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email)) {
		return "Email address is invalid"; 
	}

	require_once('MCAPI.php');
	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI('d5aceafc493bcad5615c9c66ef3ef969-us2');
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
	if($api->listUnsubscribe($list_id, $email, true) === true) 
	{
		// It worked! 
		return true;
	}
	else{
		$date = date("Y-m-d H:i:s");
		$q = "insert into mailchimp_error values('','List UnSubscribe','$email','".$api->errorCode."','".$api->errorMessage."','$date')";
		executeQuery($q);
		// An error ocurred, return error message 
		return false;
	}
}		

function insertScLog($item_number,$payment_point,$payment_amount,$txn_id,$user_id,$status,$date)
{
	$q = "insert into sc_log values('','$item_number','$payment_point','$payment_amount','$txn_id','$user_id','$status','$date')";
	executeQuery($q);
}

function insertScFailLog($item_number,$payment_point,$payment_amount,$txn_id,$user_id,$status,$date)
{
	$q="select * from sc_fail_log where txn_id='$txn_id'";
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
		
	}else
	{
		$q = "insert into sc_fail_log values('','$item_number','$payment_point','$payment_amount','$txn_id','$user_id','$status','$date')";
		executeQuery($q);
	}
}

function getDealByBuyId($buyId)
{
	//$dealInfo=array();
	$q="select deal_id from user_buy where buy_id=$buyId";
	//echo $q;
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
		return $d[0];
	}
	
	return 0;
}


function redeem_callback($cl_id)
{
	
	$q="select * from callback_log where serial=$cl_id and status!=1";
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
	//$games = getGameByDeal($deal_id);
	$buy_id=$d[1];
	$game_id=$d[2];
	$buyInfo = getUserBuyInfo($buy_id);
	$userInfo=getUserInfo($buyInfo['user_id']);
	//echo '<pre>';
	
	//for($i=0; $i<count($games); $i++)
	//{
		$gamesInfo = getGameInfo($game_id);
		$path="";
		if(strstr($gamesInfo['callback_url'],"?"))
		{
			$path=$gamesInfo['callback_url']."&";
		}else
		{
			$path=$gamesInfo['callback_url']."?";
		}
		//print_r($gamesInfo);
		$signature=md5($buyInfo['deal_id']."".$buy_id."".$gamesInfo['credit_amt']."".$userInfo['fb_id']);
		$path = $path."deal_id=".$buyInfo['deal_id']."&buy_id=".$buy_id."&point=".$gamesInfo['credit_amt']."&user_id=".$userInfo['fb_id']."&signature=$signature";
		//echo $path; 
		//exit(0);
		try{
		$blank=true;	
		$handle = fopen($path, "r");
				if($handle) 
				{
					while (!feof($handle)) 
					{
						//insertCallbacklog($buy_id,$gamesInfo['serial']);
						$blank=false;
						$buffer = fgets($handle, 4096);
						//echo "$buffer";
						if($buffer == '1')
						{
							updateCallbacklog($buy_id,$gamesInfo['serial']);
							echo '1';
						}
						else{
							echo '0';
						}
					}
					
					if($blank)
					{
						echo '0';
					}
					
					fclose($handle);
				}
				else{
					echo '0';
				}	
		
		}catch(Exception $ex)
		{
			echo '0';
		}
	}else
	{
		echo "0";
	}
}

function trackSales()
{
		
		try{
				
				$path="http://www.coinwhale.com/admin/tanalyticsbuy.php";
				$handle = fopen($path, "r");
				if($handle) 
				{
					while (!feof($handle)) 
					{
						//insertCallbacklog($buy_id,$gamesInfo['serial']);
						$buffer = fgets($handle, 4096);
						//echo "$buffer";
						
					}
					fclose($handle);
				}
		}catch(Exception $ex)
		{
			
		}
		
}
		
		
function test_redeem_callback($cl_id)
{
	
	$q="select * from callback_log where serial=$cl_id and status!=1";
	
	//echo $q;
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
	//$games = getGameByDeal($deal_id);
	$buy_id=$d[1];
	$game_id=$d[2];
	$buyInfo = getUserBuyInfo($buy_id);
	$userInfo=getUserInfo($buyInfo['user_id']);
	//echo '<pre>';
	
	//for($i=0; $i<count($games); $i++)
	//{
		$gamesInfo = getGameInfo($game_id);
		
		$path="";
		if(strstr($gamesInfo['callback_url'],"?"))
		{
			$path=$gamesInfo['callback_url']."&";
		}else
		{
			$path=$gamesInfo['callback_url']."?";
		}
		//print_r($gamesInfo);
		$signature=md5($buyInfo['deal_id']."".$buy_id."".$gamesInfo['credit_amt']."".$userInfo['fb_id']);
		$path = $path."deal_id=".$buyInfo['deal_id']."&buy_id=".$buy_id."&point=".$gamesInfo['credit_amt']."&user_id=".$userInfo['fb_id']."&signature=$signature";
		echo $path;
		echo "<br/>";
		$blank=true;
		$handle = fopen($path, "r");
		if($handle) 
		{
			while (!feof($handle)) 
			{
				//insertCallbacklog($buy_id,$gamesInfo['serial']);
				$blank=false;
				$buffer = fgets($handle, 4096);
				echo "$buffer";
				if($buffer == '1')
				{
					updateCallbacklog($buy_id,$gamesInfo['serial']);
					echo '1';
				}
				else{
					echo '0';
				}
			}
			
			if($blank)
			{
				echo '0';
			}
			
			fclose($handle);
		}
		else{
			echo '0';
		}	
	}else
	{
		echo "0";
	}
}
?>