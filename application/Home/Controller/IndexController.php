<?php
namespace app\Home\Controller;

use sys\corePackage\Controller;


class IndexController extends Controller{

    public function index(){
//        echo "This is in the IndexController@index !";
//        $this->assign('test' , 'Hello World !');

        $this->display();
    }

    public function test(){
        dump('Hello World !');
    }
}

