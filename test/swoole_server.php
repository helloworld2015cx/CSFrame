<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/23/
 * Time: 22:53
 */

$server = new swoole_server('0.0.0.0' , 9501);


$server->on('connect' , function($server , $fd , $from_id)
{
    echo "connected !\n";
});

$server->on('receive' , function(swoole_server $server , $from_id , $data)
{
    echo "Received : ".$data."\n";
    $server->send($from_id , "server :".$data);
});

$server->on('close' , function($server , $fd , $from_id)
{
    echo "Closed\n";
});

//$server->on('error' , function($server){});
$server->start();
