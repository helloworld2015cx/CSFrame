<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/21/
 * Time: 22:30
 */

namespace sys\corePackage\Log\operate\LogInterface;


interface WriterInterface{


    public function set_filename($filename);

    public function set_type($type);

    public function set_user($user);
}