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

    public static function init(){
        return new self;
    }

    public function getRequestNameSpace(array $MCM){
//        dump($MCM);
        $str = '\\app\\'.$MCM['module'].'\\Controller\\'.$MCM['controller'];
        return $str;
    }

}