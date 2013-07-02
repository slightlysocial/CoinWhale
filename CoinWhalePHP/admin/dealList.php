<?php
include_once("functions.php");
include_once("dealListFunctions.php");
include_once("indexFunctions.php");
//echo date("F j, Y, g:i a"); 
isLogin();
headerPage();
dealListPage();
footerPage();
?>
<script type="text/javascript">
dataTable();
</script>