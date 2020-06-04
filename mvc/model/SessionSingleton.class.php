<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class SessionSingleton {
	private static $instance=null;

	private function __construct() {}
	private function __clone() {}

	public static function getInstance($classname,$varname='')
	{
		if(self::$instance) return self::$instance;
		if(!$varname) $varname=$classname;
		if(array_key_exists($varname,$_SESSION) && is_a($_SESSION[$varname],$classname)) return self::$instance=$_SESSION[$varname];
		self::$instance=new $classname();
		$_SESSION[$varname]=self::$instance;
		return self::$instance;
	}
};

?>