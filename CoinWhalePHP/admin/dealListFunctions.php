<?
function dealListPage()
{
	$data = getDeal();
	?>
	<table width="100%"  class="display" id="example">
	  <thead>
	  <tr>
		<th width="7%">Deal Id </th>
		<th width="40%">Deal Title </th>
		<th width="10%">Start Date </th>
		<th width="10%">End Date </th>
		<th width="8%">Total Qty</th>
		<th width="8%">Qty Sold</th>
		<th width="13%">Status</th>
		<th>&nbsp;</th>
	  </tr>
	  </thead>
	  <tbody>
	  <?
	  for($i=0; $i<count($data); $i++)
	  {
	  ?>
		  <tr>
			<td><?=$data[$i]['deal_id']?></td>
			<td><?=$data[$i]['deal_title']?></td>
			<td><?=date("d-M-Y",strtotime($data[$i]['start_date']))?></td>
			<td><?=date("d-M-Y",strtotime($data[$i]['end_date']))?></td>
			<td><?=$data[$i]['deal_quantity']?></td>
			<td><?=getDealSold($data[$i]['deal_id'])?></td>
			<td><?=getStatus($data[$i]['status'],$data[$i]['deal_id'])?></td>
			<td>
				<a href="editDeal.php?deal_id=<?=$data[$i]['deal_id']?>"><div class="ico_edit" title="Edit">&nbsp;</div></a>
			</td>
		  </tr>
	  <?
	  }
	  ?>
	  </tbody>
	</table>
	<?
}
?>