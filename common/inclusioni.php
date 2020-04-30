<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/config/general.config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/functions/functions.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/config/db.config.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/includes/securimage/securimage.php");

function __autoload($classname){
    $searchDirs=array(
        DOCUMENT_ROOT.'/'.'mvc/model/'       =>'.class.php',
        DOCUMENT_ROOT.'/'.'mvc/controller/'  =>'.class.php',
        DOCUMENT_ROOT.'/'.'mvc/model/form/'=>'.class.php',
        DOCUMENT_ROOT.'/'.'includes/Smarty/'=>'.class.php'
    );
    foreach ($searchDirs as $path => $suffix) {
        if(file_exists($path.$classname.$suffix)){
            error_log("XXX file: ".print_r($path.$classname.$suffix,1));
            include($path.$classname.$suffix);
            return;
        }
    }
}

spl_autoload_register("__autoload");
global $smarty; 

$smarty = new SmartyEngine();


?>
