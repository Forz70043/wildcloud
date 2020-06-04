<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/common/inclusioni.php");

class Role extends Entity 
{
	const TBLNAME = 'ROLE';

    public static function getTitle() {
        return 'Ruoli';
    }

};
