<?
include_once("../functions.php");

if(isset($_POST['pro']))
{
	$pro = $_POST['pro'];
	if($pro == "getAtt")
	{
		$att_id = $_POST['att_id'];
		$par_id = $_POST['par_id'];
		if(isset($_POST['style']) && isset($_POST['color']))
		{
			getAttCombo2($att_id,$par_id,$_POST['style'],$_POST['color']);
		}
		else if(isset($_POST['style']))
		{
			getAttCombo2($att_id,$par_id,$_POST['style']);
		}
		else
		{	
			getAttCombo2($att_id,$par_id);
		}
	}
	else if($pro == "getArt")
	{
		$catId = $_POST['catId'];
		getArtComboByCat($catId);
	}
	else if($pro == "setStatus")
	{
		$status = $_POST['status'];
		$id = $_POST['id'];
		changeRepairStat($status,$id);
	}
	else if($pro == "setInvStat")
	{
		$status = $_POST['status'];
		$id = $_POST['id'];
		changeInvStat($status,$id);
	}
	else if($pro == "getSizeTab")
	{
		$att_id = $_POST['att_id'];
		$par_id = $_POST['par_id'];
		$style = $_POST['style'];
		$color = $_POST['color'];
		getSizeTable($att_id,$par_id,$style,$color);
	}
	else if($pro == "setChallan")
	{
		$value = $_POST['value'];
		getChallanTable($value);
	}
	else if($pro == "storeChallan")
	{
		$value = $_POST['value'];
		$store = $_POST['store'];
		$rdate = $_POST['rdate'];
		$prio = $_POST['prio'];
		storeChallanTable($value,$store,$rdate,$prio);
	}
	else if($pro == "delInv")
	{
		$id = $_POST['id'];
		delInvById($id);
	}
	else if($pro == "delRepair")
	{
		$id = $_POST['id'];
		delRepairById($id);
	}
}
if(isset($_GET['pro']))
{
	$pro = $_GET['pro'];
	if($pro == "chDetails")
	{
		$id = $_GET['id'];
		getChallanView($id);
	}
}
?>