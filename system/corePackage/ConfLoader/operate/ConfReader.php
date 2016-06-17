<?php
namespace sys\corePackage\ConfLoader\operate;

class ConfReader{

    private $db_conf;

    public static function init($file){
        return new self($file);
    }

    protected function __construct($file='sys')
    {
        $this->load_config_file($file);
    }

    protected function load_config_file($file){
        $this->db_conf = json_decode(file_get_contents(CONF_PATH.$file.CONF_EXT));
    }


    public function conf(array $keys , $value=''){
        if($value === '' ){
            return $this->read_conf($keys);
        }else{
//            dump('Hello World !'.__LINE__);
            $re = $this->write_conf($keys,$value);
//            dump(json_encode($re));
            return $re;
        }
    }

    protected function read_conf($keys){
        $tmp = '';
        foreach($keys as $k=>$v){
            if($k==0){
                $tmp = $this->db_conf->$v;
            }else{
                $tmp = $tmp->$v;
            }
        }
        return $tmp;
    }

    protected function write_conf($key , $value ){
        $arr = std_to_array($this->db_conf);
        dump($arr);
        foreach($arr as $k=>$v){
            if($v instanceof \stdClass){
            }
        }


        return 0;
    }


    public function test(){
        dump(__METHOD__);
    }


}