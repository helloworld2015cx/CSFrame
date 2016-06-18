<?php
namespace sys\corePackage\Exception;
use sys\corePackage\Exception\operate\S_Exception;
use Exception as SysException;
class Exception extends SysException{

    public static function init($message,$code='10000'){
        return new self($message , $code);
    }

    public function __construct($message, $code=10000)
    {
        parent::__construct($message, $code);
    }

    protected function file_not_find_exception(){
        $this->message = 'File not find Exception !';
    }

    public function error_trace(){
        $error_message = $this->getMessage();
        $lastFile = $this->getFile().'('.$this->getLine().')'.'  # Error code [ '.$this->getCode() . ' ] ';
        $trace = $this->getTraceAsString();
        dump($error_message,25,'center');
        dump($lastFile);
        dump($trace);
        exit(1);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(new self(''),$name),$arguments);
    }

    public function test(){
        dump(__FILE__);
        S_Exception::init()->test();
    }


}


