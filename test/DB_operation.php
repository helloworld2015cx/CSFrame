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
    private $join;
    private $update_data;
    private $insert_data;

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

    private function where_delimiter(){
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

    public function orWhere(Closure $function){
        $this->or_where = $function();
        return $this;
    }

//    protected function subWhere(){
//        return $this->where;
//    }

    public function groupBy($fields){
        $this->group = $fields;
        return $this;
    }

//    public function having($fields){}
    /*
    * 单个字段排序直接 $field 为字段名，$sort 为排序顺序
    * 多字段排序使用关联数组的方式，键名为字段名，键值为排序顺序
    * */
    public function orderBy($field,$sort='asc'){
        if(is_array($field)){
            $str = '';
            foreach($field as $key=>$value){
                $str .= $key.' '.$value.',';
            }
            $field = trim($str,',');
        }else{
            $field = $field.' '.$sort;
        }
        $this->order = $field;
        return $this;
    }

    public function limit($start , $num=''){
        $paranum = func_num_args();
        $paranum == 1 ? $this->limit = $num : $this->limit = $start.','.$num;

        return $this;
    }

    private function formatSQL($operation=DB_OPER_SELECT){
        $where = $this->where ? ' '.$this->where : '';
        switch($operation){
            case DB_OPER_SELECT:
                $field = is_array($this->field) ? join(',',$this->field) : $this->field;
                $order = $this->order ? ' order by '.$this->order : '';
                $group = $this->group ? ' group by '.$this->group :'';
                $limit = $this->limit ? ' limit '.$this->limit : '';
                return 'select '.$field.' from '.$this->table.$this->join.$where.$group.$order.$limit;
                break;
            case DB_OPER_UPDATE:
                return 'update '.$this->table.' '.$this->update_data($this->update_data);
                break;
            case DB_OPER_INSERT:
                return 'insert into'.' '.$this->table.' '.$this->form_insert_data($this->insert_data);
                break;
            case DB_OPER_DELETE:
                return 'delete from'.' '.$this->table.$where;
                break;
        }
        return null;
    }

    private function join($table , $column1 , $column2 , $direction = 'inner'){
        $this->join .= " $direction join ".$table.' on '.$column1.'='.$column2.' ';
//        return $this;
    }
    public function innerJoin($table , $column1 , $column2){
        $this->join($table , $column1 , $column2 , 'inner');
        return $this;
    }
    public function leftJoin($table , $column1 , $column2){
        $this->join($table , $column1 , $column2 , 'left');
        return $this;
    }
    public function rightJoin($table , $column1 , $column2){
        $this->join($table , $column1 , $column2 , 'right');
        return $this;
    }

    public function select(){
        $sql = $this->formatSQL();
        return $this->getResult($sql);
    }

    public function update(array $data){
        $this->update_data = $data;
        $sql = $this->formatSQL(DB_OPER_UPDATE);
        return $this->getResult($sql);
    }

    public function delete(){
        $sql = $this->formatSQL(DB_OPER_DELETE);
        return $this->getResult($sql);
    }

    public function insert(array $data){
        $this->insert_data = $data;
        $sql = $this->formatSQL(DB_OPER_INSERT);
        return $this->getResult($sql);
    }

    private function update_data(array $data){

        $str = ' set ';
        if(is_array($data)){
            foreach($data as $key=>$value){
                $str .= $key.'="'.$value.'",';
            }
            $str = rtrim($str,',');
        }else{
            throw new Exception('Update parameter $data must be an array !');
        }

        return $str.$this->where;
    }

    private function form_insert_data(array $data){

        $keys =array();
        $values = array();
        $multi = false;

        foreach($data as $key=>$value){
            if(is_array($value)){
                $key1 = array();
                $value1 = array();

                foreach($value as $k=>$v){
                    $key1[] = $k;
                    $value1[] = $v;
                }

                $keys = $key1;
                $values[] = '("'.join('","' , $value1).'")';
                $multi = true;
            }else{
                $keys[] = $key;
                $values[] = $value;
            }
        }

        $key_str = ' ('.join(',' , $keys).')';
        $value_str = $multi ? join(',' , $values) :'("'.join('","' , $values).'")';
        return $key_str.' values '.$value_str;
    }

    private function getResult($sql){
        try {
            $mysql = $this->dbc->execute($sql);
            if(!$mysql){
                throw new Exception(mysql_error($this->dbc));
            }
            return $this->dbc->getResultArray($mysql);
        }catch (Exception $e){
            echo '<h1>'.$e->getMessage().'</h1>';
        }
        return mysql_affected_rows($this->dbc);
    }


}
