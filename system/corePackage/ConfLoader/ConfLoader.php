<?php
namespace sys\corePackage\ConfLoader;
use sys\corePackage\ConfLoader\operate\ConfReader;

class ConfLoader{

    public static function init(){
        return  new self;
    }

    public function conf($keys , $value=''){
        if($value===''){
            return $this->read_conf($keys);
        }else{
            return $this->write_conf($keys , $value);
        }
    }

    public function read_conf($key){
        $keys = $this->resolve_key($key);

        $file = array_shift($keys);

        return ConfReader::init($file)->conf($keys);
    }

    public function write_conf($keys , $value){
        $keys = $this->resolve_key($keys);
        $file = array_shift($keys);

        return ConfReader::init($file)->conf($keys , $value);
    }

    private function resolve_key($key){
        $arr = explode('.' , $key);
        return $arr;
    }

    public function test(){
        ConfReader::init('db')->test();
        dump(__METHOD__);
    }



}
