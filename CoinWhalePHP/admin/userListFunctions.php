<?
function chPass()
{
	$userId = $_POST['userId'];
	$pass = md5($_POST['pass']);
	$q = "update cms_user set password='$pass' where cuser_id=$userId";
	//echo $q;
	executeQuery($q);
	return true;
}
function deleteUser()
{
	$userId = $_GET['delete'];
	$q = "delete from cms_user where cuser_id=$userId";
	//echo $q;
	executeQuery($q);
	return true;
}
function updateUser()
{
	$userId = $_POST['userId'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	
	if($name != "" && $email != "")
	{
		$q = "update cms_user set name='$name',email='$email' where cuser_id='$userId'";
		//echo $q;
		executeQuery($q);
		return true;
	}
	else
	{
		return false;
	}
}
function getUserList()
{
	$data = array();
	$count = 0;
	$q = "select * from cms_user";
	//echo $q; exit;
	if($res_id=executeQuery($q))
	{
		while($rs=getAssocRecords($res_id))
		{
			$data[$count]['cuser_id'] = $rs['cuser_id'];
			$data[$count]['name'] = $rs['name'];
			$data[$count]['email'] = $rs['email'];
			$data[$count]['reg_date'] = $rs['reg_date'];
			$count++;
		}
	}
	return $data;
}
function userListPage()
{
	if(isset($_POST['name']))
	{
		if(updateUser())
		{
			echo '<div id="success" class="info_div"><span class="ico_success">Yeah! Success!</span></div>';
		}
		else
		{
			echo '<div id="warning" class="info_div"><span class="ico_error">Sorry! You have to provide all information!</span></div>';
		}
	}
	else if(isset($_GET['delete']))
	{
		if(deleteUser())
		{
			echo '<div id="success" class="info_div"><span class="ico_success">Yeah! Success!</span></div>';
		}
	}
	else if(isset($_POST['pass']))
	{
		if(chPass())
		{
			echo '<div id="success" class="info_div"><span class="ico_success">Yeah! Success!</span></div>';
		}
	}
	$data = getUserList();
	?>
	<fieldset>
		<legend><span>User List for Edit/Delete</span></legend>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table">
		  <tr>
			<th scope="col" width="50">SL No</th>
			<th scope="col">Name</th>
			<th scope="col">Email</th>
			<th scope="col">Registered</th>
			<th scope="col" width="100">Action</th>
		  </tr>
		  <?
		  for($i=0; $i<count($data); $i++)
		  {
		  ?>
		  <tr>
			<td><?=($i+1)?></td>
			<td><?=$data[$i]['name']?></td>
			<td><?=$data[$i]['email']?></td>
			<td><?=$data[$i]['reg_date']?></td>
			<td>
			<a href="ajaxcall/facebox.php?pro=editUser&userId=<?=$data[$i]['cuser_id']?>" rel="facebox">
				<span class="ico_edit" title="Edit">&nbsp;</span>
			</a>
			<a href="?delete=<?=$data[$i]['cuser_id']?>" onclick="return checkDelete('Are you sure to delete this user???');">
				<span class="ico_cancel" title="Delete">&nbsp;</span>
			</a>
			<a href="ajaxcall/facebox.php?pro=chPass&userId=<?=$data[$i]['cuser_id']?>" rel="facebox">
				<span class="ico_settings" title="Change Password">&nbsp;</span>
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
?>