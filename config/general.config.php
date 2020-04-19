<?php

define('DOCUMENT_ROOT',$_SERVER["DOCUMENT_ROOT"]);

// MVC
define('MODEL_PATH',"/mvc/model");
define('VIEW_PATH',"/mvc/view");
define('CONTROLLER_PATH',"/mvc/controller");

define('SESSION_REFRESH_TTL',540);

define('SMARTY_TPL_DIR',DOCUMENT_ROOT."/view/");
define('SMARTY_L_DELIMITER',"[+"); 
define('SMARTY_R_DELIMITER',"+]"); 

define('DB_USER',"root");
define('DB_PASSWORD',"");
define('DB_HOST',"localhost");
define('DB','WILDCLOUD');
define('MYSQL_DEBUG',"1");

?>