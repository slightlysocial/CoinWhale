<?
function changePass($npass)
{
	$q = "update cms_user set password='".md5($npass)."' where cuser_id=".$_SESSION['uid']."";
	executeQuery($q);
}

function checkOldPass($opass)
{
	$opass = md5($opass);
	$q = "select count(*) from cms_user where password='$opass' AND cuser_id = ".$_SESSION['uid']."";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		if($rs=getRecords($res_id))
		{
			if($rs[0])
			{
				return true;
			}
		}
	}
	return false;
}
function chPass()
{
	if(isset($_POST['opass']))
	{
		$opass = $_POST['opass'];
		$npass = $_POST['npass'];
		$rpass = $_POST['rpass'];
		
		if($npass == "")
		{
			echo '<div id="warning" class="info_div"><span class="ico_error">Sorry! New password cannot be empty!!!</span></div>';
		}
		else if($npass != $rpass)
		{
			echo '<div id="warning" class="info_div"><span class="ico_error">Sorry! Password didnt match!!!</span></div>';
		}
		else if(!checkOldPass($opass))
		{
			echo '<div id="warning" class="info_div"><span class="ico_error">Sorry! Old password didnt match!!!</span></div>';
		}
		else
		{
			changePass($npass);
			echo '<div id="success" class="info_div"><span class="ico_success">Yeah! Success!</span></div>';
		}
	}	
	?>
	<form action="" method="post" name="chPass">
	<fieldset>
		<legend><span>Change Password</span></legend>
	<table width="400" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
	  <tr>
		<td>Old Password: </td>
		<td>
		  <input type="password" name="opass" id="opass">
		</td>
	  </tr>
	  <tr>
		<td>New Password: </td>
		<td>
		  <input type="password" name="npass" id="npass">
		</td>
	  </tr>
	  <tr>
		<td>Re-type Password: </td>
		<td>
		  <input type="password" name="rpass" id="rpass">
		</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
		  <input type="submit" name="Submit" value="Submit" id="save">
		</td>
	  </tr>
	</table>
	</form>
	</fieldset>
	<?
}
?>