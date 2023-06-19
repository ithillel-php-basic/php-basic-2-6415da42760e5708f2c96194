<?php

require_once 'vendor/autoload.php';
use controllers\KanbanController;

session_start();
$kanbanController = new KanbanController();
$kanbanController->updateStatus();
