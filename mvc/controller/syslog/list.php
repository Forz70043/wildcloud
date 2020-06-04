<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/includes/inclusioni.php");


$view = new SysLogView($smarty);

$view->display();

?>