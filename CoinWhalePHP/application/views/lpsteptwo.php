<div id="modal-waves-wrapper">
    <div id="content" >
    	<form action="<?=base_url()?>home/" method="post" target="_top">
        <h1>Almost Done!</h1>
        <p>&nbsp;</p>
        <p>You are registered, but please take a minute to complete your profile and become a verified hunter!</p>
        <input type="hidden" id="step" name="step" value="2" />
        <table>
        	<tr>
          	<td><h2>First Name:</h2> 
            	<input type="text" id="first_name" name="fname" class="textbox" />
            </td>
            <td></td>
          </tr>
          <tr>
          	<td><h2>Last Name:</h2> 
            	<input type="text" id="last_name" name="lname" class="textbox" />
            </td>
            <td><input type="image" src="<?=base_url()?>images/submit-btn.png" name="image" width="152" height="52" ></td>
          </tr>
          <tr>
          	<td><h2>Email:</h2> 
            	<input type="text" id="email" name="email" class="textbox"  value="<?=$email?>"/>
            </td>                        
            <td></td>
          </tr>
        </table>
			</form>      
    </div>
  </div>