<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:03
 */

namespace sys\corePackage\Model\operate\DB;

use sys\corePackage\Model\operate\DB\DBconnector;

class DBdriver extends DBconnector{

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


}