<?php

class Action {
	
	protected $url;
	protected $label;
	protected $class;
	protected $onclick;
	protected $tplname;

	public function __construct($label,$url,$class='',$onclick=false,$tplname=false,$title=false)
	{
		$classAliases=array(
			'action add'   =>'plus',
			'action search'=>'list',
			'action delete'=>'times'
		);

		$this->url=$url;
		$this->label=$label;
		if(isset($classAliases[$class])) $this->class=$classAliases[$class];
		else $this->class=$class;
		$this->onclick= $onclick===false? "javascript:location.href='$url'":$onclick;
		$this->tplname=$tplname;
		$this->title=$title;
	}

	public function __set($name,$value){
      $this->$name = $value;
    }

    public function __get($name) 
    {
        $f = array('url', 'label', 'class','onclick', 'tplname','id');
        if(in_array($name, $f)) return $this->$name;
        return null;
    }

    public function setOnclick($action){
        $this->onclick=$action;
    }

};


?>