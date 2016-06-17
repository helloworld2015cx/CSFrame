<?php

//use \sys\corePackage\Exception\Exception;

//Exception::test();
//try{
//    throw Exception::init('error test !','10001');
//}catch (Exception $e){
//    $e->error_trace();
//}
/*
 * @ Exception Package loaded successfully !
 * */


use sys\corePackage\ConfLoader\ConfLoader;
//ConfLoader::init()->test();
$re = ConfLoader::init()->conf('db.mysql.host','192.168.1.71');
dump($re);
// ConfLoader Package loaded successfully !