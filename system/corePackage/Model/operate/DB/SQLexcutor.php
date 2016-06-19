<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/19/
 * Time: 11:59
 */

namespace sys\corePackage\Model\operate\DB;


use sys\corePackage\Exception\Exception;

trait SQLexcutor
{
    use DBconnector;

    protected $result;



    public function execute($sql){
        $result = mysqli_query($this->db , $sql);
        if(!$result){
            throw new Exception(mysqli_error($this->db),'20000');
        }
        $this->result = $result;
    }

//    abstract function get_result();

}