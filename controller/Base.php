<?php

namespace controller;

use model\DTO;

abstract class Base {

    protected function render($tmp, $vars = []): string
    {
        if (file_exists("view/" . $tmp . ".tpl.php")){
            ob_start();
            extract($vars);
            require "view/" . $tmp . ".tpl.php";
            return ob_get_clean();
        }
        return "";
    }

    protected function redirect(string $location): void
    {
        header("Location: " . $location . ".php");
        die();
    }

    protected function renderMain($content, $title): string
    {
        return $this->render("main", [
            "content" => $content,
            "title" => $title,
        ]);
    }

    protected function getUserFromSession(): DTO\User
    {
        session_start();
        $user = new DTO\User();

        if (isset($_SESSION["userId"])){
            $user->userId = $_SESSION["userId"];
            $user->login = $_SESSION["login"];
        }

        return $user;
    }

    protected function setUserToSession(DTO\User $user): void
    {
        $_SESSION["login"] = $user->login;
        $_SESSION["userId"] = $user->userId;
    }
}