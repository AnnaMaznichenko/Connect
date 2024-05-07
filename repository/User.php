<?php

namespace repository;
use model\DTO;

class User {

    private Connection $connection;

    public function __construct(Connection $connectionDBH)
    {
        $this->connection = $connectionDBH;
    }

    public function isUserExists(string $login): bool
    {
        $prepare = sprintf("SELECT id FROM `fandom`.`users` WHERE login = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$login]);

        return $result->fetch() !== false;
    }

    public function hashPassword(string $password): string
    {
        return md5($password . "%$*@$$%#**");
    }

    public function saveUser(DTO\UserForm $userForm): int
    {
        $password = $this->hashPassword($userForm->password);
        $result = $this->connection->getDBH()->prepare("INSERT INTO `fandom`.`users` (login, password) VALUES (?,?)");

        if ($result->execute([$userForm->login, $password])){
            return $this->connection->getDBH()->lastInsertId();
        }

        return 0;
    }
    
    public function isUserWithPasswordExists(string $login, string $password): bool
    {
        $prepare = sprintf("SELECT id FROM `fandom`.`users` WHERE login = ? AND password = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$login, $this->hashPassword($password)]);
        
        return $result->fetch() !== false;
    }

    public function getUserId(string $login): int
    {
        $prepare = sprintf("SELECT id FROM `fandom`.`users` WHERE login = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$login]);
    
        return (int)$result->fetchColumn();
    }
}



    


