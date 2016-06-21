<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/20/
 * Time: 0:09
 */

namespace sys\corePackage\Log;
use sys\corePackage\Log\operate\Logger;
use sys\corePackage\Log\operate\Writer;

class Log{

    private static $log;
    private static $logger;

    public static function init(){
        if(!self::$log){
            self::$log = new self;
        }
        return self::$log;
    }

    private function __construct()
    {
        if(!self::$logger){
            self::$logger = Logger::init(Writer::init());
        }
        return self::$logger;
    }

    public static function __callStatic($func_name , $arguments)
    {
        self::init();
        call_user_func_array([self::$logger , $func_name] , $arguments );
    }

    public function __call($func_name , $argument ){
        call_user_func([self::$logger , $func_name] , $argument);
    }

}