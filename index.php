<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/wildcloud/common/inclusioni.php");
session_start();
Header("location: auth/login.php");

?>
