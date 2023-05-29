<?php
    require_once 'helpers.php';
    require_once 'sql.php';
    require_once 'validation_rules.php';

    $db_connection = db_connection();

    $errors = [];

    $projectId = intProjectId();

    $projects = getProjects();
    $user = authUser();
    $userPhoto = 'static/img/user2-160x160.jpg';
    $filename = null;

    $queryStr = getBrowserQueryString();

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $is_nullable = is_nullable('title');
        if (!$is_nullable['is_valid'])
        {
            $errors['title'][] = $is_nullable['message'];

        }

        if (isQueryByIdExists($projects, (int) $_POST['project']) === false)
        {
            $errors['project'][] = 'Оберіть будь-ласка проєкт.';
        }

        if (!empty($_POST['deadline']) && isDateValid($_POST['deadline']) && !isFutureDate($_POST['deadline']))
        {
            $errors['deadline'][] = 'Обрана дата не може бути раніше за сьогоднішню.';
        }

        if (empty($_POST['deadline']))
        {
            $_POST['deadline'] = null;
        }

        if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK)
        {
            $tmpFileName = $_FILES['file']['tmp_name'];
            $originFileName = $_FILES['file']['name'];
            $getExt = explode(".", $originFileName);
            $ext = end($getExt);

            $filename = md5(uniqid(rand(), true)) . '.' . $ext;

            if (!move_uploaded_file($tmpFileName, 'storage/'.$filename)){
                $errors['file'][] = 'Виникла помилка при завантаженні файлу.';
            }
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

            $mesType = 'success';
            $message = 'Завдання було успішно створене.';
            mysqli_stmt_execute($storeTaskStmt);

            header("Location: /?$mesType=$message");
            exit();
        }
    }

    $mainSidebar = renderTemplate('mainSidebar.php', [
        'projects'      => $projects,
        'projectId'     => $projectId,
        'user'          => $user,
        'userPhoto'     => $userPhoto,
    ]);

    $navbar = renderTemplate('navbar.php', [
        'projectId'     => $projectId,
        'url'           => $_SERVER['REQUEST_URI'],
        'pageName'      => $_SERVER['SCRIPT_NAME'],
        'queryStr'      => $queryStr,
    ]);

    $title = 'Завдання та проекти | Створити задачу';
    $body = renderTemplate('addTaskForm.php', [
        'mainSidebar'   => $mainSidebar,
        'navbar'        => $navbar,
        'projectId'     => $projectId,
        'projects'      => $projects,
        'errors'        => $errors,
        'oldValues'     => $_POST,
    ]);

    echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]);