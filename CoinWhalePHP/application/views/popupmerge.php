<script type="text/javascript">
function updateMerge(val)
{
	var merge=document.getElementById('merge');
	merge.value=val;
	document.frm.submit();
} 
</script>
<div id="modal-waves-wrapper" style="width:auto;" align="center">
    <div id="content" align="center">
    <div class="sp"></div>
    <h2>Is This You?</h2>
    <p>&nbsp;</p>	
    <div>&nbsp;</div>
    <h2>Based on the Facebook account you connected with, we think this information might be yours. Is this you?</h2>
   <div>&nbsp;</div>
    <table cellpadding="0" cellspacing="0" width="300px" border="0">
    <tr>
    <td width="70px" style="text-align:left">Name:
    </td>
    <td><?=$name?></td>
    </tr>
     <tr>
    <td width="70px" style="text-align:left">Email:
    </td>
    <td><?=$email?></td>
    </tr>
    </table>
   
		<div>
        <form action="<?=base_url()?>home/" method="post" target="_top" id="frm" name="frm">
        <input type="hidden" id="step" name="step" value="5" />
        <input type="hidden" id="merge" name="merge" value="1" />
        <input type="image" src="<?=base_url()?>images/yes.png" name="image" width="100"  onclick="updateMerge(1)"/> &nbsp;&nbsp; <input type="image" src="<?=base_url()?>images/no.png" name="image" width="100"  onclick="updateMerge(2)"/>
        </form>
        </div>
	</div>
</div>