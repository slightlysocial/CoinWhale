<?
// PHP 4.1

// read the post from PayPal system and add 'cmd'
include_once("paymentFunctions.php");

if(isset($_POST['secret']))
{
	$secret=$_POST['secret'];
	$check=md5("coinwhale");
	if($secret==$check)
	{
		$cl_id=0;
		if(isset($_POST['clid']))
		{
			$cl_id=$_POST['clid'];
			redeem_callback($cl_id);
		}
		
	}else
	{
		echo "0";
	}
	
}else
{
	echo "0";
}
?>
