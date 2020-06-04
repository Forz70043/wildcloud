<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/includes/inclusioni.php");


class Validate 
{
	protected $errors;
	protected $options;

	public function __construct($options=array()){
		$this->errors=array();
		$this->options=array();
	}

	protected function do_validate($value){
        return false;
    }
  
    protected function do_validate_call($value)
    {
        if(trim($value)==='') {
            if(isset($this->options['not_empty'])) {
                $this->setError(_('Il campo non può essere vuoto'));
                    return false;
            }
            else if(isset($this->options['null'])) return null;
        }
        return $this->do_validate($value);
    }
    
    public static function create($type,$options=array())
    {
        $classname='Validate'.ucfirst($type);
        return new $classname($options);
    }
    
    public static function valid($value,$type,$options=array())
    {
        if(!($validator=self::create($type,$options))) return false;
        return $validator->validate($value);
    }


	public function validate($value,$all=false)
    {
        $valid=true;
        $this->errors=array();
        if(is_array($value)) {
            $nvalue=array();
            foreach($value as $k=>$v) {
                if(($v=$this->do_validate_call($v))===false) $valid=false;
                else $nvalue[$k]=$v;
            }
            if($all && !$valid) return false;
            return sizeof($nvalue)?$nvalue:false;
        }
        else return $this->do_validate_call($value);
    }

    public function setError($error){
        $this->errors[]=$error;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function isValid(){
        return sizeof($this->errors)?false:true;        
	}



};

?>