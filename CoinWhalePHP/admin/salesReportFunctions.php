<?
function getSalesByDeal($deal_id)
{
	$data = array();
	$count = 0;
	$q = "select * from user_buy where deal_id=$deal_id AND status=1 order by buy_id desc";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		while($rs=getAssocRecords($res_id))
		{
			$data[$count]['buy_id'] = $rs['buy_id'];
			$data[$count]['user_id'] = $rs['user_id'];
			$data[$count]['deal_id'] = $rs['deal_id'];
			$data[$count]['buy_qty'] = $rs['buy_qty'];
			$data[$count]['pro_price'] = $rs['pro_price'];
			$data[$count]['total_price'] = $rs['total_price'];
			$data[$count]['total_retail'] = $rs['total_retail'];
			$data[$count]['pay_type'] = $rs['pay_type'];
			$data[$count]['buy_date'] = $rs['buy_date'];
			$count++;
		}
	}
	return $data;
}
function salesReport()
{
	$deal_id = getFirstDealId();
	?>
	<fieldset>
		<legend><span>Sales Report</span></legend>
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
	<table width="100%" class="display" id="example">
	  <thead>
	  <tr>
	  	<th>Buy Id</th>
		<th>Buy Date </th>
		<th>User Name </th>
		<th>Email</th>
		<th>Qty</th>
		<th>Pro Price </th>
		<th>Pay type </th>
		<th>Total</th>
	  </tr>
	  </thead>
	  <tbody>
	  <?
	  	$data = getSalesByDeal($deal_id);
		$tQty = 0; $tPrice = 0;
	  	if(count($data))
	  	{
		  	for($i=0; $i<count($data); $i++)
		  	{
				$uInfo = getUserInfo($data[$i]['user_id']);
				if($uInfo['not_email'] != NULL)
				{
					$email = $uInfo['not_email'];
				}
				else
				{
					$email = "None";
				}
				?>
				<tr>
					<td><?=$data[$i]['buy_id']?></td>
					<td><?=$data[$i]['buy_date']?></td>
					<td><a href="userInfo.php?user_id=<?=$data[$i]['user_id']?>"><?=$uInfo['name']?></a></td>
					<td><?=$email?></td>
					<td><?=$data[$i]['buy_qty']?></td>
					<td>$<?=$data[$i]['pro_price']?></td>
					<td><?=getPayType($data[$i]['pay_type'])?></td>
					<td>$<?=$data[$i]['total_price']?></td>
				</tr>
				<?
				$tQty += $data[$i]['buy_qty'];
				$tPrice += $data[$i]['total_price'];
		  	}
		}
		else
		{
		?>
		<tr><td colspan="6"><div align="center">No data found</div></td></tr>
		<?
		}
	  ?>
	  </tbody>
	  <tfoot>
	  <tr>
	  	<th colspan="4">Total</th>
		<th><?=$tQty?></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>$<?=number_format($tPrice,2)?></th>
	  </tr>
	  </tfoot>
	</table>
	</fieldset>
	<?
}
?>