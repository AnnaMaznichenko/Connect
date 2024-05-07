<?php

namespace model\DTO;

class SearchResult {

    private ?Questions $userQuestions;
    private array $matches = [];

    public function __construct(?Questions $userQuestions, array $matches)
    {
        $this->userQuestions = $userQuestions;
        $this->matches = $matches;
    }

    public function getUserQuestions(): ?Questions
    {
        return $this->userQuestions;
    }

    public function getMatches(): array
    {
        return $this->matches;
    }
}