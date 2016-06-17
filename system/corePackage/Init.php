<?php
namespace sys;


abstract class Init{

    public function __callStatic($name, $arguments)
    {
        return call_user_func_array(array($this , $name),$arguments);
    }

}


