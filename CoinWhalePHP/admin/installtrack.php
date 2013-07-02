<?
include_once("dbInteracter.php");

if(isset($_GET['install']))
{
	$install = $_GET['install'];
	if($install == 1)
	{
		$app_id = $_GET['app_id'];
		$fb_id = $_GET['fb_id'];
		insertInstall($app_id,$fb_id);
	}
}

function insertInstall($app_id,$fb_id)
{
	$date = getSystemDateOnly();
	$q = "insert into track_install values('','$app_id','$fb_id','$date')";
	executeQuery($q);
}
?>