<?php
//use sys\corePackage\ConfLoader\ConfLoader;
//use sys\corePackage\Model\operate\DB\DBoperate;
//use sys\corePackage\Model\operate\DB\DBdriver;
//ConfLoader::init()->test();
//$re = ConfLoader::init()->conf('db.mysql.host.host1');
//dump($re);
//\sys\corePackage\Model\operate\DB\DBoperate::init()->test();
// ConfLoader Package loaded successfully !

//$obj2 = new DBoperate();
//$sql = DBoperate::init()->table('test')->alias('T')->where('name','cheng')->where('age','23')->orWhere(function()use($obj2){
//        return $obj2->where('name','=','shao','')->orWhere('age','20');
//    })->orderBy(['T.age','T.id'])->limit(23,10)->groupBy('T.sex')->select('id , name , age , sex');
//dump($sql);

//$data = array('name'=>'cheng','age'=>'24','weight'=>'60');
//$update_sql = DBoperate::init()->table('vip_users')->alias('vu')->where('id','123')->update($data);
//dump($update_sql);

//$result = DBdriver::init()
//    ->setDB('note')
//    ->connect()
//    ->table('users')
//    ->where('id','2')
//    ->update(['attention'=>'1,2']);

//$result = DBdriver::init()->setDB('note')->connect()->table('users')->where('id','>',0)->find(1);
//$result = DBdriver::init()->setDB('note')->connect()->get_sql_result('desc users');

//$data = [['username'=>'cheng123','password'=>'shaokaidi123','attention'=>'1,2','lever'=>'1'],
//    ['username'=>'shao di','password'=>'shao123','attention'=>'1,2','lever'=>'1'],
//    ['username'=>'xiang123','password'=>'shaokaidi123','attention'=>'1,2','lever'=>'1']
//];
//$result = DBdriver::init()->setDB('note')->connect()->table('users')->insert($data);

//error_get_last();
//die('break here !');
//require 'a.php';
//error_reporting();
//include "Hello.php";
//load('./test.php');

//$result = DBdriver::init()->table('users')->where('age','>','20')->find(3);
//$sql = DBdriver::init()->get_last_sql();
//dump($sql);
//dump($result);
//use sys\corePackage\Log\operate\Writer;
//use sys\corePackage\Log\operate\Logger;
//use sys\corePackage\Log\Log;
//$logger = Logger::init(Writer::init());
//$logger->debug('Hello World ! This is a debug message !');
//Log::error('This is an error message !');
//Log::init()->message('Hello This is written throw the Log class !');

//$result = DBdriver::init()->setDB('note')->connect()->table('users')->where('id' , 8)->delete();

//$obj = DBdriver::init();
//$result = DBdriver::init()->table('class')->where('class.id','<','9')->orWhere(function()use($obj){
//        return $obj->where('classname','=','设计模式','');
//    })
//    ->orderBy('class.id','desc')
//    ->innerJoin('users','class.id','users.id')
//    ->select();
//dump($result);
//dump(strstr('where id=1 limit 10','limit',true));
//$obj = json_decode(file_get_contents(CONF_PATH.'sys'.CONF_EXT));
//dump($obj);


$path = $_SERVER['DOCUMENT_ROOT'].ltrim($_SERVER['SCRIPT_NAME'],'/');
//dump($path);
ob_start();
include_once($path);
$content = ob_get_clean();
dump('Hello World !');
echo $content;

//pathinfo('');

