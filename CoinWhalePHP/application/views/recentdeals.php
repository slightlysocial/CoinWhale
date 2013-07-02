  <script  type="text/javascript">
 	function showDeal(did)
	{
		location.href="<?=base_url()?>deals/?did="+did;
	}
  </script>
  <div id="ribbon">
    <div id="page-title">
    	<h1>Recent Deals</h1>
    </div>
    <div class="clear"></div>
  </div>
  <div id="content-wrapper">
  	<div id="content">
      
      <?
	  	echo "<div style='padding:10px 40px 10px 40px'>";   //start main div
		echo "<div class='box_content' style='padding:10px 0px 10px 5px;'>"; //start box content
			//echo "<table cellpadding='' cellspacing=''";
			//echo count($all_deal);
		$total=	count($all_deal);
		if($total==0)
		{
			echo "<div align='center'><h2>Sorry ! No recent deal found!</h2></div>";	
		}
		
		for($i=0;$i<$total;$i++)
		{
			$deal=$all_deal[$i];
			$qty=$deal["deal_buy_qty"];
			if(!isset($qty))
			{
				$qty=0;
			}
			
			$saving_pct=0;
			$saving=$deal["retail_price"]-$deal["price"];
			if($deal["retail_price"]>0)
			{
				$saving_pct=round(($saving/$deal["retail_price"])*100);
			}
		echo "<div style='padding:0px 20px 0px 20px;float:left;cursor:pointer;' onclick='showDeal(".$deal["deal_id"].")'>";	 //start main dealbox
			echo "<div style='text-align:left;padding:5px'>".$deal["start_date"]."</div>"; //show date
			echo "<div class='sp'></div>";	
			echo "<div class='deal_box' style='padding:5px'>"; //start deal box
				echo "<div>".$deal["deal_title"]."</div>";  //deal title
				echo "<div>&nbsp;</div>";	
				//echo "<div class='sp'></div>";
				echo "<div style='width:360px' >"; //start deal content
					//echo "<div>";
					
					echo "<div style='width:120px;float:left;' align='center'>";   //start left content
					echo "<div>";							//left content box
						echo "<div class='box_bought'>";    //buy box
							echo "<div class='sp'></div>";
							echo "<div style='font-size:24px;'>".$qty."</div>";
							echo "<div class='sp'></div>";
							echo "<div style='font-size:12px;'>Total Bought</div>";
							echo "<div class='sp'></div>";
							echo "<div class='sp'></div>";
						echo "</div>";       //end buy box
						echo "<div class='sp'></div>";
						echo "<div class='sp'></div>";
					
						echo "<div class='box_price'>";  //start box price
							echo "<div style='background-color:#4BC1DD;color:#ffffff'>";  //start blue box
								echo "<div class='sp'></div>";
								echo "<div class='div' style='text-align:right;'>Cost:</div>";
								echo "<div class='div'><b>$".$deal["price"]."</b></div>";
								echo "<div class='sp'></div>";
								echo "<div style='clear:both;'></div>";
								echo"</div>";//end blue box
							echo "<div class='sp'></div>";
						
						
							echo "<div>";
								echo "<div class='div' style='text-align:right;'>Value:</div>";
								echo "<div class='div'><b>$".$deal["retail_price"]."</b></div>";
								echo "<div style='clear:both;'></div>";
							echo"</div>";
							echo "<div class='sp'></div>";
							echo "<div>";
								echo "<div class='div' style='text-align:right;'>Savings:</div>";
								echo "<div class='div'><b>".$saving_pct."%</b></div>";
								echo "<div style='clear:both;'></div>";
							echo"</div>";
							
							echo "<div class='sp'></div>";
							echo "<div class='sp'></div>";
						echo "</div>";  //end box price
					echo "</div>"; //end left content box
						
					echo "</div>"; //end left content 
					
					echo "<div style='width:240px;float:left;' align='center'>"; //start right content 
						echo "<div style='width:225px'>"; //start right content box
						echo "<ul>";
						$deal_content=$deal["deal_content"];
						
						for($j=0;$j<count($deal_content);$j++)
						{
							echo "<li style='float:left;'><img src='".base_url()."admin/deal_image/".$deal_content[$j]["game_image"]."' width='75px'  /></li>";
						}
						//echo "<div style='clear:both;'></div>";
						echo "</ul>";
						echo "<div style='clear:both;'></div>";
						echo "</div>"; //end right content box
						//echo "<div style='clear:both;'></div>";
					echo "</div"; //end right content
					
					echo "<div style='clear:both;'></div>";
				echo "</div>"; //end deal content
				echo "<div style='clear:both;'></div>";
				echo "<div class='sp'></div>";
				echo "<div class='sp'></div>";
			echo "</div>"; //end deal box
		
		echo "</div>"; //end main deal box
		}
		
		
		echo "<div style='clear:both'></div>";
		echo "</div>"; //end box content
		echo "</div>"; //end main div
	  ?>
      <div class="clear"></div>
    </div><!-- // content -->
  </div><!-- // content-wrapper -->