<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class User extends Entity 
{
	const TBLNAME='USER';

	public static function getTitle(){
		return 'Utenti';
	}
	
}


?>