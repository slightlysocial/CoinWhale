<?
include_once("dbInteracter.php");

if(isset($_GET['sid']))
{
	$sid=$_GET['sid'];
	$q="select game_url from deal_content where serial=$sid";
	$r=executeQuery($q);
	$d=getRecords($r);
	if($d)
	{
		$url=$d[0];
		if($url!='')
		{
			$q="select count from deal_content_analytics where serial=$sid";
			$r=executeQuery($q);
			$d=getRecords($r);
			if($d)
			{
				$q="update deal_content_analytics set count=count+1 where serial=$sid";
				executeQuery($q);
			}else
			{
				$q="insert into deal_content_analytics values($sid,1)";
				executeQuery($q);
			}
			
			header("Location:".$url);
		}else
		{
			header("Location:http://www.coinwhale.com/");
		}
			
	}else
	{
		//echo "prob 2";
		header("Location:http://www.coinwhale.com/");
	}
	
}else
{
	echo "prob 1";
	header("Location:http://www.coinwhale.com/");
}

?>