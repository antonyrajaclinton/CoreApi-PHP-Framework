<?php

use Controllers\AuthController;

$apiUrlPrefix = "/api";

// $router->get("{$apiUrlPrefix}/",  [AuthController::class, 'index']);

$router->post("{$apiUrlPrefix}/signIn", [AuthController::class, 'signIn']);
$router->post("{$apiUrlPrefix}/signUp", [AuthController::class, 'signUp']);
