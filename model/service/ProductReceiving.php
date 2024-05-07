<?php

namespace model\service;

use model\DTO;
use repository;

class ProductReceiving {

    private repository\Questions $questionsRepository;

    public function __construct(repository\Questions $questionsRepository)
    {
        $this->questionsRepository = $questionsRepository;
    }
    
    public function search(int $userId): DTO\SearchResult
    {
        $userQuestions = $this->questionsRepository->getQuestions($userId);

        if ($userQuestions === null){
            throw new UserQuestionsNotFoundException();
        }

        $allQuestions = $this->questionsRepository->getAllQuestionsNotForUser($userId);

        $matches = [];
        foreach($allQuestions as $questions){
            $score = $this->compare($userQuestions, $questions);
            if ($score !== 0){
                $matches[] = new DTO\ScoredQuestions($score, $questions);
            }
        }

        usort($matches, function(DTO\ScoredQuestions $a, DTO\ScoredQuestions $b): bool{
            return $a->getScore() < $b->getScore();
        });
        
        return new DTO\SearchResult($userQuestions, $matches);
    }

    public function compare(DTO\Questions $firstQuestions, DTO\Questions $secondQuestions): int
    {
        $score = 0;

        if (($firstQuestions->ignoreLocation === 0 || $secondQuestions->ignoreLocation === 0)
            && $firstQuestions->location !== $secondQuestions->location){
                return 0;
            }
        
        if ($firstQuestions->question1 === $secondQuestions->question1){
            $score += 50;
        }

        if ($firstQuestions->question2 === $secondQuestions->question2){
            $score += 50;
        }

        if ($score >= $firstQuestions->pctMatch && $score >= $secondQuestions->pctMatch){
            return $score;
        }

        return 0;
    }

}