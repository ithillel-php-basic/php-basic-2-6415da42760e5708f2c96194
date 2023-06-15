<?php

namespace middlewares;

trait AuthenticationMiddleware
{
    public function handle(): void
    {
//        session_start();
        if ($this->isAuthed() === false) {
            header("Location: /auth.php");
        }
    }

    public function isAuthed(): bool
    {
        return isset($_SESSION['user']);
    }
}
