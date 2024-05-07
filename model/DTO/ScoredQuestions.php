<?php

namespace model\DTO;

class ScoredQuestions {

    private int $score;
    private Questions $questions;
    
    public function __construct(int $score, Questions $questions)
    {
        $this->score = $score;
        $this->questions = $questions;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getQuestions(): Questions
    {
        return $this->questions;
    }

}