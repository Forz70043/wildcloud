<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/includes/inclusioni.php");

class ValidateId extends Validate
{
    public function __construct($options=array()){
        parent::__construct($options);
    }

    protected function do_validate($value)
    {
        if(($value=trim($value))==='') {
        $this->setError(_('Campo obbligatorio'));
            return false;
        }
        if(!is_numeric($value) || $value<=0) {
        	$this->setError(_('Il campo deve essere un intero positivo'));
                return false;
        }
        return intval($value);
    }
}

?>
