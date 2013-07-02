<div id="content-wrapper" style="margin-right:13px;width:auto;" align="center">
    <div id="content" align="center">
  <p id="description">Monthly news and updates plus discounts on all our products.</p>
		
		  <fieldset>
			<legend>Join Our Mailing List</legend>
			  
			  <label for="email" id="address-label">Email Address
				<span id="response">
					
				  </span>
			  </label>
			  <div id="member-email">
        	
        	<input type="text" class="input" value="" name="email" id="email" />
            <input type="image" class="submit" src="<?php echo base_url(); ?>images/submit.png" alt="submit" onclick="submitTestEmail()">
         
        </div>
			  <div id="no-spam">We'll never spam or give this address away</div>
		  </fieldset>
		    
		<script type="text/javascript">
function submitTestEmail()
{
	var value=document.getElementById('email').value;
	 var div=document.getElementById('response');
	 
	 if(div)
	 {
		 $.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/submitEmail/",
			data: "email=" + value,
			success: function(msg){
				div.innerHTML=msg;
			},
			error: function(msg){
				alert(msg+"<?=base_url()?>ajax/submitEmail/");
			}
		});
		
	 }
}
        </script>
		
	</div>
</div>