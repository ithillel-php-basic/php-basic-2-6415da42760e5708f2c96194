<?php
require_once 'vendor/autoload.php';

use controllers\DocumentController;

$document = new DocumentController();
$document->show();
