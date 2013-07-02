<?
include_once("../functions.php");
include_once("../editDealFunctions.php");
include_once("../addUserFunctions.php");

isLogin();
if(isset($_GET['pro']))
{
	$pro = $_GET['pro'];
	
	if($pro == "editgame")
	{
		$serial = $_GET['serial'];
		$deal_id = $_GET['deal_id'];
		editGamePage($serial,$deal_id);
	}
	else if($pro == "editUser")
	{
		$userId = $_GET['userId'];
		editUserPage($userId);
	}
	else if($pro == "chPass")
	{
		$userId = $_GET['userId'];
		getPassChangePage($userId);
	}
}
?>