<?php
    require_once 'helpers.php';

    $db_connection = mysqli_connect('127.0.0.1', 'root', '', 'tasks_and_projects');

    if ($db_connection === false)
    {
        die('Fail to connect!');
    }

    $tasksQuery = 'SELECT t.id, t.title, t.description, p.title as project_title, t.deadline, t.file, t.status, t.created_at
                   FROM tasks AS t 
                   LEFT JOIN projects AS p 
                       ON t.project_id = p.id
                   WHERE p.user_id = 1
                   GROUP BY t.id';

    $tasks = getQuery($db_connection, $tasksQuery);
    $projects = getQuery($db_connection, 'SELECT * FROM projects WHERE user_id = 1');
    $pageTitle = getQuery($db_connection, 'SELECT title FROM projects WHERE title = \'Вхідні\' AND user_id = 1');

    $userName = getQuery($db_connection, 'SELECT name FROM users WHERE id = 1');
    $userPhoto = 'static/img/user2-160x160.jpg';

    $kanbanTemplate = renderTemplate('kanban.php', [
        'tasks'         => $tasks,
        'projects'      => $projects,
        'pageTitle'     => $pageTitle[0]['title'] ?? '',
    ]);

    $title = 'Завдання та проекти | Дошка';
    $body = renderTemplate('main.php', [
        'kanbanTemplate'    => $kanbanTemplate,
        'projects'          => $projects,
        'userName'          => $userName[0]['name'] ?? '',
        'userPhoto'         => $userPhoto,
        'tasks'             => $tasks,
    ]);

    echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]);
