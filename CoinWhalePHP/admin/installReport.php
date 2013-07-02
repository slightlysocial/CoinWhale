<?php
include_once("functions.php");
include_once("installReportFunctions.php");
include_once("indexFunctions.php");

isLogin();
headerPage();
installReport();
footerPage();
?>