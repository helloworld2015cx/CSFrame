<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/22/
 * Time: 0:26
 */

namespace sys\corePackage\Http\Request;


class Request
{


    public static function init(){
        return new self;
    }


    public function getPathInfo(){
        return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO'] :'';
    }

    public function getAccessTo(){
        $pathInfo = $this->getPathInfo();
        $pathInfo = ltrim($pathInfo , '/');
        $pathInfoArr = explode('/' , $pathInfo);
        return $pathInfoArr;
    }

}