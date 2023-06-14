<?php
require_once 'vendor/autoload.php';

use controllers\KanbanController;

$kanbanController = new KanbanController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kanbanController->store();
}

echo $kanbanController->create();
