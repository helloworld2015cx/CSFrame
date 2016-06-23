<?php

/*
 *  CSFrame enter here !
 * */

define( 'ROOT' , __DIR__.'/../');

define('APP_PATH',ROOT.'application/');

define('APP_NAME' , 'app');

require_once(ROOT.'system/autoloader.php');

require_once(ROOT.'test/test.php');

dump('Hello '.__FILE__);