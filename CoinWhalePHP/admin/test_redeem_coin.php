<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
include_once("paymentFunctions.php");

		
		$cl_id=0;
		if(isset($_GET['clid']))
		{
			$cl_id=$_GET['clid'];
			//call_callback(13,299);
			//
			test_redeem_callback($cl_id);
		}