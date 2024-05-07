<?php

namespace model\service;

abstract class Base {

    public function validateLogin(string $login): array
    {
        if (empty($login)){
            return ["login" => "Поле логин не может быть пустым"];
        }
        return [];
    }

    public function validatePassword(string $password): array
    {
        if (empty($password)){
            return ["password" => "Поле пароль не может быть пустым"];
        }
        return [];
    }
}