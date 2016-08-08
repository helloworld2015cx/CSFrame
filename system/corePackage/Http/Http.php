<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/22/
 * Time: 0:25
 */

namespace sys\corePackage\Http;
use sys\corePackage\Http\Request\Request;
use sys\corePackage\Http\Response\Response;

class Http
{

    protected $request;
    protected $response;
    protected static $http;

    protected function __construct(Request $request , Response $response){

        $this->request = $request;

        $this->response = $response;

    }

    public static function init(){
        if(!self::$http){
            self::$http = new self( Request::init() , Response::init());
        }
        return self::$http;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResponse(){
        return $this->response;
    }

    private function requestNameSpace(){
        $pathInfoArr = $this->getRequest()->getAccessTo();
//        dump($pathInfoArr);
        return $this->getResponse()->getRequestNameSpace($pathInfoArr);
    }

    public function getAccessControllerObject(){
        $controller = $this->requestNameSpace();

        dump($controller);
        $obj = new $controller;
        $method = $this->getRequest()->getAccessMethod();
//        ob_start();
        $obj->$method();
//        $outPut = ob_get_clean();
//        echo($outPut);
    }

}