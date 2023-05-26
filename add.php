<?php
    require_once 'helpers.php';

    $db_connection = mysqli_connect('127.0.0.1', 'root', '', 'tasks_and_projects');

    if ($db_connection === false)
    {
        die('Не вдається під\'єднатися до БД.');
    }

    mysqli_set_charset($db_connection, 'utf8');

    const USER_ID = 1;
    $errors = [];

    if (isset($_GET['project_id']))
    {
        $projectId = (int) $_GET['project_id'];
    } else {
        $projectId = null;
    }


    $projectsQuery = 'SELECT p.*, count(t.id) AS countTasks
                      FROM projects AS p
                      LEFT JOIN tasks AS t 
                          ON p.id = t.project_id
                      WHERE p.user_id = '.USER_ID.'
                      GROUP BY p.id';


    $projectsStmt = dbGetPrepareStmt($db_connection, $projectsQuery);
    $projects = getQueryByStmt($projectsStmt);

    $userStmt = dbGetPrepareStmt($db_connection, 'SELECT * FROM users WHERE id = '. USER_ID);
    $userName = getQueryByStmt($userStmt, TRUE);
    $userPhoto = 'static/img/user2-160x160.jpg';
    $filename = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (empty($_POST['title']))
        {
            $errors['title'][] = 'Це поле не має бути порожнім.';

        }

        if (isQueryByIdExists($projects, (int) $_POST['project']) === false)
        {
            $errors['project'][] = 'Оберіть будь-ласка проєкт.';
        }

        if (!empty($_POST['deadline']) && isDateValid($_POST['deadline']) && !isFutureDate($_POST['deadline']))
        {
            $errors['deadline'][] = 'Обрана дата не може бути раніше за сьогоднішню.';
        }



        if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK)
        {
            $tmpFileName = $_FILES['file']['tmp_name'];
            $originFileName = basename($_FILES['file']['name']);
            $filename = md5(uniqid(rand(), true)) . '.' . $originFileName;
            move_uploaded_file($tmpFileName, './storage/'.$filename);
        }

        if (empty($errors))
        {
            $storeTaskQuery = 'INSERT INTO tasks(title, `description`, project_id, deadline, `file`, user_id, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, CURRENT_DATE)';

            $storeTaskStmt = dbGetPrepareStmt($db_connection, $storeTaskQuery, [
                $_POST['title'],
                $_POST['description'],
                $_POST['project'],
                $_POST['deadline'],
                $filename,
                USER_ID,
                ]);

            mysqli_stmt_execute($storeTaskStmt);

            header('Location: http://hillel.pro/');
            exit();
        };
    }

    $sidebar = renderTemplate('sidebar.php', [
        'projects'      => $projects,
        'projectId'     => $projectId,
        'userName'      => $userName['name'],
        'userPhoto'     => $userPhoto,
    ]);

    $title = 'Завдання та проекти | Створити задачу';
    $body = renderTemplate('addTaskForm.php', [
        'sidebar'       => $sidebar,
        'projectId'     => $projectId,
        'projects'      => $projects,
        'errors'        => $errors,
    ]);

    echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]);