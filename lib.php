<?php

function autoloder($class): void
{
    $class = str_replace("\\", '/', $class);
    $file = __DIR__ . "/{$class}.php";

    if (file_exists($file)){
        require_once $file;
    }
}

function init(): void
{
    spl_autoload_register('autoloder');
}

function createDBConnection(): repository\Connection
{
    $login = "root";
    $pass = "mysql";

    $opts =
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

    return new repository\Connection($login, $pass, $opts);
}