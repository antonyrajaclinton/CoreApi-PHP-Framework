<?php

//system:
//load .env file:
require_once 'init/initEnv.php';

//handlers:
$handlerFiles = glob('root/base/handlers/*.php');
foreach ($handlerFiles as $file) {
    require_once $file;
}

require_once 'base/utilities.php';
require_once 'base/exception.php';
require_once 'base/baseModel.php';
require_once 'init/initDatabase.php';
// require_once 'blueprints/migration.php';
require_once 'base/db.php';

//routes:
require_once 'router.php';
//handlers:
$routeFiles = glob('app/routes/*.php');
foreach ($routeFiles as $file) {
    require_once $file;
}
  
//Controllers:
$controllerFiles = glob('app/controllers/*.php');
foreach ($controllerFiles as $file) {
    require_once $file;
}

//Models:
$modelFiles = glob('app/models/*.php');
foreach ($modelFiles as $file) {
    require_once $file;
}




//config:


require_once 'loadedModules.php';
