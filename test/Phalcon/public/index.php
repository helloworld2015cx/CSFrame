<?php
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use PhalconTest\Mvc\Url as UrlAdapter;;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$loader = new Loader();

$loader->registerDirs([
    '',
]);


