<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:20
 */

namespace sys\corePackage\Model\operate\DB;

use sys\corePackage\Model\operate\DB\DBoperInterface;

class DBoperate implements DBoperInterface{

    private $where = '';

    public static function init(){
        return new self;
    }

    public function where($field , $compare , $value='' , $connect = ' and '){

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
        $this->where = $this->where.$this->get_where_delimiter($connect).$field.$compare.$value;
        return $this;
    }


    public function orWhere($function , $compare ='=' , $value=''){
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
        $obj = new self;
        $obj1 = new self;
        $this->where('field0','123')->orWhere(function()use($obj){
            $condition = $obj->where('field1','>',100,'')->where('field2','cheng')->orWhere('id','888');
            return $condition;
        })->where('xiang','xiang')->where(function()use($obj1){
            return $obj1->where('andwhere','=','andwhere','')->orWhere('ccc','sss');
        });

        dump($this->where);
    }


    private function get_where_delimiter($connect){
        if(preg_match('/or/i',$connect)){
            return $connect;
        }elseif($connect==STR_NULL){
            return '';
        }else{
            if($this->where){
                return ' and ';
            }else{
                return ' where ';
            }
        }

    }



    public function select(){

    }

}