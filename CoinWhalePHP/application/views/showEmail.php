 <div id="ribbon">
    <div id="page-title">
    	<h1>Facebook Connect sign-up</h1>
    </div>
    <div class="clear"></div>
  </div>
  <div id="content-wrapper">

		<div id="content">
        	<div class="grey-frame-narrow">
            
            <div class="grey-frame">
            	<div class="grey-frame-inner">
                	
                    <h3>Hi <?=$name?></h3>
                    <p>Please give us your email to complete your Facebook Connect sign-up. In the future all you'll need to do is click the Facebook button and you'll be signed-in.</p>
                    <form method="post" id="new_user" class="new_user" action="<?=base_url()?>home/newuser/"><div style="margin: 0pt; padding: 0pt; display: inline;"><input type="hidden" value="6rFzUvGtMieLMoQ5tacV3KvfJtAxO7eU0uy38BJo9Ok=" name="authenticity_token"></div>
                    
                    <fieldset>
                    <label for="user_email">Email</label>
                    <input type="text" size="30" name="user_email" id="user_email" class="input">
                    </fieldset>
                    
                    <br>
                    <input type="submit" value="Sign me up!" name="commit" id="user_submit" class="button submit">
                    </form>
                    </div>
                   </div>
            </div>
        </div><!-- // content -->
  </div><!-- // content-wrapper -->