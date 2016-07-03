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

    public function init(){
        dump('Hello World from init method !');
    }


    public function index(){
        echo __METHOD__;
        $this->assign('colorful' , true);
        $this->assign('key' , ['value0' , 'value1' , 'value3']);
        $this->assign('obj' , $this);
//        $this->template->getSmartyObj()->name = 'cheng xiang';

        $this->display();
    }

    public function test(){
        return "Data from transported object output !";
    }

}