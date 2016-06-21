<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/20/
 * Time: 0:14
 */
namespace sys\corePackage\Log\operate\LogInterface;

interface LoggerInterface{

    public function error($message);
    public function warning($message);
    public function debug($message);
    public function info($message);
    public function message($message);

}