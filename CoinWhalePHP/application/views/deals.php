<?
		$start_date=date("m/d/Y h:i:s A",time());
		$url=urlencode("".base_url()."deals/buy/?did=".$deal_id."");
		$overAllPct=0;
		$overAllPctImg=0;
		if($deal_quantity>0)
		{
			$overAllPct=ceil((($deal_buy_qty/$deal_quantity)*100));
			$overAllPctImg=ceil((($deal_buy_qty/$deal_quantity)*115));
		}
		$saving_pct=0;
		$saving=$retail_price-$price;
		if($retail_price>0)
		{
			$saving_pct=round(($saving/$retail_price)*100);
		}
?>
<script type="text/javascript">
	$(document).ready(function() {
	   $("a.showlogin").fancybox({
			'autoScale'				: true,
			'autoDimensions'	: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'						: 'ajax',
			'height'					: 425
		});
		

	});
	</script>
<div id="ribbon">
  	<div id="deal-price">
    	<div class="price"><sup>$</sup><?=$price?></div>
    	<div><strike>$<?=$retail_price?></strike></div>
    </div>
    <div id="buy-now">
    	<?
        if(!$deal_closed)
		{
			 if($deal_status==2)
			 {
				 
			}else
			{
			
				if(!$isLogin)
				{
						echo '<a href="'.base_url().'ajax/showlogin/" class="showlogin" ><img src="'.base_url().'images/buy-button-small.png" height="52" width="138" alt="Buy Now" /></a> ';
				}else
				{
				?>
				<p><a href="<?=base_url()?>deals/buy/?did=<?=$deal_id?>"><img src="<?php echo base_url(); ?>images/buy-button-small.png" width="138" height="52" alt="Buy Now!" /></a></p>
				<?
				}
			}
		}else
		{
		
		echo '<p><a href="'.base_url().'others/?page=buylater&deal_id='.$deal_id.'"><img src="'.base_url().'images/expired-button-small2.gif" width="138" height="52" alt="Deal Closed!" style="cursor:pointer" /></a></p>';
   		
		}
		?>
      <p><div align="center"><? 
	  if($deal_buy_qty!=0)
	  {
		  $this->common_functions->renderBox($overAllPctImg,18,"$overAllPct% Sold","#DCDCDC","#B7B7B7",115);
	}
	?></div></p>
    </div>
    <div id="deal-title">
    	<h1><?=$deal_title?></h1>
    </div>
    <div class="clear"></div>
  </div>
  <div id="content-wrapper">
  	<div id="content">
    	<div id="bar">
      	<ul>
        	<li>
           <a href="http://twitter.com/share?url=<?=$url?>&amp;via=twitterapi" class="twitter-share-button" data-count="horizontal">Tweet</a>
		   <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </li>
          <li><fb:share-button href="<?=base_url()?>deals/?did=<?=$deal_id?>" type="button_count"></fb:share-button></li>
          <li><fb:like href="<?=base_url()?>deals/?did=<?=$deal_id?>" layout="button_count" show_faces="false"></fb:like></li>
        </ul>
       
        <?
        if(!$deal_closed)
		{
			$display_format='DONE DEAL IN <span class="time">%%D%%</span> DAYS and <span class="time">%%H%%</span> HOURS <span class="time">%%M%%</span> MINUTES <span class="time">%%S%%</span> SECONDS.';
			
			if($deal_status==2)
			{
				$end_date=$deal_date;
				$display_format='DEAL STARTS IN <span class="time">%%D%%</span> DAYS and <span class="time">%%H%%</span> HOURS <span class="time">%%M%%</span> MINUTES <span class="time">%%S%%</span> SECONDS.';
			
			}
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
			DisplayFormat = '<?=$display_format?>';
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
      
      <div id="auxiliary">
      	<div id="video"><object width="204" height="204"><param name="movie" value="<?=$video_link?>"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="<?=$video_link?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="204" height="139"></embed></object></div>
        
        <h3>Games in this bundle:</h3>
        <?
        //$deal_content=$deal_content;
		echo '<table class="grid">';
		for($i=0;$i<count($deal_content);$i++)
		{
			echo "<tr>";
			echo "<td><strong>".$deal_content[$i]["game_name"]."</strong></td>";
			echo "<td>$".$deal_content[$i]["credit_val"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		
		//$price=$deal["price"];
		//$retail=$deal["retail_price"];
		
		?>
        
        <div class="block-content">
        	<table class="savings">
          	<tr>
            	<td>Total:</td>
              <td class="price"><strike>$<?=$retail_price?></strike></td>
            </tr>
          	<tr>
            	<td>Your Cost:</td>
              <td class="price">$<?=$price?></td>
            </tr>
          	<tr>
            	<td>Savings:</td>
              <td class="price"><?=$saving_pct?>%</td>
            </tr>                        
          </table>
        </div>
       </div>
      <div id="main">
      	<div class="block-content" style="height:290px">
        	<ul>
            	<?
                for($i=0;$i<count($deal_content);$i++)
				{
					echo "<li><div class='game-top'>".$deal_content[$i]["game_name"]."</div><div><a href='".base_url()."admin/track.php?sid=".$deal_content[$i]["serial"]."' target='_blank'><img src='".base_url()."admin/deal_image/".$deal_content[$i]["game_image"]."' width='222'/></a></div></li>";
				}
				?>
            </ul>
        	
        </div>
        <hr />
        <p><?=$short_desc?></p>
        <hr />
        <div id="buy-now-block" class="block-content">
        <?
        if(!$deal_closed)
		{
			  if($deal_status==2)
			 {
				 
			}else
			{
				 if(!$isLogin)
				{
						echo '<a href="'.base_url().'ajax/showlogin/" class="showlogin" ><img src="'.base_url().'images/buy-button-large.png" height="69" width="178" alt="Buy Now" /></a> ';
				}else
				{
						echo '<a href="'.base_url().'deals/buy/?did='.$deal_id.'" ><img src="'.base_url().'images/buy-button-large.png" height="69" width="178" alt="Buy Now" /></a> ';
				}
			}
         }else
		 {
			 echo '<a href="'.base_url().'others/?page=buylater&deal_id='.$deal_id.'"><img src="'.base_url().'images/expired-button-large2.gif" height="69" width="178" alt="Deal Closed" style="cursor:pointer" /></a>';
		}
		 ?>
          <sup>$</sup><?=$price?>
        </div>
        <hr />
        <h2>Discuss This Whale of a Deal</h2>
        <p>
        	<fb:comments xid="coin_whale_deal_<?=$deal_id?>" migrated="1" title="Readers Interaction"  publish_feed="1" simple="true"></fb:comments>
        </p>
      </div>
    	
      <div class="clear"></div>
    </div><!-- // content -->
  </div><!-- // content-wrapper -->