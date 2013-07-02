<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
error_reporting(2047);
include_once("paymentFunctions.php");
	
	/*$q="select buy_id,user_id,deal_id from user_buy where status=1";
	$r=executeQuery($q);
	$gcount=0;
	$gamecount=0;
	while($d=getRecords($r))
	{
	
				$buy_id=$d[0];
				$deal_id=$d[2];
				$user_id=$d[1];
				$games = getGameByDeal($deal_id);
				$buyInfo = getUserBuyInfo($buy_id);
				$userInfo=getUserInfo($user_id);
				//echo '<pre>';
				
				for($i=0; $i<count($games); $i++)
				{
					
					
					$gamesInfo = getGameInfo($games[$i]);
					//echo "<pre>";
					//print_r($gamesInfo);
					$q="select * from callback_log where buy_id=".$buy_id." and game_id=".$gamesInfo['serial'];	
					$count=getNumRows($q);
					
					if($count==0)
					{
					
					$signature=md5($deal_id."".$buy_id."".$gamesInfo['credit_amt']."".$userInfo['fb_id']);
					$path = $gamesInfo['callback_url']."?deal_id=".$deal_id."&buy_id=".$buy_id."&point=".$gamesInfo['credit_amt']."&user_id=".$userInfo['fb_id']."&signature=$signature";
					//echo $path; //exit(0);
					
					try{
							$handle = fopen($path, "r");
							if($handle) 
							{
								while (!feof($handle)) 
								{
									insertCallbacklog($buy_id,$gamesInfo['serial']);
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
					$gamecount++;
					}
				}
				$gcount++;
	}
		
		echo "Total Deal:$gcount and Total Game: $gamecount";*/
		$buyId=$_GET['bid'];	
		//$senderId=0;	
		$date = getSystemDateOnly();
		$q="select deal_id,user_id,buy_id from user_buy where buy_id=$buyId and status=0";
		$r=executeQuery($q);
		$d=getRecords($r);
		if($d)
		{
			$deal_id=$d[0];
			$user_id=$d[1];
			$buy_id=$d[2];
			processDeal($deal_id,$user_id,$buy_id);
			insertLog($deal_id,"ECHECK","20.00","USD","ECHECK","sagacityquest@yahoo.com","",$user_id,0,$date);
			echo "OK";
		}else
		{
			echo "ERROR";
		}
				
		
		
	
?>
