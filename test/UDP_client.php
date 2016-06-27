<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/24/
 * Time: 0:43
 */

$client = new swoole_client(SWOOLE_SOCK_UDP);

$client->connect('127.0.0.1' , 9502 , 0.5);

$client->send('Client send Data !');

$data = $client->recv();

echo $data;