<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/23
 * Time: 9:25
 */
class Unit
{

    private $test = false;

    public function first(){
        return $this->test;
    }


    public function second(){
        return 123;
    }

    public function third(){
        return null;
   }

    public function  forth(){
        return new self;
    }



}