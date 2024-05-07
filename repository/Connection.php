<?php

namespace repository;

class Connection {

    private \PDO $dbh;

    public function __construct($login, $pass, $opts)
    {
        $this->dbh = new \PDO("mysql:host=localhost;dbmame=fandom", $login, $pass, $opts);
    }

    public function getDBH(): \PDO
    {
        return $this->dbh;
    }

}