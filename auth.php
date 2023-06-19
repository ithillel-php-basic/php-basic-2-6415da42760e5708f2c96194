<?php

require_once 'vendor/autoload.php';
use controllers\AuthController;

session_start();
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}

echo $auth->prepareLogin();
