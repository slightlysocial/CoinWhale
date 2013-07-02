<?
//error_reporting(2047);
function renderEmailBox($uid,$fname="",$lname="")
{
	?>
	<script language="javascript" type="text/javascript">
	
	
    function registerUserEmail()
	{
		var error=false;
		var uid=<?=$uid?>;
		var fname=<?=$fname?>;
		var lname=<?=$lname?>;
		
		var message=document.getElementById('message');
		//var firstName=document.getElementById('fname').getValue();
		//var lastName=document.getElementById('lname').getValue();
		var email=document.getElementById('email').getValue();
		if(email=="")
		{
			message.setTextValue("Please full fill the required field.");
			error=true;
		}
		//message.setTextValue("yo");
		if(!error)
		{
			message.setTextValue("Registration processing ! Please wait.....");
			//var div=document.getElementById('container');	 
			var ajax                = new Ajax();
			 ajax.responseType       = Ajax.FBML;
			 
			 ajax.ondone        = function(data){
				message.setInnerFBML(data);
				var value=parseInt(data);
				if(value==1)
				{
					message.setTextValue("Registration Successfull!! Please wait...");
					loadcontain();
				}else
				{
					message.setTextValue("Sorry plaese try again!!");
				}
			 }
			 
			 ajax.onerror = function(){
				//div.setTextValue("error");
			 }
				 ajax.requireLogin = true;
				 var params = {'fname':''+fname,'lname':''+lname,'email':''+email,'uid':''+uid};
				 ajax.post('http://www.coinwhale.com/ajax/registerEmail', params);
				 return true;
				}
	}
    </script>
	<?
	echo "<div style='text-align:center;'><h1>Welcome $name</h1></div>";
	echo "<div style='padding:40px'>We give you crazy deals on your favourite Games on Facebook! Join CoinWhale to get free items and the above mentioned awsome deals.</div>";
	echo "<div style='text-align:center;'><h1>Now for the good part</h1></div>";
	echo "<div style='padding:20px 40px 20px 40px'>";
	echo "<div >Enter your email for <font style='color:#3CA6CD;font-size:23px;'>a chance to win $100</font> to spend on your favourite Facebook games!</div>";
	echo "<div>&nbsp;</div>";
	//echo "<div>&nbsp;</div>";
	echo "<table cellpadding='0' cellspacing='5' border='0' width='100%'>";
	echo "<tr>";
	echo "<td colspan='2'><div id='message' style='color:#ff0000;text-align:center;'></div></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>Email Address</td>";
	echo "<td width='65%'><input id='email' name='email' type='text' class='input'/>*</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' colspan='2'><div align='center'><input type='button' value='Subscribe' onclick='registerUserEmail()'/></div></td>";
	echo "</tr>";
	echo "</table>";
	echo"</div>";
}

function renderRegisterUser($fbid)
{
	
	?>
	<script language="javascript" type="text/javascript">
	
	
    function registerUser()
	{
		var error=false;
		var uid=<?=$fbid?>;
		var message=document.getElementById('message');
		var firstName=document.getElementById('fname').getValue();
		var lastName=document.getElementById('lname').getValue();
		var email=document.getElementById('email').getValue();
		if(firstName=="")
		{
			message.setTextValue("Please full fill the required field.");
			error=true;
		}else if(email=="")
		{
			message.setTextValue("Please full fill the required field.");
			error=true;
		}
		//message.setTextValue("yo");
		if(!error)
		{
			message.setTextValue("Registration processing ! Please wait.....");
			//var div=document.getElementById('container');	 
			var ajax                = new Ajax();
			 ajax.responseType       = Ajax.RAW;
			 
			 ajax.ondone        = function(data){
				//div.setInnerFBML(data);
				var value=parseInt(data);
				if(value==1)
				{
					message.setTextValue("Registration Successfull!! Please wait...");
					loadcontain();
				}else
				{
					message.setTextValue("Sorry plaese try again!!");
				}
			 }
			 
			 ajax.onerror = function(){
				//div.setTextValue("error");
			 }
				 ajax.requireLogin = true;
				 var params = {'fname' : ''+firstName,'lname':''+lastName,'email':''+email,'uid':''+uid};
				 ajax.post('http://www.coinwhale.com/ajax/registerUser', params);
				 return true;
				}
	}
    </script>
	<?
	echo "<div style='padding:40px'>We give you crazy deals on your favourite Games on Facebook! Join CoinWhale to get free items and the above mentioned awsome deals.</div>";
	echo "<div style='text-align:center;'><h1>Now for the good part</h1></div>";
	echo "<div style='padding:20px 40px 20px 40px'>";
	echo "<div >Enter your email for <font style='color:#3CA6CD;font-size:23px;'>a chance to win $100</font> to spend on your favourite Facebook games!</div>";
	echo "<div>&nbsp;</div>";
	//echo "<div>&nbsp;</div>";
	echo "<table cellpadding='0' cellspacing='5' border='0' width='100%'>";
	echo "<tr>";
	echo "<td colspan='2'><div id='message' style='color:#ff0000;text-align:center;'></div></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>First Name</td>";
	echo "<td width='65%'><input id='fname' name='fname' type='text' class='input'/>*</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>Last Name</td>";
	echo "<td width='65%'><input id='lname' name='lname' type='text' class='input'/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>Email Address</td>";
	echo "<td width='65%'><input id='email' name='email' type='text' class='input'/>*</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' colspan='2'><div align='center'><input type='button' value='Subscribe' onclick='registerUser()'/></div></td>";
	echo "</tr>";
	echo "</table>";
	echo"</div>";
}

function renderCurrentDeal()
{
	
}
?>
