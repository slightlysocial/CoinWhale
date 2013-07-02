<?
include_once "dbInteracter.php";
include_once "tabfunction.php";
$fbid=0;
$user_id=0;
$name="";
$fname="";
$lname="";
$not_email="";
if (isset($_POST['fb_sig_user']))
{
	$fbid=$_POST['fb_sig_user'];
}

$q="select * from user where fb_id=$fbid";
$r=executeQuery($q);
$d=getRecords($r);

if($d)
{
	$user_id=$d[0];
	$name=$d[2];
	$fname=$d[3];
	$lname=$d[4];
	
	$not_email=$d[6];
	 if(isset($not_email) && !empty($not_email))
	{
		
	}else
	{
		renderEmailBox($user_id,$fname);
	}
	//
	
}else
{
	renderRegisterUser($fbid);
}


?>