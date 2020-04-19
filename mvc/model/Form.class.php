<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/common/inclusioni.php');

class Form {
    
    protected $tbl='';
    public function __construct($tbl,$fields){
        $this->tbl=$tbl;
        $this->fields=$fields;
    }
};



?>