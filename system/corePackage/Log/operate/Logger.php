<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/20/
 * Time: 0:13
 */

namespace sys\corePackage\Log\operate;
use sys\corePackage\Log\operate\LogInterface\LoggerInterface;
//use sys\corePackage\Log\operate\Writer;


class Logger implements LoggerInterface{

    private static $logger;
    private static $writer;

    public static function init(Writer $writer){

        if(!self::$logger){
            self::$writer = $writer;
            self::$logger = new self;
        }

        return self::$logger;

    }


    public function error($message){
        self::$writer->keep_msg($message , 'error');
    }

    public function warning($message){
        self::$writer->keep_msg($message , 'warning');
    }

    public function debug($message){
        self::$writer->keep_msg($message , 'debug');
    }

    public function info($message){
        self::$writer->keep_msg($message , 'info');
    }

    public function message($message){
        self::$writer->keep_msg($message , 'message');
    }

}