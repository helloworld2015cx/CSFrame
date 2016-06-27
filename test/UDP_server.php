<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/24/
 * Time: 0:34
 */

$udp_server = new swoole_server('0.0.0.0' , 9502 , SWOOLE_PROCESS , SWOOLE_SOCK_UDP);

$udp_server->set(array('worker_run'=>4 , 'dispatch_mode'=>2));


$udp_server->on('receive' , function(swoole_server $udp_server , $fd , $from_id , $data){
    $udp_server->send($fd , 'Swoole : '.$data , $from_id);
});

$udp_server->start();



