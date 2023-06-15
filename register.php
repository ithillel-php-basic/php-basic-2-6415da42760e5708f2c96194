<?php
require_once 'vendor/autoload.php';
use controllers\AuthController;

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->register();
}

echo $authController->prepareRegister();
