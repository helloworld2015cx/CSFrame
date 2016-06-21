<?php
//namespace sys\corePackage\Autoload;

const ERROR_TYPES = array(
    E_ERROR => 'Error',
    E_WARNING => 'Warning',
    E_PARSE =>'Parse',
    E_NOTICE => 'Notice'
);

class Autoload{

    private static $AT;

    public static function init(){
        if(self::$AT){
            return self::$AT;
        }
        return new self;
    }


    private function __construct(){

    }

    /**
     * 添加根命名空间的路径（最后一级路径为准）
     */
    public static function add(){}

    public static function run(){

        ini_set('display_errors','off');

        spl_autoload_register([ __CLASS__ , 'autoload'] );

        self::init()->load_declare_const();

        require_once(ROOT.'system/function/functions.php');
//        sem_acquire();
//        msg_send();
        set_error_handler([__CLASS__ , 'error']);

        set_exception_handler([__CLASS__ , 'exception']);

        register_shutdown_function([__CLASS__ , 'shutdown']);

    }


    protected static function autoload($class_name){

        $name_piece = explode('\\',$class_name , 2);

        $pre_path = self::_find_root_dir_($name_piece[0]);

        $full_path = $pre_path.str_replace('\\' , '/' , $name_piece[1]);

        self::_load_file_($full_path);

    }

    protected static function _find_root_dir_($head = 'sys'){

        switch($head){
            case 'sys':
                return ROOT.'system/';
                break;
            case APP_NAME:
                return APP_PATH.APP_NAME;
                break;
            default:
                return '';
                break;
        }

    }

    protected static function _load_file_($path){

        $filename = $path.'.php';

        if(!is_file($filename)){
            throw new Exception($filename.' is not a file ! # line : '.__LINE__);
        }

        require_once($filename);
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