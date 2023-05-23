<?php
    require_once 'helpers.php';

    $db_connection = mysqli_connect('127.0.0.1', 'root', '', 'tasks_and_projects');

    if ($db_connection === false)
    {
        die('Fail to connect!');
    }

    const USER_ID = 1;

    if (!isset($_GET['project_id']))
    {
        $tasksQuery = 'SELECT t.id, t.title, t.description, p.id as project_id, p.title as project_title, t.deadline, t.file, t.status, t.created_at
                       FROM tasks AS t 
                       LEFT JOIN projects AS p 
                           ON t.project_id = p.id
                       WHERE p.user_id = '.USER_ID.'
                       GROUP BY t.id';

    } else {
        $countTasksQuery = 'SELECT count(*) FROM tasks WHERE user_id = '.USER_ID;
        $countTotalTasks = getQuery($db_connection, $countTasksQuery);

        $tasksQuery = 'SELECT t.id, t.title, t.description, p.id as project_id, p.title as project_title, t.deadline, t.file, t.status, t.created_at
                       FROM tasks AS t
                       LEFT JOIN projects AS p
                           ON t.project_id = p.id
                       WHERE p.user_id = '.USER_ID.'
                       AND t.project_id = '.$_GET['project_id'].'
                       GROUP BY t.id';
    }

    $projectsQuery = 'SELECT p.*, count(t.id) AS countTasks
                      FROM projects AS p
                      LEFT JOIN tasks AS t 
                          ON p.id = t.project_id
                      WHERE p.user_id = '.USER_ID.'
                      GROUP BY p.id';

    $tasks = getQuery($db_connection, $tasksQuery);
    $projects = getQuery($db_connection, $projectsQuery);

    $userName = getQuery($db_connection, 'SELECT name FROM users WHERE id = '.USER_ID);
    $userPhoto = 'static/img/user2-160x160.jpg';

    if (isProjectExists($projects) === false)
    {
        http_response_code(404);
        include('templates/404.php');
        exit();
    }

    $kanbanTemplate = renderTemplate('kanban.php', [
        'tasks'         => $tasks,
        'projects'      => $projects,
        'pageTitle'     => pageTitle($projects),
        'projectId'     => $_GET['project_id'] ?? null,
    ]);

    $title = 'Завдання та проекти | Дошка';
    $body = renderTemplate('main.php', [
        'kanbanTemplate'    => $kanbanTemplate,
        'projects'          => $projects,
        'userName'          => $userName[0]['name'] ?? '',
        'userPhoto'         => $userPhoto,
        'tasks'             => $tasks,
        'countTotalTasks'   => $countTotalTasks[0]['count(*)'] ?? count($tasks) ,
    ]);

    echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]);
