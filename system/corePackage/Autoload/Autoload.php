<?php
namespace sys\corePackage\Autoload;

class Autoload{

    public static function init(){
        return new self;
    }

//    private function __construct(){
//
//    }
    protected function autoload($class_name){
//        echo ROOT.'system/corePackage/'.$class_name.'/'.$class_name.'.php<br>';
        require_once(ROOT.'system/corePackage/'.$class_name.'/'.$class_name.'.php');
    }

    private function load_declare_const(){
        require_once(ROOT.'system/consts.php');
    }

    protected function load_core(){
        $map = __DIR__.'/loadmap.php';
        if(!is_file($map)){
            exit('Not find core class map file !');
        }
        $classes = require_once($map);
        load($classes , LOAD_PACKAGE);
    }


    public function test(){
        echo "Hello ,".__FILE__."<br>";
    }

    public function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(new self , $name) , $arguments);
    }

}

