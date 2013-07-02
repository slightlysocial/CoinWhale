 <div>&nbsp;</div>
 <div>&nbsp;</div>
 <div align="center" style="width:100%">
 <div align="center" style="width:450px">
 <?
        
		
		$appId="167246169967286";
		$devId="1290795573157";
		$secret="0MzkxMTEyOTA3OTU1NzMxNTc=";
		$signature=md5($secret.$appId.$uid);
		//if(isset)
		$custom=$_COOKIE['hash'];
		?>
        
        <div id="sc_a"></div>
        <div id="sc_b" style="display:none;"></div>
        <script type="text/javascript">
        var appId="<?=$appId?>";
        var devId="<?=$devId?>";
        var senderId="<?=$uid?>";
        var signature="<?=$signature?>";
        var locale="en_US";
        var style="2";
        var iframe="1"
        var network="1"; 
        var callerTxId="<?=$buy_id?>_<?=$custom?>";
        </script>
        <script type="text/javascript" src="http://sparechange.s3.amazonaws.com/crossDomainPopup.js"></script>
 </div>       
 </div>       