<?php
require_once 'vendor/autoload.php';

use controllers\ProjectController;

session_start();
$project = new ProjectController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project->store();
}

echo $project->create();
