<?php
include_once("functions.php");
include_once("salesReportFunctions.php");
include_once("indexFunctions.php");

isLogin();
headerPage();
salesReport();
footerPage();
?>
<script type="text/javascript">
dataTable();
</script>
