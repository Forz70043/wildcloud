<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/config/general.config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/functions/functions.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/config/db.config.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/includes/securimage/securimage.php");
require($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/Smarty.class.php');
require($_SERVER["DOCUMENT_ROOT"].'/includes/Smarty/SmartyEngine.class.php');

/*
$SEARCHDIRS=array(
    //MODEL_PATH.'/'							=>	'.php',
    DOCUMENT_ROOT.'/'.MODEL_PATH.'/'		=>	'.class.php',
    //CONTROLLER_PATH.'/'							=>	'.php',
    DOCUMENT_ROOT.'/'.CONTROLLER_PATH.'/'		=>	'.class.php',
    //VIEW_PATH.'/'							=>	'.php',
    DOCUMENT_ROOT.'/'.VIEW_PATH.'/'		=>	'.class.php'
    
);
*/
exec("find -name '*.class.php'",$classes,$ret);
//error_log("ser docu root: ".print_r($_SERVER['DOCUMENT_ROOT'],1));
/*foreach($classes as $class){
    error_log("XXX path: ".$_SERVER['DOCUMENT_ROOT'] .$class);
    include $_SERVER['DOCUMENT_ROOT'].$class;
}
*/
//error_log('SEARCH '.$class_name);
/*
foreach($SEARCHDIRS as $path=>$suffix) {
    error_log('TEST '.$path.$class_name.$suffix);
    if(file_exists($path.$class_name.$suffix)) {
        include($path.$class_name.$suffix);
        return;
    }
}
*/
?>
