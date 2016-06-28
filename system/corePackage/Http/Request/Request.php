<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/22/
 * Time: 0:26
 */

namespace sys\corePackage\Http\Request;


use sys\corePackage\ConfLoader\ConfLoader;

class Request
{


    private $pathInfoArr;

    public static function init(){
        return new self;
    }


    public function getPathInfo(){
        return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO'] :'';
    }

    public function getAccessTo(){
        $pathInfo = $this->getPathInfo();
        if($pathInfo){
            $pathInfo = ltrim($pathInfo , '/');
            $pathInfo = explode('/' , $pathInfo);
            $pathInfoArr = ['module'=>$pathInfo[0],'controller'=>$pathInfo[1].'Controller','method'=>$pathInfo[2]];
        }else{
            $pathInfoArr = $pathInfo=='' ? std_to_array(ConfLoader::init()->conf('sys.default_access')) : '';
        }
        $this->pathInfoArr = $pathInfoArr;
        return $pathInfoArr;
    }

    public function getAccessModule(){
        return $this->pathInfoArr['module'];
    }

    public function getAccessController(){
        return $this->pathInfoArr['controller'];
    }

    public function getAccessMethod(){
        return $this->pathInfoArr['method'];
    }


    public function getServerName(){
        return $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : '';
    }

}