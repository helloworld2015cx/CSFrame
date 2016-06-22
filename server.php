<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 13:34
 */

error_reporting(E_ALL);
set_time_limit(0);

$address = '0.0.0.0';
$port = '8080';

$server = socket_create( AF_INET , SOCK_STREAM , SOL_TCP );
if(!$server)
{
    echo 'socket_create() failed : '.socket_strerror(socket_last_error($server))."\n";
    die('create socket failed in line '.__LINE__);
}

$bind = socket_bind($server , $address , $port);
if(!$bind)
{
    echo 'socket_bind() failed : '.socket_strerror(socket_last_error($server))."\n";
    die('socket bind failed in line '.__LINE__);
}

$listen = socket_listen($server , 5);
if(!$listen){
    echo 'socket_listen() failed : '.socket_strerror(socket_last_error($server))."\n";
    die('socket_listen() failed in line'.__LINE__);
}

echo "Server $address is create successfully and listening at $port ...\n";
//socket_accept()

while(true)
{
    $cli = socket_accept($server);

    if(!$cli)
    {
        echo socket_strerror(socket_last_error($server))."\n";
    }

    echo "Client connect success ..\n";

    $msg = 'Server : Welcome to connect !'."\n";
    socket_write($cli , $msg , strlen($msg));

    while(true)
    {
        $cli_msg = socket_read($cli , 1024 );
        $clmsg =trim(str_replace( "\n" , '' , $cli_msg ));
        if($clmsg == 'exit' || $clmsg == 'q' || $clmsg == 'quit' || $clmsg == '')
        {
            break;
        }

        echo "Received Message : ".$cli_msg;
        if (false === socket_write($cli, $cli_msg, strlen($cli_msg)))
        {
            echo "socket_write() failed reason:" . socket_strerror(socket_last_error($server));
        } else
        {
            echo "Message send success .\n";
        }
    }

    echo("One client end the connection ! \n");

    socket_close($cli);

}


//
//$server = stream_socket_server('tcp://0.0.0.0:8080' , $errno , $errormsg) or die('create server failed !');
//
//for($i = 0 ; $i < 32 ; $i++ )
//{
//    if(pcntl_fork()==0)
//    {
//        while(1)
//        {
//            $connection = stream_socket_accept($server);
//            if($connection == false) continue;
//            $request = fread($connection , 1024);
//            $response = 'Hello World !~ welcome here !';
//            fwrite($connection , $response);
//            fclose($connection);
//        }
//        exit(0);
//    }
//}