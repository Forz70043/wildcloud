<?php

class SqlTableView extends MysqlConnection 
{
	/* query */
    protected $key;
    protected $fields;
    protected $tblname;
    protected $groupby;
    protected $havingFields=array();
    protected $order=array();
    protected $orderType;
    protected $orderDefault;
    protected $orderTypeDefault='ASC';

    protected $filters=array();
    public $staticFilters=array();
    protected $rows=array();
    protected $foundRows=0;

    protected $title;
    protected $header;
    protected $icon=false;
    protected $maskFields = array();
    private $hideStandardActions = 0;

    /* pagination */
    protected $pager=null;
    protected $maxrows=10;

    /* actions */
    protected $actionUrl;
    protected $actions;
    protected $itemActions;

    /* view */
    protected $smarty;
    protected $errorMsg='';
    protected $querystring='';

    /* templates */
    protected $rowTpl;
    protected $filtersTpl='';//'tableview_filters.tpl';
    protected $contentTpl='content.tpl';//'tableview.tpl';

    /* custom js */
    protected $jsfiles=array();
 	/* decorations */
    protected $checkable=1;
    protected $drawRows=true;
    protected $showActions=true;
    protected $showItemActions=true;
    protected $rowsPerPage=array(10,20,30,40,50,100);
    protected $requireFilters=false;

    protected $form_target = '';

    protected $name;
    protected $session_name='';
    protected $isExternal=false;

	public function __construct($smarty,$tblname,$fields=array(),$groupby='',$having=array(),$key='',$actionurl='') 
    {
        $this->key=trim($key);
        $this->tblname=$tblname;
        $this->groupby=$groupby;
        $this->smarty=$smarty;
        $this->form_target=$_SERVER['REQUEST_URI'];//$_SERVER['PHP_SELF'];
        $this->setFields($fields);
        $this->havingFields=is_array($having)?$having:array($having);
        $this->actionUrl=$actionurl;

        $firstfield=$this->getFieldNames();
        $firstfield=$firstfield[0];

        if(!$this->key) $this->key=$firstfield;
        $this->orderDefault=$firstfield;

        $this->setSessionName($this->getSessionName());
        $baseurl=dirname($_SERVER['PHP_SELF']);
        $this->actions = array(
        //     'export' => new Action(_('Esporta'),$_SERVER['PHP_SELF'].'?export=','download',false,'actions/export.tpl'),
             'delete' => new Action(_('Elimina'),$this->actionUrl.'delete.php','times',"if(confirm('"._('Conferma Eliminazione?')."')) postForm('".$this->actionUrl.'delete.php'."',{'view':'%TBVIEW%','controller':'%TBCONTROLLER%'});return false;")
        );
        // $this->actions['delete']->type='select';
        $this->itemActions=array(
            new Action(_('Dettagli'),$this->actionUrl.'edit.php','edit',''),
            new Action(_('Elimina'),$this->actionUrl.'delete.php?confirm=1','times',"return confirm('"._('Conferma Eliminazione %s?')."')"),
        );
    }
 	
 	public function getTableName() {
        return $this->tblname;
    }

	public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title=$title;
    }

	public function getSessionName(){
        return $this->session_name;
    }

    public function setSessionName($name){
        if($name==='') $name=$_SERVER['REQUEST_URI'];//$_SERVER['PHP_SELF'];
        $this->session_name=$name;
    }

    // Fields
 	protected function setFields($fields){
        foreach($fields as $key=>$value){
            $this->addField($key,$value);
        }
    }
	
	public function getFieldNames(){
        return array_keys($this->fields);
    }

	public function getFields() {
        return $this->fields;
    }

	protected function addField($name,$value)
	{
		if(!is_array($value)) {
			$this->fields[$name]=array('sql'=>$value?MysqlConnection::field($value):'','op'=>'LIKE');
		}
		else {
			$this->fields[$name]=array('sql'=>$value?MysqlConnection::field($value[0]):'','op'=>isset($value[2])?$value[2]:'LIKE');
			if(isset($value[1]) && $value[1]) $this->header[$name]=$value[1]; 
		}
	}
	
	public function unsetField($field)
	{
		unset($this->fields[$field]);
		unset($this->header[$field]);
		if(($k=array_search($field,$this->havingFields))!==false) {
			unset($this->havingFields[$k]);
		}
	}

	public function hasField($name)
	{
		if(array_key_exists($name,$this->fields)) return true;
		return false;
	}

	// Order

	public function setDefaultOrder($field,$type='ASC') 
	{
		$this->orderDefault=$field;
		$this->orderTypeDefault=$type;
	}

	public function setOrder($order)
	{
		$this->order=array();
		$fields=$this->getHeaderFields();
		foreach($order as $field=>$type) {
			if(!in_array($field,$fields)) continue;
			$this->order[$field]=$type;
		}
	}

	public function getOrderBy()
	{
		reset($this->order);
		list($by,$type)=each($this->order);
		return $by;
	}

	public function setOrderBy($by)
	{
		if(!in_array($by,$this->getHeaderFields())) return false;
		if(!($type=$this->getOrderType())) $type=$this->orderTypeDefault;
		$this->order=array($by=>$type);
		return true;
	}

	public function getOrderType()
	{
		reset($this->order);
		list($by,$type)=each($this->order);
		return $type;
	}

	public function setOrderType($type)
	{
		if(!in_array($type,array('ASC','DESC'))) return false;
		if(!($by=$this->getOrderBy())) $by=$this->orderDefault;
		$this->order=array($by=>$type);
		return true;
	}

	// Azioni

	public function getActionUrl()
	{
		return $this->actionUrl;	
	}

	public function getActions() 
	{
		return $this->actions;
	}

	public function setActions($actions) 
	{
		if(!is_array($actions)) $this->actions=array($actions);
		else $this->actions=$actions;
	}

	public function addAction($action,$key=false,$type='') 
	{
		if($type) $action->type=$type;
		if($key) $this->actions[$key]=$action;
		else $this->actions[]=$action;
	}

	public function unsetAction($actions) {
		if (is_array($actions)) {
			foreach ($actions as $v)
				if (array_key_exists($v, $this->actions))
					unset($this->actions[$v]);
		}
		else
		if (array_key_exists(trim($actions), $this->actions))
			unset($this->actions[$actions]);
	}

	public function setItemActions($actions) 
	{
		if(!is_array($actions)) $this->itemActions=array($actions);
		else $this->itemActions=$actions;
	}

	public function addItemAction($action) 
	{
		$this->itemActions[]=$action;
	}

	public function getItemActions()
	{
		return $this->itemActions;
	}

	private $_itemActions=null;

	public function getVisibleItemActions()
	{
		if($this->_itemActions===null) {
			$this->_itemActions=array();
			foreach($this->itemActions as $k=>$a) {
				if($a->isVisible()) $this->_itemActions[$k]=$a;
			}
		}
		return $this->_itemActions;
	}

	public function setOrderActions($order = array('exportpdf', 'exportxls', 'export', 'delete')) {
		$ordered = array();
		$acts = $this->getActions();

		foreach ($order as $o) {
			if (isset($acts[$o])) {
				$ordered[$o] = $acts[$o];
				unset($act[$o]);
			}
		}

		if (count($acts)) {
			foreach ($acts as $key => $value)
				$ordered[$key] = $value;
		}

		$this->setActions($ordered);
	}


	// Headers

	public function getHeaders() {
		return $this->header;
	}

	public function getHeaderFields()
	{
		return array_keys($this->header);
	}

	public function getHeader($field)
	{
		if(array_key_exists($field,$this->header)) return $this->header[$field];
		return '';
	}

	public function setHeaders($fields)
	{
		$hdrs=array();
		foreach($fields as $f) {
			if(isset($this->header[$f])) $hdrs[$f]=$this->header[$f];
		}
		$this->header=$hdrs;
	}

	// Decorations

	public function getName()
	{
		if($this->name) return $this->name;
		return $this->getClass();
	}

	public function getClass()
	{
		return get_class($this);
	}

	public function getIcon()
	{
		return $this->icon;
	}

	public function setIcon($url) 
	{
		$this->icon=$url;
	}

	public function isCheckable()
	{
		return $this->checkable;
	}

	public function setCheckable($checkable) 
	{
		$this->checkable=$checkable;
	}


	// Templates

	public function isExternal()
	{
		return $this->isExternal;
	}

	public function setExternal($bool)
	{
		$this->isExternal=$bool;
	}

	public function getFilterAction()
	{
		return $this->form_target;
	}

	public function setFilterAction($url)
	{
		$this->form_target=$url;
	}

	public function getTarget()
	{
		if(strpos($this->form_target,'?')!==false) return $this->form_target.'&';
		else return '?';
	}

	public function getFilterTemplate()
	{
		return $this->filtersTpl;
	}

	public function setFilterTemplate($tplname) 
	{
		$this->filtersTpl=$tplname;
	}

	public function getRows()
	{
		return $this->rows;
	}

	public function getRowTemplate()
	{
		return $this->rowTpl;
	}

	public function setRowTemplate($tplname) 
	{
		$this->rowTpl=$tplname;
	}

	public function setContentTemplate($tplname) 
	{
		$this->contentTpl=$tplname;
	}

	public function getContentTemplate()
	{
		return $this->contentTpl;
	}

	protected function loadAssets()
	{
		return true;
	}

	public function hasFilters()
	{
		return (sizeof($this->getFilters())-sizeof($this->staticFilters))>0;
	}

	public function showFilters()
	{
		if($this->filtersTpl===false) return false;
		else if($this->requireFilters) return true;
		return $this->hasFilters();
	}

	public function getFilters()
	{
		return $this->filters;
	}

	static protected function isFilterValue($value)
	{
		if(is_array($value)) {
			if(!sizeof($value)) return false;
			foreach($value as $v) {
				if(self::isFilterValue($v)) return true;
			}
			return false;
		}
		return !(trim($value)==='');
	}

	public function setFilters($filters) 
	{
		//error_log('SET_FILTERS: '.$this->session_name);
		$fields=array_keys($this->fields);
		foreach($filters as $key=>$value) 
		{
			//if(!is_array($value) && trim($value)==='') continue;
			//else if(is_array($value) && !sizeof($value)) continue;
			if(in_array($key,$fields)) {
				if(!self::isFilterValue($value)) continue;
				$this->filters[$key]=!is_array($value)?trim($value):$value;
			}
		}
		foreach($this->staticFilters as $key=>$value) {
			if($value!==null) $this->filters[$key]=$value;
		}
	}





	// Query

	protected function buildFilterCriteria($field,$value,$op='LIKE')
	{
		$op=strtoupper(trim($op));
		switch($op) {
			case 'LIKE':
			case 'NOT LIKE':
				$value='%'.$value.'%';
				break;
			case '=':
				if(is_array($value)) $op='IN';
				break;
			case '!=':
				if(is_array($value)) $op='NOT IN';
				break;
		}
		return $field.' '.$op.' '.DB::value($value);
	}

	public function buildWhereCriteria() 
	{
		$where=array();
		foreach($this->filters as $key=>$value) {
			if(in_array($key,$this->havingFields)) continue; 
			$filterfunc='filter'.ucfirst($key);
			if(method_exists($this,$filterfunc)) {
				if(($x=$this->$filterfunc($this->fields[$key]['sql'],$value,$this->fields[$key]['op']))!=='') $where[]='('.$x.')';
				else if($x===false) return false;
			}
			else {
				$where[]='('.$this->buildFilterCriteria($this->fields[$key]['sql'],$value,$this->fields[$key]['op']).')';
			}
		}
		return implode(' AND ',$where);
	}

	public function buildHavingCriteria()
	{
		$having=array();
		foreach($this->havingFields as $field) {
			if(!array_key_exists($field,$this->filters)) continue;
			$filterfunc='filter'.ucfirst($field);
			if(method_exists($this,$filterfunc)) {
				if(($x=$this->$filterfunc($field/*$this->fields[$field]['sql']*/,$this->filters[$field],$this->fields[$field]['op']))) $having[]='('.$x.')';
				else if($x===false) return false;
			}
			else {
				$having[]='('.$this->buildFilterCriteria($field/*$this->fields[$field]['sql']*/,$this->filters[$field],$this->fields[$field]['op']).')';
			}
		}
		return implode(' AND ',$having);
	}

	protected function buildOrderBy()
	{
		$order=array();
		if(!is_array($this->order)) return $this->order;
		foreach($this->order as $field=>$type) {
			$type=strtoupper($type);
			if($type!='ASC') $type='DESC';
			$orderfunc='orderBy'.ucfirst($field);
			if(method_exists($this,$orderfunc)) {
				$order[]=$this->$orderfunc($this->fields[$field]['sql'],$type);
			}
			else $order[]=$this->fields[$field]['sql'].' '.$type;
		}
		return implode(',',$order);
	}

	protected function buildQuery($corequery,$fields=array(),$where='',$order='',$limit='',$offset='',$groupby='',$having='')
	{
		$query='SELECT';
		if($limit) {
			$query.=' SQL_CALC_FOUND_ROWS';
		}
		if($fields) $query.=' '.self::select_fields($fields);
		else $query.=' *';
		$query.=' FROM '.$corequery;
		if($where) $query.=' WHERE '.$where;
		if($groupby) {
			$query.=' GROUP BY '.$groupby;
			if($having) $query.=' HAVING '.$having;
		}
		if($order) {
			$query.=' ORDER BY '.$order;
		}
		if($limit) {
			$query.=' LIMIT ';
			if($offset) $query.=$offset.','.$limit;
			else $query.=$limit;
		}
		return $query;
	}

	protected function processRow($row)
	{
		return $row;
	}

	static protected function array2url($data,$name='',$skip=array())
	{
		$url='';
		foreach($data as $k=>$v)
		{
			if(in_array($k,$skip)) continue;
			if(is_array($v)) {
				if($name) $url.=self::array2url($v,$name.'['.$k.']',$skip);
				else $url.=self::array2url($v,$k,$skip);
			}
			else if($name) $url.='&'.$name.'['.$k.']='.urlencode($v);
			else $url.='&'.$k.'='.urlencode($v);
		}
		return substr($url,0,1)=='&'?substr($url,1):$url;
	}


	protected function buildQueryString()
	{
		$this->querystring=self::array2url($this->filters,'');
	}

	public function getQueryString()
	{
		if(!$this->querystring) $this->buildQueryString();
		return $this->querystring;
	}

	protected function executeQuery($limit=false,$onlykeys=false)
	{
		$fields=array();
		$where=$this->buildWhereCriteria();
		if($onlykeys) {
			$fields[]=$this->fields[$this->key]['sql'].' AS '.$this->key;
			foreach($this->havingFields as $field) $fields[]=$this->fields[$field]['sql'].' AS '.$field;
		}
		else {
			foreach($this->fields as $k=>$v) {
				if($this->fields[$k]['sql'])
					$fields[]=$this->fields[$k]['sql'].' AS '.$k;
			}
		}
		if($limit) {
			//$limit=$this->getMaxRows();
			//$offset=$this->getCurrentIndex();
		}
		//else $limit=$offset='';
		//$where=$this->buildWhereCriteria();
		$query=$this->buildQuery($this->tblname,implode(',',$fields),$where,$this->buildOrderBy(),$limit,$offset,$this->groupby,$this->buildHavingCriteria());
		if(($dbr=MysqlConnection::query($query))) {
			$this->foundRows=$this->foundRows();
			while(($r=mysqli_fetch_assoc($dbr))) {
				if(!$onlykeys) {
					if(($r=$this->processRow($r))===false) {
						mysqli_free_result($dbr);
						return false;
					}
				}
				$data[]=$r;
			}
			mysqli_free_result($dbr);
			return $data;
		}
		return false;
	}

	// Session

	public function setSessionFilters()
	{
		$this->setFilters(isset($_SESSION['LIST'][$this->session_name]['filters'])?$_SESSION['LIST'][$this->session_name]['filters']:array());
	}

	public function setSessionOrder()
	{
		if(isset($_SESSION['LIST'][$this->session_name]['order']) && $_SESSION['LIST'][$this->session_name]['order']) $this->setOrder($_SESSION['LIST'][$this->session_name]['order']);
	}

	public function saveSession()
	{
		$_SESSION['LIST'][$this->session_name]['filters']=$this->filters;
		$_SESSION['LIST'][$this->session_name]['order']=$this->order;
	}



	public function execute($session='')
	{
		$r=false;
		$this->setSessionName($session);
		if(isset($_REQUEST['max_rows'])) {
			$this->setMaxRows($_REQUEST['max_rows']);
			$this->setCurrentItem(1);
			unset($_REQUEST['max_rows']);
			$r=true;
		}

		$this->order=array($this->orderDefault=>$this->orderTypeDefault);
		$this->setSessionOrder();
		if(isset($_REQUEST['orderBy'])) {
			$this->setOrderBy($_REQUEST['orderBy']);
			$r=true;
		}
		if(isset($_REQUEST['orderType'])) {
			$this->setOrderType($_REQUEST['orderType']);
			$r=true;
		}
		if(isset($_REQUEST['next'])) {
			$this->getPager();
			$r=true;
		}

		if(isset($_REQUEST['reset'])) {
			$this->setCurrentItem(1);
			$this->setFilters(array());
			$this->order=array($this->orderDefault=>$this->orderTypeDefault);
			$r=true;
		}
		else if(isset($_POST['search'])) {
			$this->setCurrentItem(1);
			$this->setFilters($_REQUEST);
			$r=true;
		}
		else {
			$this->setSessionFilters();
		}
		if($r) {
			$this->saveSession();
			redirect($this->form_target);
			return true;
		}
		return false;
	}

	protected function _display()
	{
		$qs=$this->getQueryString();
		if($this->order) {
			//$this->setPagerUrlParams($qs.'&orderBy='.$this->getOrderBy().'&orderType='.$this->getOrderType());
		}
		//else $this->setPagerUrlParams($qs);
		//$qs.=($qs?'&':'').'next='.$this->getCurrentItem();
		//error_log("XX this: ".print_r($this,1));
		$this->smarty->assign("TABLEVIEW",$this);
		//$this->smarty->assign("rightcontent", "");
		//$pager=$this->getPager();
		//$pager->assign($this->smarty,'paginate',$this->session_name);
		//$this->smarty->displayPage($this->contentTpl);
		$this->smarty->displayPage($this->contentTpl);
	}

	public function draw($name='TABLEVIEW')
	{
		$qs=$this->getQueryString();
		if($this->order) {
			$this->setPagerUrlParams($qs.'&orderBy='.$this->getOrderBy().'&orderType='.$this->getOrderType());
		}
		else $this->setPagerUrlParams($qs);
		//$qs.=($qs?'&':'').'next='.$this->getCurrentItem();
		$pager=$this->getPager();
		$pager->assign($this->smarty,'paginate',$this->session_name);
		$this->paginate=$this->smarty->getTemplateVars('paginate');
		$this->smarty->clearAssign('paginate');
		$this->smarty->assign($name,$this);
	}

	public function run($REQUEST=null,$name='TABLEVIEW')
	{
		if($REQUEST!==null) {
			$oldREQUEST=$_REQUEST;
			$_REQUEST=$REQUEST;
		}
		$this->execute($this->getSessionName());
		if($REQUEST!==null) $_REQUEST=$oldREQUEST;
		$this->loadAssets();
		if(($this->rows=$this->executeQuery())===false) 
		{
			$this->rows=array();
			$this->errorMsg=sprintf(_('Query failed: %s'),$this->getLastError());
		}
		else {
			//$this->setTotal($this->foundRows);
		}
		if(sizeof($this->rows)) {
			$this->saveSession();
		}
		else $this->setCurrentItem(1);
		$this->draw($name);
	}

	public function display($session='')
	{
		$this->execute($session);
		$this->loadAssets();
		if($this->requireFilters && !$this->hasFilters()) {
			$this->rows=array();
			$this->errorMsg=false;
		}
		else
		{
			if(($this->rows=$this->executeQuery())===false) 
			{
				$this->rows=array();
				$this->errorMsg=sprintf(_('Query failed: %s'),$this->getLastError());
			}
			//else $this->setTotal($this->foundRows);
		}
		if(sizeof($this->rows)) {
			$this->saveSession();
		}
		$this->_display();
	}


	// Paging
	/*
	protected function getPager()
	{
		if(!$this->pager) {
			$this->pager=new SmartyPaginate();
			$this->pager->connect($this->session_name,$_REQUEST);
		}
		return $this->pager;
	}
*/
	public function setDefaultMaxRows($max) 
	{
		$this->maxrows=$max;
	}
	/*
	public function setMaxRows($num)
	{
		$pager=$this->getPager();
		$pager->setLimit($num,$this->session_name);
	}
	
	public function getMaxRows()
	{
		$pager=$this->getPager();
		return $pager->getLimit($this->session_name);
	}

	public function getTotal()
	{
		$pager=$this->getPager();
		return $pager->getTotal($this->session_name);
	}

	protected function setTotal($num)
	{
		$pager=$this->getPager();
		$pager->setTotal($num,$this->session_name);
	}

	*/


};

?>