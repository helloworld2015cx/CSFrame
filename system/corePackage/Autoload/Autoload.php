<?php
//namespace sys\corePackage\Autoload;

const ERROR_TYPES = array(
    E_ERROR => 'Error',
    E_WARNING => 'Warning',
    E_PARSE =>'Parse',
    E_NOTICE => 'Notice'
);

class Autoload{

    public static function init(){
        return new self;
    }

    private function __construct(){

    }


    public static function run(){

        ini_set('display_errors','off');

        spl_autoload_register([ __CLASS__ , 'autoload'] );

        self::init()->load_declare_const();

        require_once(ROOT.'system/function/functions.php');
//        sem_acquire();
//        msg_send();
        set_error_handler([__CLASS__ , 'error']);
//
        set_exception_handler([__CLASS__ , 'exception']);
//
        register_shutdown_function([__CLASS__ , 'shutdown']);

    }


    protected static function autoload($class_name){
        $name_piece = explode('\\',$class_name , 2);
        $className = 'system/'.str_replace('\\' , '/' , $name_piece[1]);
        require_once(ROOT.$className.'.php');
    }




    protected function load_declare_const(){
        require_once(ROOT.'system/consts.php');
    }

//    protected function load_core(){
//        $map = __DIR__.'/loadmap.php';
//        if(!is_file($map)){
//            exit('Not find core class map file !');
//        }
//        $classes = require_once($map);
//        load($classes , LOAD_PACKAGE);
//    }


    private static function shutdown(){

        $error_type = ERROR_TYPES;

        $ers=error_get_last();
        if($ers['type'!=8 && $ers['type']]){
            $err_msg='[ '.date('Y-m-d H:i:s').' ] '.$error_type[$ers['type']].' : '.$ers['message']."\n[ position ]".$ers['file'].' line'.$ers['line']."\n";
            dump($err_msg);
        }
//        dump('error_get_last() in shutdown method : ');dump(error_get_last());
//        dump('error_reporting() in  shutdown method: ');dump(error_reporting());
    }

    private static function error($current_error_type , $error_message , $error_position , $error_line ){
        $types = ERROR_TYPES;
        if($current_error_type!=8 && $current_error_type){
            $err_msg='[ '.date('Y-m-d H:i:s').' ] '.$types[$current_error_type].' : '.$error_message."\n[ position ] ".$error_position.' line:'.$error_line.' '."\n";
            dump($err_msg);
        }
    }

    private static function exception(){
        dump('error_get_last() in exception method : ');dump(error_get_last());
        dump('error_reporting() in exception method : ');dump(error_reporting());
        dump('This is exception method !');
    }

//    private static function


    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(new self , $name) , $arguments);
    }

}