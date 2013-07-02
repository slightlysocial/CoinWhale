function dataTable()
{
	oTable = $('#example').dataTable( {
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
	} );
	oTable.fnSort( [ [0,'desc'] ] );
}
function checkDelete(msg)
{
	if(confirm(msg))
	{
		return true;
	}
	else
	{	
		return false;
	}
}
function getArt(flag)
{
	document.getElementById("art").disabled = true;
	var catId = document.getElementById("cat").value;
	site_url = "ajaxcall/process.php";
	$.ajax({
		type: "POST",
		url: site_url,
		data: "pro=getArt&catId="+catId,
		success: function(msg)
		{
			document.getElementById("art").disabled = false;
			document.getElementById("art").innerHTML = msg;
			if(flag ==2)
			{
				getAtt2();
			}
			else
			{
				getAtt();
			}
		}
 	});
}
