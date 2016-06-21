<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/20/
 * Time: 0:11
 */
namespace sys\corePackage\Log\operate;

use sys\corePackage\ConfLoader\ConfLoader;
use sys\corePackage\Log\operate\LogInterface\WriterInterface;


class Writer implements WriterInterface{

    private static $writer;

    private $filename = '';

    private $file_type = '';

    private $user;

    public static function init()
    {
        if(!self::$writer){
            self::$writer = new self;
        }
        return self::$writer;
    }

    private function __construct()
    {
        $this->filename = APP_PATH.APP_NAME.'/tmp/log/'.date('Y-m-d').'.log';

        if(!file_exists($this->filename))
        {
            file_put_contents($this->filename , '');
        }
    }

    public function set_filename($filename)
    {
        $this->filename = APP_PATH.APP_NAME.'/'.$filename;
    }

    public function set_type($type)
    {
        $this->file_type = $type;
    }

    public function set_user($writer)
    {
        $this->user = $writer;
    }

    public function keep_msg($message , $type)
    {
        $run_mode = ConfLoader::init()->conf('sys.run_mode');

        $format_message = '['.date('Y-m-d H:i:s').'] ['.($type ? $type : $this->file_type).'] : '.$message."\n";

        if($run_mode=='debug')
        {
            dump($format_message);
        }elseif($run_mode == 'product')
        {
            file_put_contents($this->filename , $format_message ,  FILE_APPEND);
        }
    }

}