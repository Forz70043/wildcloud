<?php

class DB {

    public $connection;
    public $error = array();

    protected $host, $user, $password, $database;

    public function __construct()
    {
        $this->host=DB_HOST;
        $this->user=DB_USER;
        $this->database=DB;
        $this->password=DB_PASSWORD;
    }
    
    /*
        @param table - the target table name
        @param condition - condition can be string,array of object,array of array
        @param sort - the field name that you want to be sorted
        @param order - ASC/DESC
        @param clause - AND/OR
        @return array
    */
    public function connectDB()
    {
        $this->connection=mysqli_connect($this->host,$this->user,$this->password,$this->database);
        if(!$this->connection){
            $e='Failed to connect to DB';
            //$this->setError($e);
            error_log("XXX ".$e);
            return false;
        }
        return $this->connection;
    }

    public function selectFrom($tbl,$fields,$where,$sortBy,$order='ASC',$clausole='AND'){
        
        $query='SELECT ';
        if(isset($fields) && !empty($fields)) $query.=implode(',',$fields);
        else $query.='* FROM '.$tbl;

    }

    public function buildWhereCondition($where){
        if(is_array($where)) $query='';
    }

    public function insertIn($tbl,$fields,$where){
        $query='INSERT INTO '.$tbl;
        
    }


};


?>