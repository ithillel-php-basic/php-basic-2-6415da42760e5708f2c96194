<?php
require_once 'vendor/autoload.php';
use controllers\GuessController;
use controllers\KanbanController;

session_start();
$guessController = new GuessController();
$kanbanController = new KanbanController();

if (isset($_SESSION['user'])) {
    echo $kanbanController->index();
} else {
    echo $guessController->index();
}
