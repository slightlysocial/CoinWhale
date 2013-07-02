			<div style="text-align:center"><h3>Processing the deal.... please wait...</h3><div>If not redirect in 20 seconds.. please click the paypal button..</div></div>
            <div style="text-align:center">
        	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="form_deal">
			<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="form_deal">-->
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="payment@coinwhale.com">
           <!--	<input type="hidden" name="business" value="w_sell_1289416740_biz@yahoo.com" >-->
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="<?=$deal_title?>">
            <input type="hidden" name="item_number" value="<?=$deal_id?>">
            <input type="hidden" name="amount" value="<?=$price?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="custom" value="<?php echo $_COOKIE['hash'];?>" class="zferral_paypal_form_custom" />
            <input type="hidden" name="return" value="http://www.coinwhale.com/account/?success=1">
            <input type="hidden" name="cancel_return" value="http://www.coinwhale.com/deals/buy/?success=-1&did=<?=$deal_id?>">
            <input type="hidden" name="notify_url" value="http://www.coinwhale.com/admin/paypal_receive.php?user_id=<?=$user_id?>&buy_id=<?=$buy_id?>">
            <input type="image" src="<?=base_url()?>images/paypal_logo.jpg" border="0" name="submit" width="51" height="32" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
        <script type="text/javascript">
            var deal=document.getElementById('form_deal');
			deal.submit();
            </script>
            