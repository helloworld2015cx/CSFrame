<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:20
 */

namespace sys\corePackage\Model\operate\DB;

use sys\corePackage\Exception\Exception;
use sys\corePackage\ConfLoader\ConfLoader;

class DBoperate implements DBoperInterface{

    use SQLexcutor;

    private $where = '';
    private $groupByField = '';
    private $orderByField = '';
    private $limit;
    private $table;
    private $alias='';
    private $join = '';
    private $last_sql = '';
    private $distinctFields = '';

    private static $DBC;

    public static function init(){
        if(!self::$DBC){
            $db_conf = ConfLoader::init()->conf('db.mysql');
            self::$DBC = new self($db_conf->host,$db_conf->username,$db_conf->password,$db_conf->db , $db_conf->port);
        }
        return self::$DBC;
    }

    public function table($table){
        $this->table = ' '.$table;
        return $this;
    }

    public function alias($table_alias){
        $this->alias = $table_alias;
        $this->table = $this->table.' as '.$table_alias;
        return $this;
    }

    /*
     * 传递参数则通过主键查询 ， 没有参数则只拿第一个记录
     * $property->primary_key
     * */
    public function find($id=''){
        if($id){
            $pri = $this->get_primary_key();
//            dump($pri);
            if($pri){
                $this->where = ' where '.$pri.'="'.$id.'"';
            }else{
                error_message(new \Exception('table '.$this->table.'without primary key',10004));
            }
        }else{
            $this->limit(1);
        }
        $this->groupByField = '';
        $this->orderByField = '';

        $arr = $this->select();
        return $arr[0];
    }

    public function first(){
        return $this->find();
    }

    public function distinct($fields)
    {
        $this->distinctFields = $fields;
        return $this;
    }

    private function get_primary_key(){
        $sql = 'desc '.$this->table;
        $result = $this->get_result($sql);
        foreach($result as $k=>$v){
            if($v['Key']=='PRI'){
                return $v['Field'];
            }
        }
        return null;
    }

    public function where($field , $compare='=' , $value='' , $connect = ' and '){

        if($field instanceof \Closure){
           $condition = $field()->form_where_conditions();
            $this->where .= $condition;
            return $this;
        }

        $num = func_num_args();
        if($num == 2){
            $value = '"'.$compare.'"';
            $compare = '=';
        }elseif(preg_match('/in/i',$compare)){
            if(is_array($value)){
                $value = '("'.join('","' , $value).'")';
            }
        }else{
            $value = '"'.$value.'"';
        }
        $compare = ' '.$compare.' ';
        $this->where = $this->where.$this->get_where_delimiter($connect).$field.$compare.$value;
        return $this;
    }

    public function orWhere($function , $compare = '=' , $value=''){
        if($function instanceof \Closure){
            $condition = $function()->form_orwhere_conditions();
            $this->where.=$condition;
        }else{

            $num = func_num_args();
            if($num == 2 ){
                $value = $compare;
                $compare = '=';
            }
            $this->where($function,$compare,$value,$connect=' or ');
        }
        return $this;
    }

    public function form_orwhere_conditions(){
        return ' or ('.$this->where.')';
    }

    public function form_where_conditions(){
        return ' and ('.$this->where.')';
    }

    public function groupBy($field){
        $this->groupByField = $field;
        return $this;
    }

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
//        $this->orderByField = ' order by '.$field;
        $this->orderByField = $field;
        return $this;
    }

    public function limit($start , $num=''){
        func_num_args()==1 ? : $start.=',' ;
        $this->limit = ' limit '.$start.$num;
        return $this;
    }

    protected function formSql(){

        $orderBy = $this->orderByField ? ' order by '.$this->orderByField :'';

        $groupBy = $this->groupByField ? ' group by '.$this->groupByField : '';

        return 'from'.$this->table.$this->join.$this->where.$groupBy.$orderBy.$this->limit;
    }


    private function get_where_delimiter($connect){
        if(preg_match('/or/i',$connect)){
            return $connect;
        }elseif($connect==STR_NULL){
            return '';
        }else{
            $this->where ? $connect = ' and ': $connect = ' where ';
            return $connect;
        }
    }

    public function select($field = '*'){

        if($this->distinctFields && is_array($this->distinctFields)){
            $field = ' distinct '.join(',',$this->distinctFields);
        }elseif($this->distinctFields){
           $field = ' distinct '. $this->distinctFields;
        }else{
            if(is_array($field)){
                $field = join(',',$field);
            }
        }

        $sql = 'select '.$field.' '.$this->formSql();
        return $this->get_result($sql);
    }

    /*
     * 单条记录更新操作
     * */
    public function update(array $data){
        $str = ' set ';
        $table = $this->alias?$this->alias:$this->table;

        if(is_array($data)){
            foreach($data as $key=>$value){
                $str .= $table.'.'.$key.'="'.$value.'",';
            }
            $str = rtrim($str,',');
        }
        $sql = 'update '.$this->table.$str.$this->where;

        return $this->get_result($sql);
    }

    /*
     * delete from table where conditions
     * 不传递参数时 根据筛选条件进行删除
     * 传入数值参数，作为主键值进行删除
     * 传入数组参数，数组内的每一个值作为一个主键值进行删除
     * */
    public function delete($id=''){

        if(!$id)
            $sql = 'delete from'.' '.$this->table.' '.$this->where;
        else
            if(!is_array($id)) {
                $sql = 'delete from' . ' ' . $this->table . ' where ' . $this->get_primary_key() . '="' . $id . '"';
            }else {
                $ids = join('","', $id);
                $sql = 'delete from' . ' ' . $this->table . ' where ' . $this->get_primary_key() . ' in ("' . $ids . '")';
            }
        $this->get_result($sql);
        return mysqli_affected_rows($this->db);
    }

    /*
     * insert into table_name (column1 , column2 ...) values ('value1' , 'value2' ...);
     * 一次插入一条记录传递一维数组，
     * 一次插入多条记录传递二维数组
     * */
    public function insert(array $data){
        $re = is_array($data) ? $this->form_insert_data($data) : error_message(new Exception(' insert method needs array as parameter',20001));
        $sql = 'insert into'.' '.$this->table.$re;
        $this->get_result($sql);
        return mysqli_insert_id($this->db);
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

    private function join($table , $column1 , $column2 , $direction='inner'){
        $this->join .= " $direction join ".$table.' on '.$column1.'='.$column2.' ';
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

    public function get_sql_result($sql){
        $sql = sql_filter($sql);
        return $this->get_result($sql);

    }

    private function get_result($sql){

        $this->last_sql = $sql;

        try{
            $this->execute($sql);
        }catch (Exception $e){
            $e->error_trace();
        }
        $result = [];

        $mysqli_result = $this->result;

        while($row = @mysqli_fetch_assoc($mysqli_result)){
            $result[] = $row;
        }
        @mysqli_free_result($this->result);

        return $result ? $result : mysqli_affected_rows($this->db);
    }

    public function get_last_sql()
    {
        return $this->last_sql;
    }

    public function __destruct(){
        unset($this->db);
    }

}