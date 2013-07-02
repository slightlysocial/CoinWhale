<script type="text/javascript">
	
		$(document).ready(function() {
			$("a.details").fancybox({
				'autoScale'				: true,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'ajax'
			});
			
	
		});
	

</script>
<div id="modal-waves-wrapper" style="width:auto;" align="center">
    <div id="content" align="center" style="width:500px;padding:20px 0px 10px 0px;">
    	<div class="sp"></div>
    	<h2><?=$title?></h2>
        <p>&nbsp;</p>
     
        <div id="row" style="padding:0px 10px 10px 10px;">          
         <h2>Thanks for your purchase!</h2>
         <div>&nbsp;</div>
         <div style="text-align:justify">It looks like you haven't installed the following game(s) yet</div>
         <div>&nbsp;</div>
         <div style="text-align:justify"><?=$game_links?></div>
         <div>&nbsp;</div>
         <div style="text-align:justify">Once you add the game(s) listed above, come back here and press continue to claim your deal.</div>
		<div>&nbsp;</div>
         <div align="center"><input type="image" src="<?=base_url()?>images/continue.png" onclick='$("a.details").trigger("click");' name="image" width="178" height="69" /></div>
         <a  href="<?=base_url()."purchasedeal/index/$buy_id"?>" class="details" style="display:none">link</a>
                 
        </div>
        
    </div>
    
    
    
  </div>
