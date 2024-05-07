<?php

namespace repository;
use model\DTO;

class Questions {

    private Connection $connection;

    public function __construct(Connection $connectionDBH)
    {
        $this->connection = $connectionDBH;
    }

    public function insertQuestions(DTO\Questions $questions, int $userId): bool
    {
        
        $result = $this->connection->getDBH()->prepare("INSERT INTO `fandom`.`questions`
            (userId, messenger, messengerType, location, question1, question2, pctMatch, showQuestions, ignoreLocation)
            VALUES (?,?,?,?,?,?,?,?,?)");

        if ($result->execute([$userId, $questions->messenger, $questions->messengerType, $questions->location,
            $questions->question1, $questions->question2, $questions->pctMatch, $questions->showQuestions,
            $questions->ignoreLocation])){

            return true;
        }

        return false;
    }

    public function updateQuestions(DTO\Questions $questions, int $userId): bool
    {
        $result = $this->connection->getDBH()->prepare("UPDATE `fandom`.`questions` SET `messenger` = ?,
            `messengerType` = ?, `location` = ?, `question1` = ?, `question2` = ?, `pctMatch` = ?,
            `showQuestions` = ?, `ignoreLocation` = ? WHERE `userId` = ?");

        return $result->execute([$questions->messenger, $questions->messengerType, $questions->location,
            $questions->question1, $questions->question2, $questions->pctMatch, $questions->showQuestions,
            $questions->ignoreLocation, $userId]);
    }

    public function isQuestionsWithUserIdExists(int $userId): bool
    {
        $prepare = sprintf("SELECT id FROM `fandom`.`questions` WHERE `userId` = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$userId]);

        return $result->fetch() !== false;
    }

    public function getQuestions(int $userId): ?DTO\Questions
    {
        $prepare = sprintf("SELECT messenger, messengerType, location, question1, question2, pctMatch, 
        showQuestions, ignoreLocation FROM `fandom`.`questions` WHERE `userId` = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$userId]);
        $questionsFromDBH = $result->fetch();

        if (empty($questionsFromDBH)){
            return null;
        }
        
        $questions = new DTO\Questions();
        $questions->messenger = $questionsFromDBH["messenger"];
        $questions->messengerType = $questionsFromDBH["messengerType"];
        $questions->location = $questionsFromDBH["location"];
        $questions->question1 = $questionsFromDBH["question1"];
        $questions->question2 = $questionsFromDBH["question2"];
        $questions->pctMatch = $questionsFromDBH["pctMatch"];
        $questions->showQuestions = $questionsFromDBH["showQuestions"];
        $questions->ignoreLocation = $questionsFromDBH["ignoreLocation"];

        return $questions;
    }

    public function delete(int $userId): bool
    {
        $prepare = sprintf("DELETE FROM `fandom`.`questions` WHERE `userId` = ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$userId]);

        return $result->fetch() !== false;
    }

    public function getAllQuestionsNotForUser(int $userId): array
    {
        $prepare = sprintf("SELECT * FROM `fandom`.`questions` WHERE `userId` != ?");
        $result = $this->connection->getDBH()->prepare($prepare);
        $result->execute([$userId]);
        $allFetchedQuestions = $result->fetchAll();

        if (empty($allFetchedQuestions)){
            return [];
        }

        $allQuestions = [];
        foreach($allFetchedQuestions as $fetchedQuestions){
            $questions = new DTO\Questions();
            $questions->messenger = $fetchedQuestions["messenger"];
            $questions->messengerType = $fetchedQuestions["messengerType"];
            $questions->location = $fetchedQuestions["location"];
            $questions->question1 = $fetchedQuestions["question1"];
            $questions->question2 = $fetchedQuestions["question2"];
            $questions->pctMatch = $fetchedQuestions["pctMatch"];
            $questions->showQuestions = $fetchedQuestions["showQuestions"];
            $questions->ignoreLocation = $fetchedQuestions["ignoreLocation"];
            $allQuestions[] = $questions;
        }

        return $allQuestions;
    }
}