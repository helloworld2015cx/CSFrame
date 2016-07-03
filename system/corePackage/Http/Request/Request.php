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
    private static $request = null;


    public static function init(){

        if(!self::$request){
            self::$request = new self;
        }

        return self::$request;
    }

    private function __construct(){}


    public function getPathInfo()
    {
        return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO'] :'';
    }

    public function getAccessTo()
    {
        $pathInfo = $this->getPathInfo();
//        dump($pathInfo);
        if($pathInfo)
        {
            $pathInfo = trim($pathInfo , '/');
//            dump($pathInfo);
            $pathInfo = $this->dealWithPathInfo($pathInfo);
            $pathInfoArr = ['module'=>$pathInfo[0],'controller'=>$pathInfo[1].'Controller','method'=>$pathInfo[2]];

        }else {
            $pathInfoArr = $pathInfo=='' ? std_to_array( ConfLoader::init()->conf('sys.default_access') ) : '';
        }
        $this->pathInfoArr = $pathInfoArr;
//        dump($this->pathInfoArr);
        return $pathInfoArr;
    }


    private function dealWithPathInfo($pathInfo)
    {
        $pathInfoArr = explode('/' , $pathInfo);

//        dump($pathInfoArr);

        $size = count($pathInfoArr);

        if($size == 3) {

            return $pathInfoArr;

        }elseif($size == 2) {

            $defaultModule = ConfLoader::init()->conf('sys.default_access.module');
            array_unshift($pathInfoArr , $defaultModule);
//            dump($pathInfoArr , 20);
            return $pathInfoArr;

        }elseif($size == 1) {

            $defaultModule = ConfLoader::init()->conf('sys.default_access.module');
            $defaultController = ConfLoader::init()->conf('sys.default_access.controller');

            array_unshift($pathInfoArr , rtrim($defaultController , 'Controller'));
            array_unshift($pathInfoArr , $defaultModule);

//            dump($pathInfoArr);
            return $pathInfoArr;
        }else{
            return null;
        }

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