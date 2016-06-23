<?php

include_once('./Unit.php');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/23
 * Time: 9:21
 */
class UnitTest extends PHPUnit_Framework_TestCase
{
    public $unit ;
//    public $startAt;

    /***
     * 环境设定
     * @ $unit is the obj of the tobe test class !
     */
    public function setUp()
    {
//        $this->startAt = microtime();
        parent::setUp();
        $this->unit = new Unit();
    }

    /***
     * unset the object after this test !
     */
    public function tearDown()
    {
//        $last = microtime() - $this->startAt;
//        echo($last);
        parent::tearDown();
        unset($this->unit);
    }


    public function testFirst()
    {
        $this->assertFalse($this->unit->first());
    }

    public function testSecond()
    {
        $this->assertGreaterThanOrEqual( 0 , $this->unit->second());
    }

    public function testThird()
    {
        $this->assertEmpty($this->unit->third());
    }


    /**
     * test the forth method forth()
     */
    public function testForthIsTargetInstance()
    {
        $this->assertInstanceOf(Unit::class , $this->unit->forth());
    }

    public function testForthObjHasAttribute()
    {
        $this->assertObjectHasAttribute('test' , $this->unit);
    }



}