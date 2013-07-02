<?
$start_date=date("m/d/Y h:i:s A",time());
?>
<script type="text/javascript">

function validateEmail(val)
{
	
	document.getElementById('error').innerHTML="";
	var pemail=document.getElementById("friend_email_paypal");
	var semail=document.getElementById("friend_email_spare");
	var cmbfor=document.getElementById("cmbFor").value;
	
	var email=document.getElementById('friend-mail').value;
	var conemail=document.getElementById('confirm-friend-mail').value;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if(cmbfor==1)
	{
		//alert("WTF?"+cmbfor);
		if(reg.test(email) == false) {
			document.getElementById('error').innerHTML="Invalid Email Address";
		  alert('Invalid Email Address');
		  return false;
	   }
	   
	   	if(email!=conemail)
	   	{
		   document.getElementById('error').innerHTML="Email address doesn't match with the confirmation email address!";
		  alert("Email address doesn't match with the confirmation email address!");
		  return false;
		}
		
	}
	//alert(""+cmbfor);
	//return false;
	
	if(val==0)
	{
		pemail.value=email;
		//document.frmpaypal.submit();
		return true;
	}else if(val==1)
	{
		semail.value=email;
		//document.frmspare.submit();
		return true;
	}

}

function changeFor(value)
{
	document.getElementById('error').innerHTML="";
	document.getElementById("cmbFor").value=value;
	var payfor=document.getElementById("gift-option");
	var ppaytype=document.getElementById("purchase_type_paypal");
	var spaytype=document.getElementById("purchase_type_spare");
	
	payfor.style.display="block";
	if(value==1)
	{
		payfor.style.display="block";
		ppaytype.value=1;
		spaytype.value=1;
	
	}else
	{
		payfor.style.display="none";
		ppaytype.value=0;
		spaytype.value=0;
	}
	
}

function changeBuy(id)
{
	
	//alert(id);
	var obj1=document.getElementById("paypal");
	var obj2=document.getElementById("spare_change");
	obj1.style.display="none";
	obj2.style.display="none";
	
	//alert(""+obj1.style.diaplay);
	if(id==0)
	{
		obj1.style.display="block";
	}else if(id==1)
	{
		obj2.style.display="block";
	}
	
	//alert(""+obj1.style.diaplay);
}

</script>	
<div id="ribbon">
    <div id="page-title">
    	<h1>The Deal Is Almost Yours</h1>
    </div>
    <div class="align-down">
    	<h2>Choose your payment method below</h2>
    </div>
    <div class="clear"></div>
  </div>
 
  <div id="content-wrapper">
  	<div id="content">
    <?
	  if($isValid)
	  {
		 if(!$deal_closed)
		 { 
	  ?>
    	<div id="bar">
      	<ul>
        	<li><a href="#"><img src="<?php echo base_url(); ?>images/deal-tweet.gif" /></a></li>
          <li><fb:share-button href="<?=base_url()?>deals/?did=<?=$deal_id?>" type="button_count"></fb:share-button></li>
          <li><fb:like href="<?=base_url()?>deals/?did=<?=$deal_id?>" layout="button_count" show_faces="false"></fb:like></li>
        </ul>
       
        <?
        if(!$deal_closed)
		{
		?>
        <div class="timer">
        <script language="javascript">
			StartDate="<?=$start_date?>";
			TargetDate = "<?=$end_date?>";
			BackColor = "EDE9DA";
			ForeColor = "black";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true; 
			DisplayFormat = 'DONE DEAL IN <span class="time">%%D%%</span> DAYS and <span class="time">%%H%%</span> HOURS <span class="time">%%M%%</span> MINUTES <span class="time">%%S%%</span> SECONDS.';
			FinishMessage = "<span style='text-align:center;'>DEAL CLOSED!</span>";
			</script>
			<script language="javascript" src="<?=base_url()?>javascript/countdown.js"></script>
           </div>
        <?
		}else
		{
			echo "<div class='timer' style='width:450px;text-align:left;'>";
			echo "<span style='text-align:center;'>DEAL CLOSED!</span>";
			echo "</div>";
		}
		?>
       
      </div>
      <?
      if($success==-1)
	  {
		  echo "<div style='text-align:center;'><h3 style='color:#ff0000'>Your trursaction has been canceled!!</h3></div>";
	}else if($success==-2)
	 {
		  echo "<div style='text-align:center;'><h3 style='color:#ff0000'>Sorry, you can only buy 1 deal per person. Moby Deal says that you already have this deal!</h3></div>";
	}else if($success==-3)
	{
		  echo "<div style='text-align:center;'><h3 style='color:#ff0000'>Sorry!  The recipient you selected already has this bundle. Please try another recipient, we're sure another friend would do the happy dance if you sent them this gift.</h3></div>";
	}else if($success==-4)
	{
		  echo "<div style='text-align:center;'><h3 style='color:#ff0000'>Oops, you can't send yourself the gift.</h3></div>";
	}
	  ?>
      <div id="single">
      	<h2>Your Purchase</h2>
        <hr />
        <div id="row">
        			<div class="section">
					
                    <ul>
						<?
                        
                        for($i=0;$i<count($deal_content);$i++)
                        {
                            echo "<li style='float:left;'><img src='".base_url()."admin/deal_image/".$deal_content[$i]["game_image"]."' width='105px'  /></li>";
                        }
                        ?>
                    </ul>
                   <div class="clear"></div>
                    </div>
          <div class="section">
          	<h3><?=$deal_title?></h3>
            <table class="grid">
            <?
            for($i=0;$i<count($deal_content);$i++)
			{
			
              echo "<tr>
                <td><strong>".$deal_content[$i]["game_name"]."</strong></td>
              </tr>";
            
			}
			 ?>
            </table>            
          </div>
          <div class="section important-bg fat-text"><sup>$</sup><?=$price?></div>
          <div class="clear"></div>
        </div>
		<div align="center" ><h2>Limit 1 Deal Per Person.</h2></div>
        <div align="center">
        <input id="cmbFor" type="hidden" value="0"/>
        <input type="image" src="<?=base_url()?>images/send_gift.png" width="234" height="52" alt="Send Gift" onclick="changeFor(1)">      
        </div>
        
        <!--<h2>Purchase Type</h2>
        <hr />
        <div id="payment-for">
        <div style="width:120px; float:left;">Purchase For:
         </div>
        <div style="width:100px; float:left">
         <select id="cmbFor"  name="cmbFor" onchange="changeFor(this)">
         <option value="0">Self</option>
         <option value="1">Gift</option>
         </select>
         </div>
         
         <div style="clear:both">&nbsp;</div>
        </div>-->
       <!-- <div>&nbsp;</div>-->
        
        <div id="gift-option" style="display:none;">
        <div>&nbsp;</div>
        <div style="width:100%">
        <div style="float:left;"><h2>Recipient's Details</h2></div><div style="float:right"><input type="image" src="<?=base_url()?>images/fancy_close.png" width="32" height="32" alt="Close" onclick="changeFor(0)">  </div>    
        <div style="clear:both"> <hr/></div>
        </div>
       
         <div><div style="width:175px; float:left;">Recipient's Email:</div><div style="width:100px; float:left;"><input type="text" id="friend-mail" name="friend-mail"/></div>
         <div style="clear:both">&nbsp;</div>
         </div>
         <div><div style="width:175px; float:left;">Confirm Email Address:</div><div style="width:100px; float:left;"><input type="text" id="confirm-friend-mail" name="confirm-friend-mail"/></div>
         <div style="clear:both">&nbsp;</div>
         </div>
         
        </div>
        <div id='error' style="color:#C00;text-align:center"></div>
        <div>&nbsp;</div>
        
        <h2>Choose Your Payment Method</h2>
        <hr />
        <div id="payment-gateways">
          	<span class="gateway"><input type="radio" name="1" checked="checked" onclick="changeBuy(0)" /> <img src="<?=base_url()?>images/paypal_logo.jpg" class="align-image" /></span>     
           <span class="gateway"><input type="radio" name="1"  onclick="changeBuy(1)" /> <img src="<?=base_url()?>images/sparechange_logo.gif" class="align-image" /></span>
            <div class="clear"></div>
        </div>
        

         <div class="centered" id="paypal" style="display:block;">
         	<form method="post" action="<?=base_url()?>deals/process/" id="frmpaypal" name="frmpaypal">
            <input type="hidden" name="deal_id" value="<?=$deal_id?>">
            <input type="hidden" name="amount" value="<?=$price?>">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
            <input type="hidden" name="friend_email" id="friend_email_paypal" value="">
             <input type="hidden" name="purchase_type" id="purchase_type_paypal" value="0">
        	<input type="image" src="<?=base_url()?>images/complete-order-button.png" width="234" height="52" alt="Complete My Order" onclick="return validateEmail(0);">      
            </form>
        </div>
        
        <div class="centered" id="spare_change" style="display:none;">
        <form method="post" action="<?=base_url()?>deals/sparechange/" id="frmspare" name="frmspare">
            <input type="hidden" name="deal_id" value="<?=$deal_id?>">
            <input type="hidden" name="amount" value="<?=$price?>">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
             <input type="hidden" name="friend_email" id="friend_email_spare" value="">
             <input type="hidden" name="purchase_type" id="purchase_type_spare" value="0">
        	<input type="image" src="<?=base_url()?>images/complete-order-button.png" width="234" height="52" alt="Complete My Order" onclick="return validateEmail(1);">      
            </form>
       
        
        </div>
		
      </div>
    	
      <div class="clear"></div>
      <?
	  		}else
			{
				echo "<div align='center'><h2>Deal Closed!! Try Another Deal</h2></div>";	  
			}
	  }else
	  {
		echo "<div align='center'><h2>Invalid Deal Id</h2></div>";	  
	}
	  ?>
    </div><!-- // content -->
  </div><!-- // content-wrapper -->