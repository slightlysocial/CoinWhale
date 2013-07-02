<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
error_reporting(0);
include_once("paymentFunctions.php");
	
$q="select serial from callback_log where status!=1";
$r=executeQuery($q);
while($d=getRecords($r))
{
	$cl_id=$d[0];
	//echo "$cl_id";
	redeem_callback($cl_id);
}
?>
