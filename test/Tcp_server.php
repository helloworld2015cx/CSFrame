<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/25/
 * Time: 0:47
 */

$tcp = new swoole_server('0.0.0.0' , 9503);

$tcp->set(array(
    'worker_num'=>4,
    'open_eof_check'=>true,
    'package_eof' => "\r\n\r\n",
    "package_max_length"    =>  86000,
));

$tcp->on('receive' , function(swoole_server $tcp , $fd , $from_id , $data){
    $clientInfo = $tcp->connection_info($fd);
    var_dump($clientInfo);
    var_dump($data);
    $tcp->send($fd , 'Response : ');
});

$tcp->start();

