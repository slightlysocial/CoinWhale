<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
require_once 'zferralApi/ZferralLoader.php';
$c = new ZferralCookie();

include_once("paymentFunctions.php");

//$buyer_email = "w_sell_1289416740_biz@yahoo.com";
$buyer_email = "payment@coinwhale.com";
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$user_id = $_GET['user_id'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$date = getSystemDateOnly();
$buy_id=$_GET['buy_id'];
$referer=$_POST['custom'];
if (!$fp) 
{
	// HTTP ERROR
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) 
	{
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			// check the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your Primary PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment
			if(strcmp($payment_status,"Completed") == 0)
			{
				if(strcmp($receiver_email,$buyer_email) == 0)
				{
					
				}	
				
				insertLog($item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$user_id,0,$date);
				processDeal($item_number,$user_id,$buy_id);
				  /*$con = new ZferralConnector($apikey, $subdomain);

				  $call = $con->call(
					'event',
					array(
					 'campaign_id'   => 1,           // NOTE: This is the ID of your campaign in zferral
					 'revenue'       => $payment_amount,        // NOTE: Enter the price of your product
					 'customer_id'   => $user_id, // NOTE: Enter ID of customer who completed the event
					 'unique_id'     => $txn_id    // NOTE: (OPTIONAL) Enter some unique ID for extra security
					));
					
					*/
				$con = new ZferralConnector($apikey, $subdomain);

				//$con = new ZferralConnector($apikey, $subdomain);

				$call = $con->call(
                    'event',
                    array(
                     'campaign_id'   => 1,           // NOTE: This is the ID of your campaign in zferral

                     'revenue'       => $payment_amount,        // NOTE: Enter the price of your product
                     'customer_id'   => $user_id, // NOTE: Enter ID of customer who completed the event

                     'unique_id'     => $txn_id,   // NOTE: (OPTIONAL) Enter some unique ID for extra security
                     'ignore_cookie' => 1,
                     'referer'      => $referer,

                    ));


				
				//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$payment_amount.'&customerId='.$user_id.'&uniqueId='.$txn_id.'" style="border: none; display: none" alt=""/>';
				
				//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$payment_amount.'&customerId='.$user_id.'&uniqueId='.$txn_id.'&ignoreCookie=1" style="border: none; display: none" alt=""/>';
			}
		}
		else if (strcmp ($res, "INVALID") == 0) 
		{
			// log for manual investigation
			processDeal($item_number,$user_id,$buy_id);
			insertLog($item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$user_id,0,$date);
			//call_callback($deal_id,$buy_id);
			/* $con = new ZferralConnector($apikey, $subdomain);

				  $call = $con->call(
					'event',
					array(
					 'campaign_id'   => 1,           // NOTE: This is the ID of your campaign in zferral
					 'revenue'       => $payment_amount,        // NOTE: Enter the price of your product
					 'customer_id'   => $user_id, // NOTE: Enter ID of customer who completed the event
					 'unique_id'     => $txn_id    // NOTE: (OPTIONAL) Enter some unique ID for extra security
					));
					
				*/	

				$con = new ZferralConnector($apikey, $subdomain);
				
				  
				  
				$call = $con->call(
                    'event',
                    array(
                     'campaign_id'   => 1,           // NOTE: This is the ID of your campaign in zferral

                     'revenue'       => $payment_amount,        // NOTE: Enter the price of your product
                     'customer_id'   => $user_id, // NOTE: Enter ID of customer who completed the event

                     'unique_id'     => $txn_id,   // NOTE: (OPTIONAL) Enter some unique ID for extra security
                     'ignore_cookie' => 1,
                     'referer'      => $referer,

                    ));
			//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$payment_amount.'&customerId='.$user_id.'&uniqueId='.$txn_id.'" style="border: none; display: none" alt=""/>';
				
			//echo '<img src="http://coinwhale.zferral.com/e/1?rev='.$payment_amount.'&customerId='.$user_id.'&uniqueId='.$txn_id.'&ignoreCookie=1" style="border: none; display: none" alt=""/>';
		}
	}
	fclose ($fp);
}
/*$myFile = "testFile.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData .= "Payment Status: ".$payment_status."---Amount: ".$payment_amount."---Rec Email: ".$receiver_email."---Pay Email:  ".$payer_email."\n";
fwrite($fh, $stringData);
fclose($fh);
*/
?>
