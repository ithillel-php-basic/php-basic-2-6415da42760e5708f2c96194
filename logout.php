<?php
include_once 'vendor\autoload.php';
session_start();

$authController = new \controllers\AuthController();
$authController->logout();
