function chalDetails()
{
	$("#dialog").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } });
}
function checkNumeric(id)
{
	var val = document.getElementById("qty"+id).value;
	if(!IsNumeric(val))
	{
		alert("Put numeric value in the quantity field");
		document.getElementById("qty"+id).value = 0;
		document.getElementById("qty"+id).focus();
	}
	else if(val < 0)
	{
		alert("Put positive value in the quantity field");
		document.getElementById("qty"+id).value = 0;
		document.getElementById("qty"+id).focus();
	}
}
function IsNumeric(strString)
//  check for valid numeric strings	
{
	var strValidChars = "0123456789.-";
	var strChar;
	var blnResult = true;
	
	if (strString.length == 0) return false;
	
	//  test strString consists of valid characters listed above
	for (i = 0; i < strString.length && blnResult == true; i++)
	  {
	  strChar = strString.charAt(i);
	  if (strValidChars.indexOf(strChar) == -1)
		 {
		 blnResult = false;
		 }
	  }
	return blnResult;
}


$(function() {
$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});
});
$(function(){
	
	//$('#datepicker').datepicker({inline: true});
	$('#markItUp').markItUp(myHtmlSettings);
	initMenu();
	$('.info_div').click(function() {$(this).fadeOut('slow')});
	//$("#dialog").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } });
	$('#tabs').tabs();

	$("#tabledata").resizable({ maxWidth: 940 });
	$.plot($("#placeholder"), [ [[0, 0], [1, 10]]], { yaxis: { max: 10 }, grid: { color: "#000", borderWidth:1} });
	});
	
	
myHtmlSettings = {
    nameSpace:       "html", // Useful to prevent multi-instances CSS conflict
    onShiftEnter:    {keepDefault:false, replaceWith:'<br />\n'},
    onCtrlEnter:     {keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
    onTab:           {keepDefault:false, openWith:'     '},
    markupSet:  [
        {name:'Heading 1', key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Your title here...' },
        {name:'Heading 2', key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Your title here...' },
        {name:'Heading 3', key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Your title here...' },
        {name:'Heading 4', key:'4', openWith:'<h4(!( class="[![Class]!]")!)>', closeWith:'</h4>', placeHolder:'Your title here...' },
        {name:'Heading 5', key:'5', openWith:'<h5(!( class="[![Class]!]")!)>', closeWith:'</h5>', placeHolder:'Your title here...' },
        {name:'Heading 6', key:'6', openWith:'<h6(!( class="[![Class]!]")!)>', closeWith:'</h6>', placeHolder:'Your title here...' },
        {name:'Preview', call:'preview', className:'preview' }
    ]
}		



 function initMenu() {
  $('#menu ul').hide();
  $('#menu ul:first').show();
  $('#menu li a').click(
  function() {
  var checkElement = $(this).next();
  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
  return false;
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
  $('#menu ul:visible').slideUp('normal');
  checkElement.slideDown('normal');
  return false;
  }
  }
  );
  }		
  
  tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	editor_selector : "mce",
	theme_advanced_buttons1 : "bullist,numlist,|,bold,fontsizeselect",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "bottom",
	theme_advanced_toolbar_align : "left",
	plugins : 'inlinepopups',
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras"
});
