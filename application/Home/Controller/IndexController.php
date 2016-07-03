<?php
namespace app\Home\Controller;

use sys\corePackage\Controller;


class IndexController extends Controller{

    public function index(){
        echo "This is in the IndexController@index !";
//        return [1,2,3,4,5];
        $this->assign('test' , 'Hello World !');
        $this->display('index.tpl');
    }
}

