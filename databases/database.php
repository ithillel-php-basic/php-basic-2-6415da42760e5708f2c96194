<?php

namespace databases;

abstract class Database
{
    protected string $hostname;
    protected string $username;
    protected string $password;
    protected string $database;
    protected string $charset;

    /**
     * Підключення до БД.
     */
    abstract protected function connection();
}
