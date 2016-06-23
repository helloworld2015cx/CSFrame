<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/23/
 * Time: 23:30
 */

$client = new swoole_client(SWOOLE_SOCK_TCP , SWOOLE_SOCK_ASYNC);

$client->on('connect' , function($client){
    echo "Connected !\n";

});

$client->on('error' , function($client){
    echo "Connect Failed !\n";
});


$client->on('receive' , function(swoole_client $client , $data){
    echo "Received : ".$data."\n";
    $client->send( 'Hello , data received !'."\n");
});


$client->on('close' , function($client){
    echo "Connection closed !\n";
});

$client->connect('127.0.0.1' , 9501);