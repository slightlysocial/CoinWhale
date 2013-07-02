<?
session_start();
include_once("dbInteracter.php");

//$siteUrl = "http://localhost/Coinwhale/admin/";
$siteUrl = "http://www.coinwhale.com/admin/";

function getFirstDealId()
{
	$q = "select deal_id from deal order by insert_date desc";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			return $rs[0];
		}
	}
}
function isLogin()
{
	if(!isset($_SESSION['uid']))
	{
		reDirect("index.php");
	}
}
function reDirect($path)
{
	global $siteUrl;
	echo '
	<html>
		<body>
			<script language="javascript">
				location.href="'.$siteUrl.$path.'";
			</script>
		</body>
	  </html>';	
}
function notAuthorize()
{
	echo '
	<div align="center" class="authorize">You Are Not Authorize To View This Page</div>
	<div align="center"><img src="img/lock.jpg"></div>
	';
}
function success($msg,$flag = true)
{
	echo '
	<div class="success"><span class="icon_success">'.$msg.'</span></div>';
	if($flag)
	{
	?>
	<script>
	$(".success").show();
    $(".success").fadeOut(10000);
	</script>
	<?
	}
}
function error($msg,$flag = true)
{
	echo '
	<div class="error"><span class="icon_error">'.$msg.'</span></div>';
	if($flag)
	{
	?>
	<script>
	$(".error").show();
   	$(".error").fadeOut(10000);
	</script>
	<?
	}
}
function getDealCombo($deal_id)
{
	$q = "select deal_id,deal_title from deal order by insert_date desc";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		while($rs=getAssocRecords($res_id))
		{
			if($rs['deal_id'] == $deal_id)
			{
				echo '<option value="'.$rs['deal_id'].'" selected>'.$rs['deal_title'].'</option>';
			}
			else
			{
				echo '<option value="'.$rs['deal_id'].'">'.$rs['deal_title'].'</option>';
			}
		}
	}
}
function getDeal()
{
	$data = array();
	$count = 0;
	$q = "select * from deal order by insert_date desc";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		while($rs=getAssocRecords($res_id))
		{
			$data[$count]['deal_id'] = $rs['deal_id'];
			$data[$count]['deal_title'] = $rs['deal_title'];
			$data[$count]['short_desc'] = $rs['short_desc'];
			$data[$count]['price'] = $rs['price'];
			$data[$count]['retail_price'] = $rs['retail_price'];
			$data[$count]['start_date'] = $rs['start_date'];
			$data[$count]['end_date'] = $rs['end_date'];
			$data[$count]['deal_quantity'] = $rs['deal_quantity'];
			$data[$count]['insert_date'] = $rs['insert_date'];
			$data[$count]['status'] = $rs['status'];
			$count++;
		}
	}
	return $data;
}
function getDealSold($deal_id)
{
	$q = "select count(*) from user_buy where status=1 AND deal_id=$deal_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			return $rs[0];
		}
	}
}
function getDealInfo($deal_id)
{
	$q = "select * from deal where deal_id=$deal_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getAssocRecords($res_id))
		{
			return $rs;
		}
	}
	return false;
}
function isLive($deal_id)
{
	$date = date("Y-m-d");
	$q = "select count(*) from deal where status=1 AND ('$date' BETWEEN date_format(start_date,'%Y-%m-%d') AND date_format(end_date,'%Y-%m-%d')) AND deal_id=$deal_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			if($rs[0] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}
function getStatus($status,$deal_id)
{
	if(!isLive($deal_id) AND $status == 1)
	{
		echo '<span class="ico_cancel" title="Expired">&nbsp;</span> Expired';
	}
	else if($status == 1)
	{
		echo '<span class="ico_success" title="live">&nbsp;</span> Live';
	}
	else
	{
		echo '<span class="ico_pending" title="pending">&nbsp;</span> Pending';
	}
}
function getGameInfo($serial)
{
	$q = "select * from deal_content where serial=$serial";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getAssocRecords($res_id))
		{
			return $rs;
		}
	}
	return false;
}
function getUserBuyInfo($buy_id)
{
	$q = "select * from user_buy where buy_id=$buy_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getAssocRecords($res_id))
		{
			return $rs;
		}
	}
	return false;
}
function getUserInfo($user_id)
{
	$q = "select * from user where user_id=$user_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getAssocRecords($res_id))
		{
			return $rs;
		}
	}
	return false;
}
function getCMSUserInfo($user_id)
{
	$q = "select * from cms_user where cuser_id=$user_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getAssocRecords($res_id))
		{
			return $rs;
		}
	}
	return false;
}
function getGameByDeal($deal_id)
{
	$data =  array();
	$count = 0;
	$q = "select serial from deal_content where deal_id=$deal_id";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		while($rs=getRecords($res_id))
		{
			$data[$count] = $rs[0];
			$count++;
		}
	}
	return $data;
}
function dealStatusCombo($id)
{
	$stat = array("Approval Pending","Approved","For View Only");
	for($i=0; $i<count($stat); $i++)
	{
		if($id == $i)
		{
			echo '<option value="'.$i.'" selected>'.$stat[$i].'</option>';
		}
		else
		{
			echo '<option value="'.$i.'">'.$stat[$i].'</option>';
		}
	}
}
function getPayType($type)
{
	$ptypes = array("Free","Paypal","Spare Change");
	return $ptypes[$type];
}
?>