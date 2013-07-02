<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
error_reporting(0);
require_once 'zferralApi/ZferralLoader.php';
$c = new ZferralCookie();

include_once("paymentFunctions.php");

$a = $_GET['a'];
if($a != "spare"){
	echo "Unauthorize access";
	exit;
}
if(isset($_GET['points']) && isset($_GET['amount']) && isset($_GET['txId']) && isset($_GET['senderId'])){
	
	
	if($a =="spare")
	{
		$date = getSystemDateOnly();
		$user_id=$_GET['senderId'];
		$points=$_GET['points'];
		$amount=$_GET['amount'];
		$txId=$_GET['txId'];
		$buy_id=$_GET['callerTxId'];
		//echo $callerTxId;
		$referer="";
		$q="select refer_id from user_buy_refer where buy_id=$buy_id";
		$r=executeQuery($q);
		$d=getRecords($r);
		if($d)
		{
			$referer=$d[0];
		}
		
		$deal_id=getDealByBuyId($buy_id);
		//$q="select user_id from ";
		
		$q="select status,user_id from user_buy where buy_id=$buy_id";
		$r=executeQuery($q);
		$d=getRecords($r);
		if($d)
		{
		//echo "dealid ".$deal_id;
			$status=$d[0];
			$user_id=$d[1];
			if($status==0)
			{
				
				if($deal_id>0)
				{
					//$user_id=$dealInfo["user_id"];
					//$deal_id=$dealInfo["deal_id"];
					insertScLog($deal_id,$points,$amount,$txId,$user_id,1,$date);
					processDeal($deal_id,$user_id,$buy_id);
					
					$con = new ZferralConnector($apikey, $subdomain);

				$call = $con->call(
                    'event',
                    array(
                     'campaign_id'   => 1,           // NOTE: This is the ID of your campaign in zferral

                     'revenue'       => $amount,        // NOTE: Enter the price of your product
                     'customer_id'   => $user_id, // NOTE: Enter ID of customer who completed the event

                     'unique_id'     => $txId,   // NOTE: (OPTIONAL) Enter some unique ID for extra security
                     'ignore_cookie' => 1,
                     'referer'      => $referer,

                    ));
					//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$amount.'&customerId='.$user_id.'&uniqueId='.$txId.'" style="border: none; display: none" alt=""/>';
						
					//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$amount.'&customerId='.$user_id.'&uniqueId='.$txId.'&ignoreCookie=1" style="border: none; display: none" alt=""/>';
		
					echo "OK";
					
				}else
				{
					
					echo "0";
				}
			}else
			{
				
				echo "OK";
			}
	}else
	{
		insertScFailLog($deal_id,$points,$amount,$txId,$user_id,0,$date);
		echo "0";
	}
	
		
	}else
	{
		echo "0";
	}
}
?>
