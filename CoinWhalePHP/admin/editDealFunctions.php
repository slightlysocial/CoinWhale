<?
function deleteGame()
{
	$serial = $_GET['serial'];
	$gInfo = getGameInfo($serial);
	unlink($gInfo['game_image']);
	
	$q = "delete from deal_content where serial=$serial";
	executeQuery($q);
	success("Successfully deleted game information");
}
function updateGameInfo()
{
	$serial = $_POST['serial'];
	$gname = $_POST['gname'];
	$stitle = $_POST['stitle'];
	$camt = $_POST['camt'];
	$cvalue = $_POST['cvalue'];
	$cname = $_POST['cname'];
	$curl = $_POST['curl'];
	$oemail = $_POST['oemail'];
	$gurl = $_POST['gurl'];
	
	$gimg = uploadImg();
	if($gimg)
	{
		$gInfo = getGameInfo($serial);
		unlink("deal_image/".$gInfo['game_image']);
		$q = "update deal_content set game_name='$gname',short_title='$stitle',game_image='$gimg',credit_amt='$camt',credit_val='$cvalue',currency_name='$cname',callback_url='$curl',owner_email='$oemail',game_url='$gurl' where serial=$serial";
		executeQuery($q);
		success("Successfully updated game information");
	}
	else
	{
		$q = "update deal_content set game_name='$gname',short_title='$stitle',credit_amt='$camt',credit_val='$cvalue',currency_name='$cname',callback_url='$curl',owner_email='$oemail',game_url='$gurl' where serial=$serial";
		executeQuery($q);
		success("Successfully updated game information");
	}
}
function updateDealInfo($deal_id)
{
	$status = $_POST['status'];
	$deal_title = $_POST['deal_title'];
	$price = $_POST['price'];
	$retail_price = $_POST['retail_price'];
	$deal_quantity = $_POST['deal_quantity'];
	$sdate = $_POST['sdate']." 00:00:00";
	$edate = $_POST['edate']." 23:59:59";
	$vlink = $_POST['vlink'];
	$short_desc = addslashes($_POST['short_desc']);
	$date = getSystemDateOnly();
	
	$q = "update deal set deal_title='$deal_title',short_desc='$short_desc',price='$price',retail_price='$retail_price',start_date='$sdate',end_date='$edate',deal_quantity='$deal_quantity',status='$status',vedio_link='$vlink' where deal_id=$deal_id";
	//echo $q;
	executeQuery($q);
	return true;
}
function editDealPage()
{
	if(isset($_GET['deal_id']))
	$deal_id = $_GET['deal_id'];
	$dInfo = getDealInfo($deal_id);
	if(!$dInfo)
	{
		reDirect("dealList.php");
	}
	
	if(isset($_GET['delete']))
	{
		deleteGame();
	}
	if(isset($_POST['deal_title']))
	{
		if(updateDealInfo($deal_id))
		{
			success("Successfully updated the deal information");
		}
		$dInfo = getDealInfo($deal_id);
	}
	if(isset($_POST['gname']))
	{
		updateGameInfo();
	}
	?>
	<form name="myForm" id="myForm" action="editDeal.php?deal_id=<?=$deal_id?>" method="post">
		<fieldset>
		<legend><span>Deal Information</span></legend>
		<table class="table_form" cellpadding="0" cellspacing="5" border="0">
			<tr>
				<td width="100">Deal Approval:</td>
				<td>
				<select name="status">
				<?
				$id = $dInfo['status'];
				dealStatusCombo($id);
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td width="100">Deal Title:</td>
				<td><input style="width: 579px" type="text" id="deal_title" name="deal_title" value="<?=$dInfo['deal_title']?>"/></td>
			</tr>
			<tr>
				<td>Price:</td>
				<td><input type="text" id="price" name="price" value="<?=$dInfo['price']?>"></td>
			</tr>
			<tr>
				<td>Retail Price:</td>
				<td><input type="text" id="retail_price" name="retail_price" value="<?=$dInfo['retail_price']?>"></td>
			</tr>
			<tr>
				<td>Deal Quantity:</td>
				<td><input type="text" id="deal_quantity" name="deal_quantity" value="<?=$dInfo['deal_quantity']?>"></td>
			</tr>
			<tr>
				<td>Start Date:</td>
				<td>
					<input type="text" id="sdate" name="sdate" readonly="readonly" class="datepicker" value="<?=date("Y-m-d",strtotime($dInfo['start_date']))?>">
				</td>
			</tr>
			<tr>
				<td>End Date:</td>
				<td>
					<input type="text" id="edate" name="edate" readonly="readonly" class="datepicker" value="<?=date("Y-m-d",strtotime($dInfo['end_date']))?>">
				</td>
			</tr>
			<tr>
				<td>Vedio Link:</td>
				<td><input type="text" id="vlink" name="vlink" value="<?=$dInfo['vedio_link']?>"></td>
			</tr>
			<tr>
				<td style="vertical-align:top;">Short Description:</td>
				<td><textarea class="mce" rows="4" cols="70"  id="short_desc" name="short_desc"><?=stripslashes($dInfo['short_desc'])?></textarea></td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Update" id="save" /></td>
			</tr>
		</table>
		</fieldset>
	</form>
	<fieldset>
		<legend><span>Game List</span></legend>
		<table width="100%" border="0" cellspacing="2" cellpadding="0" id="table">
		  <tr>
		  	<th width="10%">Game ID# </th>
			<th width="10%">Game Image </th>
			<th width="10%">Name</th>
			<th width="20%">Short Title</th>
			<th width="10%">Credit Amt </th>
			<th width="10%">Credit Value </th>
			<th width="10%">Curr Name </th>
			<th width="10%">Owner Email </th>
			<th width="10%">&nbsp;</th>
		  </tr>
		  <?
		  global $siteUrl;
		  
		  $games = getGameByDeal($deal_id);
		  for($i=0; $i<count($games); $i++)
		  {
		  	$gInfo = getGameInfo($games[$i]);
		  ?>
		  <tr>
		  	<td valign="top"><?=$games[$i]?></td>
			<td valign="top"><img src="<?=$siteUrl."deal_image/".$gInfo['game_image']?>" width="100"/></td>
			<td valign="top"><?=$gInfo['game_name']?></td>
			<td valign="top"><?=$gInfo['short_title']?></td>
			<td valign="top"><?=$gInfo['credit_amt']?></td>
			<td valign="top"><?=$gInfo['credit_val']?></td>
			<td valign="top"><?=$gInfo['currency_name']?></td>
			<td valign="top"><?=$gInfo['owner_email']?></td>
			<td valign="top" align="right">
				<a href="ajaxcall/facebox.php?pro=editgame&serial=<?=$gInfo['serial']?>&deal_id=<?=$deal_id?>" title="Edit" rel="facebox">
					<span class="ico_edit">&nbsp;</span>
				</a>&nbsp;
				<a href="editDeal.php?deal_id=<?=$deal_id?>&delete=1&serial=<?=$gInfo['serial']?>" title="Delete" onClick="return checkDelete('Are you sure to delete it???');">
					<span class="ico_cancel">&nbsp;</span>
				</a>
			</td>
		  </tr>
		  <?
		  }
		  ?>
		</table>
	</fieldset>
	<?
}
function editGamePage($serial,$deal_id)
{
	$gInfo = getGameInfo($serial);
	?>
	<form action="editDeal.php?deal_id=<?=$deal_id?>" method="post" enctype="multipart/form-data" name="addgame" id="addgame">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120">Game Name: </td>
			<td><input type="text" name="gname" id="gname" value="<?=$gInfo['game_name']?>" /></td>
		  </tr>
		  <tr>
			<td>Short Title: </td>
			<td><input type="text" name="stitle" id="stitle" value="<?=$gInfo['short_title']?>"  /></td>
		  </tr>
		  <tr>
			<td>Game Image: </td>
			<td><input type="file" name="gimg" id="gimg" /></td>
		  </tr>
		  <tr>
			<td>Credit Amount: </td>
			<td><input type="text" name="camt" id="camt" value="<?=$gInfo['credit_amt']?>"  /></td>
		  </tr>
		  <tr>
			<td>Credit Value: </td>
			<td><input type="text" name="cvalue" id="cvalue"  value="<?=$gInfo['credit_val']?>" /></td>
		  </tr>
		  <tr>
			<td>Currency Name: </td>
			<td><input type="text" name="cname" id="cname" value="<?=$gInfo['currency_name']?>"  /></td>
		  </tr>
		  <tr>
			<td>Callback URL: </td>
			<td><input type="text" name="curl" id="curl" value="<?=$gInfo['callback_url']?>"  /></td>
		  </tr>
		  <tr>
			<td>Owner Email: </td>
			<td><input type="text" name="oemail" id="oemail" value="<?=$gInfo['owner_email']?>"  /></td>
		  </tr>
		  <tr>
			<td>Game URL: </td>
			<td><input type="text" name="gurl" id="gurl" value="<?=$gInfo['game_url']?>"  /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input name="Submit" type="submit" value="Update Game" id="save" /></td>
		  </tr>
		</table>
		<input type="hidden" name="serial" value="<?=$serial?>" />
		</form>
	<?
}
?>