<?php
    require_once 'helpers.php';

    $db_connection = mysqli_connect('127.0.0.1', 'root', '', 'tasks_and_projects');
    const USER_ID = 1;

    $userQuery = 'SELECT * FROM users WHERE id = '.USER_ID;
    $userStmt = dbGetPrepareStmt($db_connection, $userQuery);
    $user = getQueryByStmt($userStmt, true);

    $document = $_GET['file'] ?? null;

    $taskQuery = 'SELECT * FROM tasks WHERE file = ?';
    $taskStmt = dbGetPrepareStmt($db_connection, $taskQuery, [$document]);
    $task = getQueryByStmt($taskStmt, true);


    if (!isset($document) || !isset($task))
    {
        http_response_code(404);
        include('templates/404.php');
        exit();
    }

    if (!file_exists('storage/'.$document))
    {
        http_response_code(404);
        include('templates/404.php');
    }

    if ($user['id'] !== $task['user_id'])
    {
        http_response_code(404);
        include('templates/404.php');
        exit();
    }

header('Content-Disposition: attachment; filename="'.$document.'"');
readfile('storage/'.$document);
exit();