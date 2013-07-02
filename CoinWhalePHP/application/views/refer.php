<div id="modal-waves-wrapper" style="width:auto;" align="center">
    <div id="content" align="center">
    <div class="sp"></div>
    <h2>Referal Link</h2>
    <p>&nbsp;</p>	
    <div>&nbsp;</div>
<?
if($refer)
{
	echo '<div id="referal-link"><span ><input style="width:450px;" value="'.base_url().'?refer='.$refer.'"/></span></div>';
	?>
    <div>&nbsp;</div>
	<div align="center"><a href="#" style="color:#FFFFFF" onclick="share('<?=base_url()?>?refer=<?=$refer?>')"><img src="<?=base_url()?>images/mini-fb.gif" class="align-image" /> Post to Profile</a></div>
	<?

}else
{
	
	echo "<div style='text-align:center'><h3>Sorry!! Your referal link not found!!</h3></div>";
	
}
?>
		
	</div>
</div>