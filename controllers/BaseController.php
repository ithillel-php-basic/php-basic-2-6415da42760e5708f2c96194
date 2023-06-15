<?php

namespace controllers;

use JetBrains\PhpStorm\NoReturn;

abstract class BaseController
{
    #[NoReturn]
    /**
     * Записує у сесію дані користувача.
     */
    protected function loggedIn($id, $name, $email) : void
    {
        session_start();

        $_SESSION['user']['id'] = $id;
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;

        header("Location: /");
        exit();
    }

    /**
     * Перевіряє чи є користувач залогіненим.
     *
     * @return void
     */
    protected function isUserLoggedIn() : void
    {
        session_start();

        if (isset($_SESSION['user'])) {
            header("Location: /");
        }
    }

    /**
     * Передає помилки валідації та останні введені дані.
     *
     * @param $validation
     * @return array|null[]
     */
    protected function params($validation): array
    {
        if (isset($validation)) {
            return [
                'errors' => $validation->errors()->toArray(),
                'oldValues' => $validation->getValidatedData(),
            ];
        }

        return [
            'errors'    => null,
            'oldValues' => null
        ];
    }
}
