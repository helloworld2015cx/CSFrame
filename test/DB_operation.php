<?php
include './dbconnect.php';

defined('DB_OPER_SELECT')?:define('DB_OPER_SELECT' , 'select');
defined('DB_OPER_UPDATE')?:define('DB_OPER_UPDATE'  , 'update');
defined('DB_OPER_DELETE')?:define('DB_OPER_DELETE' , 'delete');
defined('DB_OPER_INSERT')?:define('DB_OPER_INSERT' , 'insert');

class DBModule{

    private $dbc;
    private $table;
    private $field;
    private $where;
    private $group = array();
    private $order = array();
    private $limit;

    /*
     * 创建单例数据库连接；
     * */
    public function init(DBClass $dbc){
        if($this->dbc){
            return $this;
        }
        return new self($dbc);
    }

    /*
     * 私有的构造函数，不允许外部随意创建连接
     * */
    private function __construct(DBClass $db_con)
    {
        $this->dbc = $db_con;
    }

    /*
     * 设置要操作的数据表
     * */
    public function setTable($table){
        $this->table = $table;
        return $this;
    }

    /*
     * 设置操作为搜索 ， 参数为要搜索的字段
     * */
    public function fields($filed = '*'){
        $this->field = $filed;
        return $this;
    }

    public function where_delimiter(){
        if($this->where){
            $delimiter = ' and ';
        }else{
            $delimiter = '';
        }
        return $delimiter;
    }

    public function where($where){
        $this->$where = $where.$this->where_delimiter(). $this->where;
        return $this;
    }

    public function whereIn($field_name , array $field_allow_values){
        $whereIn = ' '.$field_name.'IN ('.join(',' , $field_allow_values).') ';
        $this->where = $this->where.$this->where_delimiter().$whereIn;
        return $this;
    }

    public function whereLike($field_name , $format = '%%'){
        $this->where = $this->where.$this->where_delimiter().$field_name.' like '.$format;
    }

    public function orWhere(Closure $function , DBModule $db){
        $this->or_where = $function($db);
        return $this;
    }

    protected function subWhere(){
        return $this->where;
    }

    public function groupBy($fields){
        if(is_array($fields)){
            $this->group = $fields;
        }else{
            $this->group[] = $fields;
        }
        return $this;
    }

    public function having($fields){}

    public function orderBy($fields){
        if(is_array($fields)){
            $this->order = $fields;
        }else{
            $this->order[] = $fields;
        }
        return $this;
    }

    public function limit($num){
        $this->limit = $num;
        return $this;
    }

    private function formatSQL($operation=DB_OPER_SELECT){
        switch($operation){
            case DB_OPER_SELECT:
                ;
                break;
            case DB_OPER_UPDATE:
                ;
                break;
            case DB_OPER_INSERT:
                ;
                break;
            case DB_OPER_DELETE:
                ;
                break;

        }
    }

    public function innerJoin(){}
    public function left_join(){}
    public function right_join(){}

    public function select(){}
    public function update(){}
    public function delete(){}
    public function insert(){}


}
