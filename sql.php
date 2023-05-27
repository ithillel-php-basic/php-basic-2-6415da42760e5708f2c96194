<?php

    const USER_ID = 1;

    /**
     * Підключення до БД.
     * @return bool|mysqli
     */
    function db_connection(): bool|mysqli
    {
        $db_connection = mysqli_connect('127.0.0.1', 'root', '', 'tasks_and_projects');

        if ($db_connection === false)
        {
            die('Не вдається під\'єднатися до БД.');
        }

        mysqli_set_charset($db_connection, 'utf8');

        return $db_connection;
    }

    /**
     * Викликає авторизованого користувача.
     * @return array|null
     * @throws ErrorException
     */
    function authUser(): ?array
    {
        $db_connection = db_connection();

        $userStmt = dbGetPrepareStmt($db_connection, 'SELECT * FROM users WHERE id = ?', [USER_ID]);
        return getQueryByStmt($userStmt, TRUE);
    }

    /**
     * Вибрати всі проєкти закріплені за користувачем.
     * @return array|null
     * @throws ErrorException
     */
    function getProjects(): ?array
    {
        $db_connection = db_connection();

        $projectsQuery = 'SELECT p.*, count(t.id) AS countTasks
                          FROM projects AS p
                          LEFT JOIN tasks AS t 
                              ON p.id = t.project_id
                          WHERE p.user_id = '.USER_ID.'
                          GROUP BY p.id';


        $projectsStmt = dbGetPrepareStmt($db_connection, $projectsQuery);
        return getQueryByStmt($projectsStmt);
    }

    /**
     * Виводить всі задачі, які належать користувачу або до первого проєкту користувача.
     *
     * @return array|null
     * @throws ErrorException
     */
    function getTasks(): ?array
    {
        $db_connection = db_connection();
        $insertData = [USER_ID];

        $tasksQuery = 'SELECT t.id, t.title, t.description, p.id as project_id, p.title as project_title, t.deadline, t.file, t.status, t.created_at
                       FROM tasks AS t
                       LEFT JOIN projects AS p
                           ON t.project_id = p.id
                       WHERE p.user_id = ?';
        if (isset($_GET['project_id']))
        {
            $tasksQuery .= ' AND t.project_id = ?';
            $insertData[] = $_GET['project_id'];
        }
        $tasksQuery .= ' GROUP BY t.id ORDER BY id DESC';

        $tasksStmt = dbGetPrepareStmt($db_connection, $tasksQuery, $insertData);
        return getQueryByStmt($tasksStmt);
    }
