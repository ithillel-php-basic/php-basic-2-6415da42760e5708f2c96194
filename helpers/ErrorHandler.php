<?php

namespace helpers;

use JetBrains\PhpStorm\NoReturn;

class ErrorHandler
{
    /**
     * Задає потрібний http статус.
     *
     * @param string $code
     * @return void
     */
    #[NoReturn] public static function setStatus(string $code): void
    {
        switch ($code) {
            case '404':
                http_response_code($code);
                include('templates/404.php');
                exit();
            default:
                die('Невірно вказаний статус помилки.');
        }
    }
}