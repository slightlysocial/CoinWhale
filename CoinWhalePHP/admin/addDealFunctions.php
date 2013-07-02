<?
function insertDeal()
{
	$deal_title = $_POST['deal_title'];
	$price = $_POST['price'];
	$retail_price = $_POST['retail_price'];
	$deal_quantity = $_POST['deal_quantity'];
	$sdate = $_POST['sdate']." 00:00:00";
	$edate = $_POST['edate']." 23:59:59";
	$vlink = $_POST['vlink'];
	$short_desc = addslashes($_POST['short_desc']);
	$date = getSystemDateOnly();
	
	$q = "insert into deal values('','$deal_title','$short_desc','$price','$retail_price','$sdate','$edate','$deal_quantity','$date','0','$vlink')";
	//echo $q; exit;
	executeQuery($q);
	return true;
}
function addDealPage()
{
	if(isset($_POST['deal_title']))
	{
		if(insertDeal())
		{
			success("Successfully inserted the deal");
		}
	}
	?>
	<form name="myForm" id="myForm" action="" method="post">
		<fieldset>
		<legend><span>Deal Information</span></legend>
		<table class="table_form" cellpadding="0" cellspacing="5" border="0">
	
			<tr>
				<td width="100">Deal Title:</td>
				<td><input style="width: 579px" type="text" id="deal_title" name="deal_title"/></td>
			</tr>
			<tr>
				<td>Price:</td>
				<td><input type="text" id="price" name="price"></td>
			</tr>
			<tr>
				<td>Retail Price:</td>
				<td><input type="text" id="retail_price" name="retail_price"></td>
			</tr>
			<tr>
				<td>Deal Quantity:</td>
				<td><input type="text" id="deal_quantity" name="deal_quantity"></td>
			</tr>
			<tr>
				<td>Start Date:</td>
				<td><input type="text" id="sdate" name="sdate" readonly="readonly" class="datepicker"></td>
			</tr>
			<tr>
				<td>End Date:</td>
				<td><input type="text" id="edate" name="edate" readonly="readonly" class="datepicker"></td>
			</tr>
			<tr>
				<td>Vedio Link:</td>
				<td><input type="text" id="vlink" name="vlink"></td>
			</tr>
			<tr>
				<td style="vertical-align:top;">Short Description:</td>
				<td><textarea class="mce" rows="4" cols="70"  id="short_desc" name="short_desc"></textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Save" id="save" /></td>
			</tr>
		</table>
		</fieldset>
	</form>
	<?
}
?>