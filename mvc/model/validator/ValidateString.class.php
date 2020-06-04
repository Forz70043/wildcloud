<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/includes/inclusioni.php");

class ValidateString extends Validate 
{
	public function __construct($options = array()){
        parent::__construct($options);
    }

    protected function do_validate($value)
    {
        $value=trim($value);
        $len=strlen($value);
		if(isset($this->options['max_length'])){
	        if($len>$this->options['max_length']){
                $this->setError(sprintf(_('Il valore è troppo lungo. Massimo %d caratteri'),$this->options['max_length']));
                return false;
	        }
		}
		if(isset($this->options['min_length'])){
		    if($len && $len<$this->options['min_length']){
		        $this->setError(sprintf(_('Il valore è troppo corto. Minimo %d caratteri'),$this->options['min_length']));
		        return false;
	        }
		}

		// in enum[0] il nome della tabella, in enum[1] il nome della colonna
        // es. new ValidateString( array('enum' =>  array('NOME_TBLs','colonna_enum')) ),
        if(isset($this->options['enum']) && $value !== ""){
            $r = mysqli_fetch_object(MySqlConnection::query("SHOW COLUMNS FROM `" . $this->options['enum'][0] . "` LIKE '" . $this->options['enum'][1] . "'"));
            preg_match_all("/'([\w ]*)'/", $r->Type, $enums);
            if (!in_array($value, $enums[1])){
                $this->setError(sprintf(_('Il valore deve essere uno tra: '), implode( ", ", $enums[1])) );
                return false;
            }
        }
        
        if(isset($this->options['upper'])) return strtoupper($value);
        else if(isset($this->options['lower'])) return strtolower($value);
        else return $value;
    }

	
};




?>