<?php
use Phalcon\Mvc\Controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/23
 * Time: 14:11
 */
class IndexController extends Controller
{

    public function indexAction(){
        echo "<h1>Hello World !</h1>";
    }
}