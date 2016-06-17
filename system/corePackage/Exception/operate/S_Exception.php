<?php
namespace sys\corePackage\Exception\operate;

class S_Exception{

    public static function init(){
        return new self;
    }

    public function test(){
        echo "Hello World !\n";
    }


}




