  <?
  $url=urlencode("".base_url()."?refer=$refer");
  $refer_point=$refer_count*10;
  $refer_buy_point=$refer_buy*1000;
  $total_point=number_format(($refer_point+$refer_buy_point),0);
  ?>
  <script type="text/javascript">
	$(document).ready(function() {
		$("a.details").fancybox({
			'autoScale'				: true,
			'autoDimensions'	: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'						: 'ajax'
		});
		

	});

</script>

  <div id="ribbon">
    <div id="page-title">
    	<h1>My Account</h1>
    </div>
    <div class="clear"></div>
  </div>
  <div id="content-wrapper">
  	<div id="content">
    	<div id="bar">
      	<ul id="bar-nav">
        	<li><a href="#" onclick="share('<?=base_url()?>?refer=<?=$refer?>')"><img src="<?=base_url()?>images/mini-fb.gif" class="align-image" /> Post to Profile</a></li>
          <li><a href="http://twitter.com/share?url=<?=$url?>&amp;via=twitterapi" class="twitter-share-button" data-count="horizontal">Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
        </ul>
        <div id="referal-link" style="padding:7px 10px 7px 10px;">Your Personal Referal Link: <span><input  style="width:430px;" value="<?=base_url()?>?refer=<?=$refer?>"/></span></div>
      </div>
      <?
	  
	 
	  if($success==1)
	  {
		  if($last_deal_status==0)
		  {
      echo '<div style="text-align:center;">
	  
      <h3>Thanks for your purchase! Make sure you have added all of the games, and then come back here and click the deal you bought, then click Claim Now.</h3>';
		echo "<div>&nbsp;</div>";
		
		
	  echo "<div><a onclick='publishFeed(&quot;".base_url()."?refer=".$refer."&quot;)' href='#'><img class='align-image' src='http://www.coinwhale.com/images/mini-fb.gif'> Brag about your purchase and Earn!</a></div>";
	  
      
	  echo '</div>';
	  
	  }else
	  {
		  
		 ?>
		 <script type="text/javascript">
	$(document).ready(function() {
		$.fancybox({
			'autoScale'				: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'ajax',
			'href'              : '<?=base_url()."purchasedeal/showNotInstall/$last_buy_id"?>'
		});
		

	});

</script>
		 <?
	}
	  }
	  ?>
      <div id="single">
      	<h2>Your Referal Stats</h2>
        <hr />
        <div id="row">
          <div class="section important-bg">People Refered<div class="fat-text"><?=$refer_count?></div></div>
          <div class="section important-bg">Earned Credits <div class="fat-text"><?=$total_point?></div>
          </div>
          <div class="section" style="width: 50%;">
          	<h3>More ways to earn credits</h3>
            <p>Earn <a href="#">10 credits</a> for every person who you refer who signs up for free</p>
            <p>Earn <a href="#">1000 credits</a> for every person who makes a purchase</p>
            <p>Share your link to your friends by posting to your Facebook wall, tweeting or copying and pasting referal link</p>
          </div>
          <div class="clear"></div>
        </div>

        <h2>Your Credits</h2>
        <hr />
        <div id="row">
          <div class="section important-bg">Credits<div class="fat-text"><?=$credit?></div></div>
          <div class="section" style="width: 50%;" id="credits">
            <p>You can earn credits by performing actions on CoinWhale.com that award credits, buying deals, sharing deals and earning achievements.</p>
            <p><a href="#credits" onclick="spendCredits()"><img src="<?=base_url()?>images/spend-credits-button.png" width="180" height="52" alt="Spend Your Credits"/></a></p>
          </div>
          <div class="clear"></div>
        </div>
        
        <h2>Your Past Purchases</h2>
        <hr />
        <div id="row">
        	<h3>Deal Purchased</h3>
          <table class="grid" style="width: 80%;">
          <?
          for($i=0;$i<count($buy_deal);$i++)
		  {
			 echo "<tr>";
			 echo "<td style='width:40%'><a href='".base_url()."purchasedeal/index/".$buy_deal[$i]["buy_id"]."' class='details'>".$buy_deal[$i]["deal_title"]."</a></td>";
			 echo "<td style='width:20%'>".$buy_deal[$i]["buy_date"]."</td>";
			 echo "<td style='width:40%'>&nbsp;</td>";
			 echo "</tr>"; 
		}
		  ?>         
          </table>          
        </div>
        
        
        <h2>Your Received Gifts</h2>
        <hr />
        <div id="row">
        	<h3>Deal Received</h3>
          <table class="grid" style="width: 80%;">
          <?
          for($i=0;$i<count($receive_gift);$i++)
		  {
			 echo "<tr>";
			 echo "<td style='width:40%'><a href='".base_url()."purchasedeal/index/".$receive_gift[$i]["buy_id"]."' class='details'>".$receive_gift[$i]["deal_title"]."</a></td>";
			 echo "<td style='width:20%'>".$receive_gift[$i]["buy_date"]."</td>";
			 echo "<td style='width:40%'>&nbsp;</td>";
			 echo "</tr>"; 
		}
		  ?>         
          </table>          
        </div>                
                        
        
        <h2>Your Sent Gifts</h2>
        <hr />
        <div id="sent-row">
        <div id="row">
        	<h3>Deal Sent</h3>
          <table class="grid" style="width: 80%;" border="0">
          <?
		  
          for($i=0;$i<count($sent_gift);$i++)
		  {
			 echo "<tr>";
			 echo "<td style='width:40%'><a href='".base_url()."purchasedeal/sentdeal/".$sent_gift[$i]["buy_id"]."' class='details'>".$sent_gift[$i]["deal_title"]."</a></td>";
			 echo "<td style='width:20%'>".$sent_gift[$i]["buy_date"]."</td>";
			 if($sent_gift[$i]["status"]==1)
			 {
				  echo "<td style='width:40%'><b>ALREADY CLAIMED</b></td>";
			}else
			{
				echo "<td style='width:40%'><b>UNCLAIMED</a> <a href='".base_url()."purchasedeal/sentdeal/".$sent_gift[$i]["buy_id"]."' class='details'>Resend To Someone Else</a></td>";
			}
			
			 echo "</tr>"; 
		}
		  ?>         
          </table>          
        </div>                
        </div>
      </div>
      <div class="clear"></div>
    </div><!-- // content -->
  </div><!-- // content-wrapper -->