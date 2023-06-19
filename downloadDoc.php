<?php

require_once 'vendor/autoload.php';

use controllers\DocumentController;

session_start();
$document = new DocumentController();
$document->show();
