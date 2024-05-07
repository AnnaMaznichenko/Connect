<?php

namespace model\service;

use model\DTO;
use repository;

class Authorization extends Base{

    private repository\User $repository;

    public function __construct(repository\User $repository)
    {
        $this->repository = $repository;
    }

    public function do(DTO\UserForm $userForm): AuthorizationResult
    {
        $authorizationResult = new AuthorizationResult();
        $authorizationResult->errors = $this->validate($userForm->login, $userForm->password);

        if (empty($authorizationResult->errors)){
            $authorizationResult->userId = $this->getUserId($userForm->login);
        }

        return $authorizationResult;
    }

    public function validateExistingUser(string $login, string $password): array
    {
        if (!$this->repository->isUserWithPasswordExists($login, $password)){
            return ["login" => "Данный пользователь или пароль не существуют"];
        }

        return [];
    }

    public function validate(string $login, string $password): array
    {
        return array_merge(
            $this->validateLogin($login),
            $this->validatePassword($password),
            $this->validateExistingUser($login, $password)
        );
    }

    public function getUserId(string $login): int
    {
        return $this->repository->getUserId($login);
    }
}