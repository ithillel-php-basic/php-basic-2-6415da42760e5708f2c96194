<?php
    require_once 'helpers.php';
    require_once 'sql.php';

    $db_connection = db_connection();

    $projectId = intProjectId();

    $tasks = getTasks();
    $projects = getProjects();
    $queryStr = getBrowserQueryString();

    $user = authUser();
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
        'projectId'     => $projectId,
    ]);

    $navbarTemplate = renderTemplate('navbar.php', [
        'projectId'     => $projectId,
        'url'           => $_SERVER['REQUEST_URI'],
        'pageName'      => $_SERVER['SCRIPT_NAME'],
        'queryStr'      => $queryStr,
    ]);

    $mainSidebarTemplate = renderTemplate('mainSidebar.php', [
        'userPhoto'     => $userPhoto,
        'user'          => $user,
        'projects'      => $projects,
        'tasks'         => $tasks,
        'projectId'     => $projectId,

    ]);

    $title = 'Завдання та проекти | Дошка';
    $body = renderTemplate('main.php', [
        'kanbanTemplate'        => $kanbanTemplate,
        'mainSidebarTemplate'   => $mainSidebarTemplate,
        'navbarTemplate'        => $navbarTemplate,
        'projectId'             => $projectId,
    ]);

    echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]);
