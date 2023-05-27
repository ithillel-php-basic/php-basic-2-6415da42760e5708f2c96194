<?php
    require_once 'helpers.php';
    require_once 'sql.php';

    $db_connection = db_connection();

    $user = authUser();

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