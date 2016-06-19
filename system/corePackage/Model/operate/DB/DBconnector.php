<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 19:42
 */
namespace sys\corePackage\Model\operate\DB;
use sys\corePackage\Exception\Exception;

trait DBconnector{

    protected $db;
    protected $database;
    protected $host;
    protected $port;
    protected $username;
    protected $password;

    public function __construct($host , $username , $password , $database , $port=3306){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
        try{
            $db = mysqli_connect($host , $username , $password , $database , $port);
            if(!$db) throw new Exception(mysqli_connect_error());
            $this->db = $db;
        }catch (Exception $e){
            error_message($e->error_trace());
        }
    }

    /*
     * set the default database to connect !
     * @database is the default database set to connect ;
     * */
    public function setDB($database){
        $this->database = $database;
        return $this;
    }

    public function setHost($host){
        $this->host = $host;
        return $this;
    }

    public function setUser($username){
        $this->username = $username;
        return $this;
    }

    public function setPort($port){
        $this->port = $port;
        return $this;
    }

    public function setPass($password){
        $this->password = $password;
        return $this;
    }

    public function connect(){
        try{
            unset($this->db);
            $db = mysqli_connect($this->host , $this->username , $this->password , $this->database , $this->port);
            if($db){
                $this->db = $db;
            }else{
                throw new Exception(mysqli_connect_error());
            }
        }catch (Exception $e){
            $e->error_trace();
        }
        return $this;
    }


}