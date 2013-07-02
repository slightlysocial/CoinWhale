<?
		$saving_pct=0;
		$saving=$retail_price-$price;
		if($retail_price>0)
		{
			$saving_pct=round(($saving/$retail_price)*100);
		}
?>	
	<script type="text/javascript">
    function redeemCoin(clid)
	{
		//var value=document.getElementById('email').value;
		 var div=document.getElementById('claim_'+clid);
		 
		 if(div)
		 {
			 
			 $.ajax({
				type: "POST",
				url: "<?=base_url()?>admin/redeem_coin.php",
				data: "clid=" + clid+"&secret=<?=md5('coinwhale')?>",
				success: function(msg){
					if(msg==0)
					{
						div.innerHTML="<div>Error! Please try again</div>";
					}else
					{
						div.innerHTML="CLAIMED";
					}
				},
				error: function(msg){
					alert(msg);
				}
			});
			
		 }
	}
    </script>
   <div id="modal-waves-wrapper" style="width:auto;" align="center">
    <div id="content" align="center" style="width:520px;">
    	<div class="sp"></div>
    	<h2><?=$title?></h2>
        <p>&nbsp;</p>
     	
        <div id="row" style="padding-bottom:10px;">          
          <table class="gridmodal">
          	<tr>
            	<th>Deal Purchased</th>
              <th>Status</th>
            </tr>
           <?=$output?>         
          </table>   
                 
        </div>
         <div class="block-content-modal" style="margin-bottom:0px;" id="anchr"> 
        	<table class="savings" style="margin-bottom:0px">
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
   
    
    
  </div>
