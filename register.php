<?php
    require_once 'helpers.php';
    require_once 'sql.php';
    require_once 'validation_rules.php';

    $db_connection = db_connection();

    $title = 'Завдання та проекти | Реєстрація нового користувача';
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $userQuery = 'SELECT * FROM users WHERE email = ?';
        $userStmt = dbGetPrepareStmt($db_connection, $userQuery, [$_POST['email']]);
        $checkUserEmail = getQueryByStmt($userStmt, TRUE);

        foreach ($_POST as $field => $value)
        {
            $is_nullable = is_nullable($field);
            $string_max = string_max($field);

            if (!$is_nullable['is_valid'])
            {
                $errors["$field"][] = $is_nullable['message'];
            }

            if (!$string_max['is_valid'])
            {
                $errors["$field"][] = $string_max['message'];
            }

        }


        $is_email = is_email('email');
        if (!empty($_POST['email']) && !$is_email['is_valid'])
        {
            $errors['email'][] = $is_email['message'];
        }


        if (!empty($checkUserEmail))
        {
            $is_email_unique = is_email_unique('email', $checkUserEmail);
            if (!$is_email_unique['is_valid'])
            {
                $errors['email'][] = $is_email_unique['message'];
            }
        }


        $passwordConf = password_confirmation('password', 'password_confirmation');
        if (!$passwordConf['is_valid'])
        {
            $errors['password_confirmation'][] = $passwordConf['message'] ?? '';
        }


        if (empty($errors))
        {
            $storeUserQuery = 'INSERT INTO users(name, email, password, created_at) VALUES (?, ?, ?, CURRENT_DATE)';
            $storeUserData = [$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)];
            insertQueryByStmt($storeUserQuery, $storeUserData);

            $mesType = 'success';
            $message = 'Нового користувача успішно зареєстровано.';

            header("Location: /?$mesType=$message");
            exit();
        }
    }


    echo renderTemplate('register.php', [
        'title'     => $title,
        'errors'    => $errors,
    ]);