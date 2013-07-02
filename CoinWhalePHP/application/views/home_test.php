<?
$start_date=date("m/d/Y h:i:s A",time());
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
			DisplayFormat = 'DONE DEAL IN <span class="time">%%D%%</span> DAYS and <span class="time">%%H%%</span> HOURS <span class="time">%%M%%</span> MINUTES <span class="time">%%S%%</span> SECONDS.';
			FinishMessage = "<span style='text-align:center;'>DEAL CLOSED!</span>";
			</script>
			<script language="javascript" src="<?=base_url()?>javascript/countdown_test.js"></script>
           </div>
  