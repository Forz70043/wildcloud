<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

session_start();

$smarty = new SmartyEngine();

$smarty->display();

?>
