<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

sec_session_start();

$smarty = new SmartyEngine();

$smarty->display();

error_log("XXX SESION ".print_r($_SESSION,1));
?>
