<?php

use Controllers\AuthController;



$router->get('/',  [AuthController::class, 'index']);

$router->get('/about', [AuthController::class, 'home']);

$router->get('/contact', [AuthController::class, 'home']);




 

