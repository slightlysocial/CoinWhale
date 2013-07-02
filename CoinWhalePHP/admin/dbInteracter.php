<?php
//error_reporting(2047);
//include_once ('jsonwrapper/jsonwrapper.php');

$dbhost = 'localhost'; $dbname = 'coinwhale'; $dbuser = 'tashfique'; $dbpasswd ='yGPTtS4HfpUpZMT7';

global $link;
$link = -1;

date_default_timezone_set("America/New_York");

function executeQuery($strQuery)
{
	$strQuery = str_replace(";", "", $strQuery);
	
	global $link;
	if($link == -1)
	{
		$link = getDBConn();
	}
	if($res_id=mysql_query($strQuery, $link))
	{	
		return $res_id;
	}
}
function getSystemDate($hr = 0){
	
	$time = time() + ($hr * 60 * 60);
	return date("Y-m-d H:i:s", $time);
}

function getSystemDateOnly($d = 0)
{
	$time = time() + ($d * 24 * 60 * 60);
	return date("Y-m-d", $time);
}

function getSystemTime($min = 0)
{
	$time = time() + ($min * 60);
	return $time;
}
function getSystemTimeDay($d = 0)
{
	$time = time() + ($d * 24 * 60 * 60);
	return $time;
}

function getFieldName($res_id,$index){
	return mysql_field_name($res_id,$index);
}

function getNumRows($strQuery){	
	if(!executeQuery($strQuery))
	{
		return 0;
	}else{
		return mysql_num_rows($res_id=(executeQuery($strQuery)));
	}
}
function getNumRowsFromRes($res){	
	if(!$res)
	{
		return 0;
	}else
	{
		return mysql_num_rows($res);
	}
}

function getRecords($res_id){
	if($res_id)
	{
		return mysql_fetch_row($res_id);
	}
	else
	{
		return '';
	}
}
function getAssocRecords($res_id){
	if($res_id)
	{
		return mysql_fetch_assoc($res_id);
	}
	else
	{
		return '';
	}
}
function getDBConn(){
	//check database connection
	global $dbhost, $dbuser, $dbpasswd;
	global $dbhost1, $dbuser1, $dbpasswd1;
	//global $link;
	$link=mysql_connect($dbhost, $dbuser, $dbpasswd);
	if(!$link)
	{
		echo("<div id='alert'>Server is busy. Please try again.</div>");
		doLog("Server is busy. Please try again.", LOG_ER);
		exit;
	}
	selectDB($link);
	return $link;
}

function selectDB($link){
	global $dbname;
	mysql_select_db($dbname,$link) ;
}

function logQ($r, $time)
{
	$line = $r." : ".$time;
	$myFile = "testFile.txt";
	$fh = fopen($myFile, 'a');
	if($fh)
	{
		$stringData = "$r : $time\n";
		fwrite($fh, $stringData);
		fclose($fh);
	}
}

function closeDB()
{
	global $link;
	if($link != -1)
	{
		mysql_close($link);
	}
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function getUserCountryCode($userId)
{
	/*
	$con = mysql_connect('localhost', 'root', 'as!@#$bk');
	mysql_select_db('GeoIP',$con) ;
	$q = "select cc from usercc where user_id = '$userId'";
	//echo $q;
	$r = mysql_query($q, $con);
	if($r)
	{
		$d = mysql_fetch_row($r);
		if($d)
		{
			return $d[0];
		}else
		{
			return false;
		}
	}else
	{
		return false;
	}
	*/
	return false;
}
function giveMyArray($result)
{
	$data = array();
	
	while ($row = mysql_fetch_assoc($result)) 
	{
		$data[] = $row;
	}

	return $data;
}

function giveThisArray($result)
{
	$data = "";
	
	while ($row = mysql_fetch_assoc($result)) 
	{
		$data = $row;
	}

	return $data;
}
?>
