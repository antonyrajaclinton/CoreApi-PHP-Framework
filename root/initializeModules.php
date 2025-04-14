<?php

//system:
//load .env file:
require_once 'init/initEnv.php';
require_once 'base/handlers/logHandler.php';
require_once 'base/handlers/responseHandler.php';
require_once 'base/handlers/requestHandler.php';
require_once 'base/utilities.php';
require_once 'base/exception.php';
require_once 'init/initDatabase.php';
require_once 'base/db.php';

//routes:
require_once 'router.php';
require_once './app/routes/api.php';
require_once './app/routes/web.php';    


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
