<?php

namespace services;

use databases\Sql;

class UserService
{
    protected Sql $user;

    public function __construct()
    {
        $this->user = new Sql();
    }

    /**
     * Викликає авторизованого користувача.
     *
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        return $this->user->query($sql, [':email' => $email])->first();
    }

    public function logged()
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        return $this->user->query($sql, [':id' => $_SESSION['user']['id']])->first();
    }
}
