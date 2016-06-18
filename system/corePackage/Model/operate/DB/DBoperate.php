<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:20
 */

namespace sys\corePackage\Model\operate\DB;

use sys\corePackage\Exception\Exception;
use sys\corePackage\Model\operate\DB\DBoperInterface;

class DBoperate implements DBoperInterface{

    private $where = '';
    private $groupByField = '';
    private $orderByField = '';
    private $limit;
    private $table;



    public static function init(){
        return new self;
    }

    public function table($table){
        $this->table = ' from '.$table.' ';
        return $this;
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
        $this->groupByField = ' group by '.$field;
        return $this;
    }

    public function orderBy($field){
        if(is_array($field)){
            $field = join(',' , $field);
        }
        $this->orderByField = ' order by '.$field;
        return $this;
    }

    public function limit($start , $num=''){
        func_num_args()==1 ? : $start.=',' ;
        $this->limit = ' limit '.$start.$num;
        return $this;
    }

    protected function formSql(){
        return $this->table.$this->where.$this->groupByField.$this->orderByField.$this->limit;
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
        return 'select '.$field.' '.$this->formSql();
    }

}