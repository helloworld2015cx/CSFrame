<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/22/
 * Time: 0:28
 */

namespace sys\corePackage\Http\Response;


class Response
{

    private static $response;

    public static function init(){

        if(!self::$response) {
            self::$response = new self;
        }

        return self::$response;
    }

    private function __construct(){}

    public function getRequestNameSpace(array $MCM){
//        dump($MCM);
        $str = '\\app\\'.$MCM['module'].'\\Controller\\'.$MCM['controller'];
        return $str;
    }

}
