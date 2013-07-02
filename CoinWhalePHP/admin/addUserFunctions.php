<?
function insertAddUser()
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$pass = md5($_POST['pass']);
	$date = getSystemDateOnly();
	$datetime = getSystemDate();
	if($name != "" && $email != "" && $pass != "")
	{
		$q = "insert into cms_user values('','$name','$email','$pass','$date','$datetime')";
		executeQuery($q);
		return true;
	}
	else
	{
		return false;
	}
}
function addUser()
{
	if(isset($_POST['name']))
	{
		if(insertAddUser())
		{
			echo '<div id="success" class="info_div"><span class="ico_success">Yeah! Success!</span></div>';
		}
		else
		{
			echo '<div id="warning" class="info_div"><span class="ico_error">Sorry! You have to provide all information!</span></div>';
		}
	}
	?>
	<fieldset>
		<legend><span>Add CMS User</span></legend>
	<form action="" method="post" name="addUser">
	<table width="500" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
	  <tr>
		<td>Name:</td>
		<td><input type="text" name="name" id="name"></td>
	  </tr>
	  <tr>
		<td>Email:</td>
		<td><input type="text" name="email" id="email"></td>
	  </tr>
	  <tr>
		<td>Password:</td>
		<td><input type="text" name="pass" id="pass"></td>
	  </tr> 
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Submit" id="save"></td>
	  </tr>
	</table>
	</form>
	</fieldset>
	<?
}
function editUserPage($user_id)
{
	$uInfo = getCMSUserInfo($user_id);
	?>
	<fieldset>
		<legend><span>Edit CMS User</span></legend>
		<form action="" method="post" name="editUser">
		<input type="hidden" name="userId" id="userId" value="<?=$user_id?>" />
		<table width="500" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
		  <tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" value="<?=$uInfo['name']?>"></td>
		  </tr>
		  <tr>
			<td>Email:</td>
			<td><input type="text" name="email" id="email" value="<?=$uInfo['email']?>"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Submit" id="save"></td>
		  </tr>
		</table>
		</form>
	</fieldset>
	<?
}
function getPassChangePage($userId)
{
	?>
	<h3>Assign New Password</h3>
	<form action="userList.php" method="post" name="chPass">
	<input type="hidden" name="userId" value="<?=$userId?>" />
	<table width="500" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
	  <tr>
		<td>New Password:</td>
		<td><input type="text" name="pass" id="pass"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Submit" id="save"></td>
	  </tr>
	</table>
	</form>
	<?
}

?>