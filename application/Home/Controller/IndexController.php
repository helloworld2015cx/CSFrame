<?php
namespace app\Home\Controller;



class IndexController{

    public function index(){
        echo "This is in the IndexController@index !";
        return [1,2,3,4,5];
    }
}

