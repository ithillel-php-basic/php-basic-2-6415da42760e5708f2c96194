<?php
session_start();
require_once 'vendor/autoload.php';
use controllers\AuthController;

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}

echo $auth->prepareLogin();
