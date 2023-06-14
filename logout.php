<?php
include_once 'vendor\autoload.php';

$authController = new \controllers\AuthController();
$authController->logout();
