<?
include_once "dbInteracter.php";
$fbid=0;
if (isset($_POST['fb_sig_user']))
{
	$fbid=$_POST['fb_sig_user'];
}

$q="select user_id from user where fb_id=$fbid";
$r=executeQuery($q);
$d=getRecords($r);

if($d)
{
	echo $d[0];
}

?>