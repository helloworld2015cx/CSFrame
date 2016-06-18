<?php
use sys\corePackage\ConfLoader\ConfLoader;
use sys\corePackage\Model\operate\DB\DBoperate;
//ConfLoader::init()->test();
//$re = ConfLoader::init()->conf('db.mysql.host.host1');
//dump($re);
//\sys\corePackage\Model\operate\DB\DBoperate::init()->test();
// ConfLoader Package loaded successfully !

$obj2 = new DBoperate();
$sql = DBoperate::init()->table('test')->where('name','cheng')->where('age','23')->orWhere(function()use($obj2){
        return $obj2->where('name','=','shao','')->orWhere('age','20');
    })->orderBy('age')->limit(23,10)->groupBy('sex')->select('id , name , age , sex');

dump($sql);

