<?php
include_once("functions.php");
include_once("addUserFunctions.php");
include_once("indexFunctions.php");

isLogin();
headerPage();
addUser();
footerPage();
?>