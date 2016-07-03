<?php
namespace sys\corePackage\Creator;


class ControllerCreator{


    public static function init(){
        return new self;
    }

    public function index(){
        echo "Hello World !";
    }


}



