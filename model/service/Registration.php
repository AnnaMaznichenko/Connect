<?php

namespace model\service;

use model\DTO;
use repository;

class Registration extends Base{

    private repository\User $repository;

    public function __construct(repository\User $repository)
    {
        $this->repository = $repository;
    }

    public function do(DTO\UserForm $userForm): RegistrationResult
    {
        $registrationResult = new RegistrationResult();
        $registrationResult->errors = $this->validate($userForm->login, $userForm->password);

        if (empty($registrationResult->errors)){
            $registrationResult->userId = $this->saveUser($userForm);
        }

        return $registrationResult;
    }

    public function validateUniqueUsername(string $login): array
    {
        if ($this->repository->isUserExists($login)){
            return ["login" => "Данный пользователь уже существует"];
        }

        return [];
    }
    
    public function validate(string $login, string $password): array
    {
        return array_merge(
            $this->validateLogin($login),
            $this->validatePassword($password),
            $this->validateUniqueUsername($login)
        );
    }

    public function saveUser(DTO\UserForm $userForm): int
    {
        return $this->repository->saveUser($userForm);
    }
    
}