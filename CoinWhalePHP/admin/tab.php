<style type='text/css'>

#wrapper {
		width:520px;
		height:auto;
		margin:0 auto; border:0; padding:0;
		position:relative;
		
}
#wrapper .top
{
	background:url(http://www.coinwhale.com/images/top.png?a) no-repeat;
	width:520px;
	height:100px;
}

#wrapper .header{
		background:url(http://www.coinwhale.com/images/header.png?c) no-repeat;
		width:520px;
		height:220px;
		font-size: 48px;
		font-family:Arial;
		font-weight:normal;
		text-align:center;
		color:#ffffff;	
		text-shadow:1px 1px 4px #000000;
		
		
}
#container
{
	
	padding:20px 20px 20px 30px;
}
#container .p1
{
	font-size: 18px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight:normal;
	text-align:justify;
}
#container .p2
{

	background:url(http://www.coinwhale.com/images/ooo.png) no-repeat;
	width:235px;
	height:25px;
	/*font-size: 24px;
	font-family:Arial;
	text-align:left;
	color:#FEB601;
	text-shadow:1px 1px 2px #000000;*/
}
#container .p3
{
	font-size: 18px;
	font-family:Arial;
	font-weight:normal;
	text-align:left;
	
}
#container td
{
	font-size:14px;
	font-family:Arial;
	font-weight:normal;
	
}
#wrapper .footer{
		background:url(http://www.coinwhale.com/images/footer.png) no-repeat;
		width:520px;
		height:59px;			
}
#wrapper .button
{
	
	background:url(http://www.coinwhale.com/images/submit-btn.png) no-repeat;
		width:152px;
		height:52px;
		cursor:pointer;
		border:none;		
}

#not-fans {
width:520px;
position:absolute; top:0; left:0;
height:622px; /* This should changed to the height of your image */
}

.input
{
	-moz-border-radius:4px 4px 4px 4px;
	border:#000000 1px solid;
	background-color:#ffffff;
	color:#000000;
	width:250px;
	height:20px;
	
}
</style>
<?
//session_start();


$is_fan=0;
if(isset($_POST['fb_sig_is_fan']))
{
	$is_fan=$_POST['fb_sig_is_fan'];
}
echo "<div id='wrapper'>";


if($is_fan)
{
	
?>
<script type="text/javascript">
 function registerUser()
	{
		var error=false;
		
		var message=document.getElementById('message');
		var firstName=document.getElementById('fname').getValue();
		var lastName=document.getElementById('lname').getValue();
		var email=document.getElementById('email').getValue();
		
		if(email=="")
		{
			message.setTextValue("Please enter your email address.");
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
				
			 }
			 
			 ajax.onerror = function(){
				message.setTextValue("error");
			 }
				 ajax.requireLogin = true;
				 var params = {'fname' : ''+firstName,'lname':''+lastName,'email':''+email};
				 ajax.post('http://www.coinwhale.com/ajax/registerUser', params);
				 return true;
		}
	}
</script>
<?	
	echo "<div style='width:520px;'>
     <div class='header'></div>
	 <div id='container' style='margin:0px 8px 0px 8px;background-color:#F6F5F0;'>";
	 echo "<div class='p1' style='padding:0px 20px 20px 10px'>We give you crazy deals on your favourite Games on Facebook! Join CoinWhale to get free items and the above mentioned awsome deals.</div>";
	echo "<div class='p2' ></div>";
	echo "<div style='padding:0px 0px 20px 0px'>";
	echo "<div class='p3'>Enter your email for a chance to <font style='color:#FF0000;font-size:48px;text-shadow:2px 2px 4px #000000;'>win $100</font> to spend on your favourite Facebook games!</div>";
	echo "<div>&nbsp;</div>";
	//echo "<div>&nbsp;</div>";
	echo "<table cellpadding='0' cellspacing='5' border='0' width='100%'>";
	echo "<tr>";
	echo "<td colspan='2'><div id='message' style='color:#ff0000;text-align:center;'></div></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>First Name</td>";
	echo "<td width='65%'><input id='fname' name='fname' type='text' class='input'/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>Last Name</td>";
	echo "<td width='65%'><input id='lname' name='lname' type='text' class='input'/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='35%' style='text-align:center'>Email</td>";
	echo "<td width='65%'><input id='email' name='email' type='text' class='input'/>*</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' colspan='2'><div align='center'><input type='button' class='button' value='' onclick='registerUser()'/></div></td>";
	echo "</tr>";
	echo "</table>";
	echo"</div>";
	 echo"</div>
	 
	 <div class='footer'>&nbsp;</div>
	 
 </div>";

}else
{
	echo "<div style='height:622px;'>";
	echo "<img src='http://www.coinwhale.com/images/reveal-tab-locked5.gif' id='not-fans' />";
	echo "</div>";
}
?>
<div style='text-align:justify;padding:20px'>
	 	This promotion is in no way sponsored, endorsed or administered by, or associated with, Facebook. You understand that you are providing information to CoinWhale and not to Facebook. The information you provide will be in part used to administer this promotion (for more information read the privacy policy). No purchase is necessary and a purchase of any kind will not increase an individuals chances of winning. See official <a href="http://www.coinwhale.com/others?page=rules" target="_blank">rules</a>.
	</div>
	<div>&nbsp;</div>
	<div style='text-align:center'>© CoinWhale - All Rights Reserved.  <a href="http://www.coinwhale.com/others?page=privacy" 