<?php
include_once(ROOT.'system/corePackage/Autoload/Autoload.php');
use sys\corePackage\Autoload\Autoload;
//spl_autoload_register(array(Autoload::class,"autoload"));

Autoload::load_declare_const();
//Autoload::test();
require_once(ROOT.'system/function/functions.php');

Autoload::load_core();

require_once(ROOT.'test/test.php');



