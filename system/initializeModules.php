<?php

//system:
//load .env file:
require_once 'init/intializeEnv.php';

//routes:
require_once 'router.php';
require_once './routes/api.php';
require_once './routes/web.php';    



//Controllers:
$controllerFiles = glob('controllers/*.php');
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
