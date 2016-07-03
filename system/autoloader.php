<?php
include_once(ROOT.'system/corePackage/Autoload/Autoload.php');

Autoload::run();

use sys\corePackage\Http\Http;

Http::init()->getAccessControllerObject();

