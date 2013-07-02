<?
define ("MAX_SIZE","100"); 


function uploadImg()
{
	$errors = 0;
	$newname = "";
	$image_name="";
	$image = $_FILES['gimg']['name'];
 	//if it is not empty
 	if ($image) 
 	{
 		//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['gimg']['name']);
 		//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
		//otherwise we will do more tests
 		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
			//print error message
 			error("Unknown extension!");
 			$errors=1;
 		}
 		else
 		{
			//get the size of the image in bytes
 			//$_FILES['image']['tmp_name'] is the temporary filename of the file
 			//in which the uploaded file was stored on the server
 			$size=filesize($_FILES['gimg']['tmp_name']);

			//compare the size with the maxim size we defined and print error if bigger
			if ($size > MAX_SIZE*1024)
			{
				error("You have exceeded the size limit!");
				$errors=1;
			}
	
			//we will give an unique name, for example the time in unix time format
			$image_name=time().'.'.$extension;
			//the new name will be containing the full path where will be stored (images folder)
			$newname="deal_image/".$image_name;
			
			//we verify if the image has been uploaded, and print error instead
			$copied = copy($_FILES['gimg']['tmp_name'], $newname);
			if (!$copied) 
			{
				error("Copy unsuccessfull!");
				$errors=1;
			}
		}
	}
	//If no errors registred, print the success message
	if(!$errors) 
	{
		//echo "<h1>File Uploaded Successfully! Try again!</h1>";
		return $image_name;
	}
	else
	{
		return false;
	}
}
function getExtension($str) {
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}
function insertGame()
{
	$deal_id = $_POST['deal_id'];
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
		$q = "insert into deal_content values('','$deal_id','$gname','$stitle','$gimg','$camt','$cvalue','$cname','$curl','$oemail','$gurl')";
		executeQuery($q);
		success("Game added successfully");
	}
}
function addGamePage()
{
	if(isset($_POST['deal_id']))
	{
		insertGame();
	}
	?>
	<fieldset>
		<legend><span>Add Game To Deal</span></legend>
		
		<form action="" method="post" enctype="multipart/form-data" name="addgame" id="addgame">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Select Deal: </td>
			<td>
				<select name="deal_id" id="deal_id">
				<?
				$deal_id = -1;
				if(isset($_POST['deal_id'])){ $deal_id = $_POST['deal_id']; }
				getDealCombo($deal_id); 
				?>
			  	</select>
			</td>
		  </tr>
		  <tr>
			<td width="120">Game Name: </td>
			<td><input type="text" name="gname" id="gname" /></td>
		  </tr>
		  <tr>
			<td>Short Title: </td>
			<td><input type="text" name="stitle" id="stitle" /></td>
		  </tr>
		  <tr>
			<td>Game Image: </td>
			<td><input type="file" name="gimg" id="gimg" /></td>
		  </tr>
		  <tr>
			<td>Credit Amount: </td>
			<td><input type="text" name="camt" id="camt" /></td>
		  </tr>
		  <tr>
			<td>Credit Value: </td>
			<td><input type="text" name="cvalue" id="cvalue" /></td>
		  </tr>
		  <tr>
			<td>Currency Name: </td>
			<td><input type="text" name="cname" id="cname" /></td>
		  </tr>
		  <tr>
			<td>Callback URL: </td>
			<td><input type="text" name="curl" id="curl" /></td>
		  </tr>
		  <tr>
			<td>Owner Email: </td>
			<td><input type="text" name="oemail" id="oemail" /></td>
		  </tr>
		  <tr>
			<td>Game URL: </td>
			<td><input type="text" name="gurl" id="gurl" /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input name="Submit" type="submit" value="Add Game" id="save" /></td>
		  </tr>
		</table>
		</form>
	</fieldset>
	<?
}
?>