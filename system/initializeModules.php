<?php

//system:
//load .env file:
require_once 'init/initEnv.php';
require_once 'core/handlers/logHandler.php';
require_once 'core/handlers/responseHandler.php';
require_once 'core/utilities.php';
require_once 'core/exception.php';
require_once 'init/initDatabaseConnection.php';

//routes:
require_once 'router.php';
require_once './app/routes/api.php';
require_once './app/routes/web.php';    

echo $test;

//Controllers:
$controllerFiles = glob('app/controllers/*.php');
foreach ($controllerFiles as $file) {
    require_once $file;
}

//Models:
$modelFiles = glob('models/*.php');
foreach ($modelFiles as $file) {
    require_once $file;
}




//config:


require_once 'loadedModules.php';
