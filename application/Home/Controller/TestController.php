<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/7/3/
 * Time: 17:02
 */

namespace app\Home\Controller;
use sys\corePackage\Controller;

class TestController extends Controller
{
    public function index(){
        echo __METHOD__;
        $this->assign('key' , ['value0' , 'value1' , 'value3']);
        $this->display();
    }

}