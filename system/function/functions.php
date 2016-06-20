<?php

/*
 * system functions here !
 * */

if(!function_exists('dump')){

    function dump($message_o , $size = DEBUG_FONT_SIZE , $position = DEBUG_POSITION){
        $message = print_r($message_o , true);
        $co = '<span style="color:#ff7d18;font-weight: bold">"</span>';
        $style = "<p style='margin:0;background-color:#000;color:#0f0;width: ".DEBUG_WIDTH.";margin:0 auto;
                  padding:10px;line-height:1.5em;border-radius: 2px;font-size:".$size.";font-family:Consolas;text-align:".$position."'>";
        echo "<pre style='margin:3px;white-space: pre-wrap;text-overflow: ellipsis;width: 100%;overflow:hidden'>";
        echo $style.$co.$message.$co."</p>";
        echo "</pre>";
    }
}


if(!function_exists('root')){
    function root($path_to_dest0=''){
        $path_to_dest = str_replace('\\','/',$path_to_dest0);
        $path_to_dest = ROOT.trim($path_to_dest,'/');

        $is_dir = is_dir($path_to_dest);
        $is_file = is_file($path_to_dest);

        try{
            if(!($is_file || $is_dir)){
                throw(new Exception('Not a file or directory !'));
            }
        }catch (Exception $e){
//            echo "<h1 style='font-size: 25px;width:".DEBUG_WIDTH.";background-color:#bbb;margin:0 auto'>".$e->getMessage()."</h1>";
//            dump('[ '.date('Y-m-d H:i:s').' ] '.$e->getFile().' [ '.$e->getLine().' ] ');
//            exit(1);
            error_message($e);
        }

        if($is_file || !$path_to_dest0){
            $last_delemiter = '';
        }else{
            $last_delemiter = '/';
        }
        return $path_to_dest.$last_delemiter;
    }
}

if(!function_exists('load')){

    function test_file($file){
        try{
            if(!is_file($file)){
                throw new Exception('Not a file ! can not load !' , '10002');
            }
        }catch(Exception $e){
            error_message($e);
        }

    }

    function load($classname , $type=LOAD_){

//        global $test_file;

        if($type == LOAD_PACKAGE){
            $path = PACKAGE_PATH;
        }elseif($type == LOAD_EXTENSION){
            $path = EXTENSION_PATH;
        }else{
            $path = rtrim(ROOT,'/');
        }

        if(is_array($classname)){
            foreach($classname as $class){
                $package = $path.$class.'/';
                $required = $package.'autoload.php';
                $requirements = require_once($required);

                foreach($requirements as $require){

                    test_file( $package.$require );
                    require_once( $package.$require );
                }

                $enterfile = $package.$class.'.php';
                test_file($enterfile);
                require_once(trim($enterfile));
            }
        }else{
            test_file($classname);
            require_once($classname);
        }
    }
}

if(!function_exists('error_message')){
    function error_message(Exception $e){
        $error_message = $e->getMessage();
        $lastFile = $e->getFile().'('.$e->getLine().')'.'  # Error code [ '.$e->getCode() . ' ] ';
        $trace = $e->getTraceAsString();
        dump($error_message,25,'center');
        dump($lastFile);
        dump($trace);
        exit(1);
    }
}


if(!function_exists('std_to_array')){
    function std_to_array(\stdClass $std){
        $error_typer = get_object_vars($std);
        foreach($error_typer as $k=>$v){
            if($v instanceof \stdClass){
                $value = std_to_array($v);
                $error_typer[$k] = $value;
            }
        }
        return $error_typer;
    }
}


if(!function_exists('array_recursion')){
    function array_recursive_update(&$error_typer , array $keys , $value){
        if(!is_array($error_typer)){
            throw new Exception(__FUNCTION__." first parameter needs an array !" , 10003);
        }

        if(is_array($keys)){
            $keysize = sizeof($keys);
            $tmp = '';
            for($i=0 ; $i<$keysize-1 ; $i++){
                if($i==0){
                    $tmp = $error_typer[$keys[0]];
                }else{
                    $tmp = $tmp[$keys[$i]];
                }
            }

            for($j=$keysize-1 ; $j>0 ; $j--){
                if($j == $keysize-1){
                    $tmp[$keys[$j]] = $value;
                }else{
                    $tmp[$keys[$j]] = $tmp;
                }
            }
            $error_typer[$keys[0]] = $tmp;
        }
        return ;
    }
}

if(!function_exists('array_to_std')){
    function array_to_std(&$error_typeray , &$std){
        foreach($error_typeray as $k=>$v){

        }
    }
}


if(!function_exists('sql_filter')){
    function sql_filter($sql){
        $sql = htmlspecialchars($sql);
        $sql = stripos($sql , '--')?error_message(new \Exception('SQL str not safe',10003)):$sql;
        return $sql;
    }
}

if(!function_exists('__error__')){
    function __error__(){
        $error_type = array(
            E_ERROR => 'Error',
            E_WARNING => 'Warning',
            E_PARSE =>'Parse',
            E_NOTICE => 'Notice'
        );
        register_shutdown_function(function() use ($error_type){
            $ers=error_get_last();
            if($ers['type'!=8 && $ers['type']]){
                $err_msg=$error_type[$ers['type']].$ers['type'].': '.' '.$ers['message'].' => '.$ers['file'].' line'.$ers['line'].' : '.date('Y-m-d H:i:s')."\n";
                dump($err_msg);
            }
        });

        set_error_handler(function($current_error_type , $error_message , $error_position , $error_line) use ($error_type){
            if($current_error_type!=8 && $current_error_type){
                $err_msg='[ '.date('Y-m-d H:i:s').' ] '.$error_type[$current_error_type].' : '.$error_message."\n[ position ] ".$error_position.' line:'.$error_line.' '."\n";
                dump($err_msg);
            }
        },E_ALL ^ E_NOTICE);
    }
}








