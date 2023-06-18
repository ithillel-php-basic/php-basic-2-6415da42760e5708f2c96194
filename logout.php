<?php

include_once 'vendor/autoload.php';

use controllers\AuthController;

session_start();

$authController = new AuthController();
$authController->logout();
