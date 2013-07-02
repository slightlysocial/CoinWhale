
<div id="splash-header">
  	<div id="container">
    	<div id="splash-inner">
      	<div id="splash-form">
        	<form action="<?=base_url()?>home/" method="post">
            <h2>Your Email Address</h2>
            <p>
            	<input type="hidden" id="step" name="step" value="1" />
              <input type="text" id="email" name="email" class="textbox" value="<?=$email?>" /><br />
              your email is safe with us
            </p>
            <p>
              <input type="image" src="<?=base_url()?>images/continue-to-deal.png" name="image" width="234" height="52">
            </p>
            <p><a href="<?=base_url()?>">Skip</a>  | <a href="#" onclick='fbLogin()'>Member Signin</a></p>
          </form>
        </div>
      </div>
    </div>
	</div>
  <div id="splash-footer"></div>
