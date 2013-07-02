<?
function getClick($serial)
{
	$q = "select count from deal_content_analytics where serial=$serial";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			return $rs[0];
		}
		return 0;
	}
	return 0;
}
function getInstall($serial)
{
	$q = "select count(*) from track_install where app_id=$serial";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			return $rs[0];
		}
	}
	return 0;
}
function getClaim($serial)
{
	$q = "select count(*) from callback_log where game_id=$serial AND status=1";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			return $rs[0];
		}
	}
	return 0;
}
function installReport()
{
	$deal_id = getFirstDealId();
	?>
	<fieldset>
		<legend><span>Install Report</span></legend>
		<form name="sreport" id="sreport" method="post" action="">
		<div>
			Please select your Deal: 
			<select name="deal_id" id="deal_id">
			<?
			if(isset($_POST['deal_id']))
			{
				$deal_id = $_POST['deal_id'];
			}
			getDealCombo($deal_id);
			?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<input name="submit" type="submit" id="save" value="submit">
		</div>
		</form>
		<br><br>
		<table width="100%" border="0" cellspacing="2" cellpadding="0" id="table">
		  <tr>
			<th>Game Image </th>
			<th>Name</th>
			<th>Total Click</th>
			<th>Total Install</th>
			<th>Total Buy</th>
			<th>Amount Claimed</th>
		  </tr>
		  <?
		  global $siteUrl;
		  $games = getGameByDeal($deal_id);
		  for($i=0; $i<count($games); $i++)
		  {
			$gInfo = getGameInfo($games[$i]);
			$buy = getDealSold($deal_id);
		  ?>
		  <tr>
			<td valign="top"><img src="<?=$siteUrl."deal_image/".$gInfo['game_image']?>" width="100"/></td>
			<td valign="top"><?=$gInfo['game_name']?></td>
			<td valign="top"><?=getClick($gInfo['serial'])?></td>
			<td valign="top"><?=getInstall($gInfo['serial'])?></td>
			<td valign="top"><?=$buy?></td>
			<td valign="top"><?=getClaim($gInfo['serial'])?></td>
		  </tr>
		  <?
		  }
		  ?>
		</table>
	</fieldset>
	<?
}
?>