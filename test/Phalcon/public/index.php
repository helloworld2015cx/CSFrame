<?php
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlAdapter;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;


try {
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/Controller/',
        '../app/Model/',
    ))->register();


    $di = new FactoryDefault();

    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/View/');
        return $view;
    });

    $di->set('url', function () {
        $url = new UrlAdapter();
        $url->setBaseUri('/phalcon/');
        return $url;
    });

    $app = new Application($di);
    $app->handle()->getContent();

} Catch(\Phalcon\Exception $e){
    echo 'Error :',$e->getMessage();
}

//echo "Hello World !";



