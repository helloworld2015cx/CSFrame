<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 19:42
 */

namespace sys\corePackage\Model\operate\DB;


use sys\corePackage\Exception\Exception;

abstract class DBconnector{

    protected $dbc;
    protected $database;
    protected $host;
    protected $port;
    protected $username;
    protected $password;


    private function __construct(){
        $this->dbc = mysqli_connect();
    }

    /*
     * set the default database to connect !
     * @database is the default database set to connect ;
     * */
    abstract function setDB($database);

    /*
     * set the default database host to connect !
     * @$host is the host name to set !
     * */
    abstract function setHost($host);

    /*
     * set $port
     * */
    abstract function setPort($port);

    abstract function setUser($username);

    abstract function setPass($password);

    public function connect(){
        try{
            $dbc = mysqli_connect($this->host,$this->username,$this->password,$this->port);
            if($dbc){
                $this->dbc = $dbc;
            }else{
                throw new Exception('Database connected failed !');
            }
        }catch (Exception $e){
            $e->error_trace();
        }

    }

}