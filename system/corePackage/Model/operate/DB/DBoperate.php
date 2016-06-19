<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:20
 */

namespace sys\corePackage\Model\operate\DB;

use sys\corePackage\Exception\Exception;
//use sys\corePackage\Model\operate\DB\DBoperInterface;
//use sys\corePackage\Model\operate\DB\DBconnector;

class DBoperate implements DBoperInterface{

//    use DBconnector;
    use SQLexcutor;

    private $where = '';
    private $groupByField = '';
    private $orderByField = '';
    private $limit;
    private $table;
    private $alias='';

//    use Connector;

    public static function init(){
        return new self('127.0.0.1','root','root','mysql');
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

    public function test(){
//        try{
//            $obj = new self;
//            $obj1 = new self;
//            $this->where('field0','like','%cheng%')->orWhere(function()use($obj){
//            $condition = $obj->where('field1','>',100,'')->where('field2','cheng')->orWhere('id','888');
//                return $condition;
//            })->where('xiang','xiang')->where(function()use($obj1){
//                return $obj1->where('andwhere','=','andwhere','')->orWhere('ccc','sss');
//            });
//            dump($this->where);
//        }catch (Exception $e){
//            $e->error_trace();
//        }
    }

    public function groupBy($field){
//        $this->groupByField = ' group by '.$field;
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

//        $table_or_alias = $this->alias ? $this->alias : $this->table;

//        $orderByField =is_array($this->orderByField) ? join(',',$this->orderByField) : $this->orderByField;

        $orderBy = $this->orderByField ? ' order by '.$this->orderByField :'';

//        if(is_array($orderByField)){
//            foreach($orderByField as $v){
//                $orderBy .= $table_or_alias.'.'.$v.',';
//            }
//            $orderBy = rtrim($orderBy,',');
//        }else{
//
//        }

        $groupBy = $this->groupByField ? ' group by '.$this->groupByField : '';

        return 'from'.$this->table.$this->where.$groupBy.$orderBy.$this->limit;
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

        if(is_array($field)){
            $field = join(',',$field);
        }
        $sql = 'select '.$field.' '.$this->formSql();
        return $this->get_result($sql);
    }


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
     *
     * */
    public function insert(array $data){
        $re = is_array($data) ? $this->form_insert_data($data) : error_message(new Exception(' insert method needs array as parameter',20001));
        $sql = 'insert into'.' '.$this->table.$re;
        return $this->get_result($sql);
    }

    private function form_insert_data(array $data){
        $keys =array();
        $values = array();
        foreach($data as $key=>$value){
            $keys[] = $key;
            $values[] = $value;
        }
        $key_str = ' ('.join(',' , $keys).')';
        $value_str = '("'.join('","' , $values).'")';

        return $key_str.'values'.$value_str;
    }

    public function get_sql_result($sql){
        $sql = sql_filter($sql);
        return $this->get_result($sql);

    }

    private function get_result($sql){
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

        return $result ? $result : true;
    }

}