<?php

namespace model\service;

use model\DTO;
use repository;

class Questioning {

    private repository\Questions $questionsRepository;

    public function __construct(repository\Questions $questionsRepository)
    {
        $this->questionsRepository = $questionsRepository;
    }

    public function save(DTO\Questions $questions, DTO\User $user): array
    {
        $errors = $this->validate($questions);

        if (!empty($errors)){
            return $errors;
        }

        $questions->messenger = $this->prepareMessengerFormat($questions->messenger);
        
        if ($this->saveQuestions($questions, $user->userId) !== false){
            return [];
        }
        
        return ["questions" => "Не удалось сохранить в базу данных"];
    }

    public function validateMessenger(string $messenger): array
    {
        if (empty($messenger)){
            return ["messenger" => "Поле не может быть пустым"];
        }

        if (strlen($messenger) > 127){
            return ["messenger" => "Слишком длинный username"];
        }

        if (($match = preg_match("/^@?[a-zA-Z0-9]+$/", $messenger)) === 0){
            return ["messenger" => "Некорректный username"];
        } 
        
        if ($match === false){
            return ["messenger" => "Ошибка валидации"];
        }
        return [];
    }

    public function validateMessengerType(string $messengerType): array
    {
        if (empty($messengerType)){
            return ["messengerType" => "Выберите предпочитаемую социальную сеть"];
        }
        return [];
    }

    public function validatePctMatch(int $pctMatch): array
    {
        if ($pctMatch < 1 || $pctMatch > 100){
            return ["pctMatch" => "Значение должно быть в пределах 1-100 %"];
        }
        return [];
    }

    public function validateShowQuestions(string $showQuestions): array
    {
        if (empty($showQuestions)){
            return ["showQuestions" => "Выберите вариант отображения вашей анкеты другим пользователям"];
        }
        return [];
    }

    public function validate(DTO\Questions $questions): array
    {
        return array_merge(
            $this->validateMessenger($questions->messenger),
            $this->validateMessengerType($questions->messengerType),
            $this->validatePctMatch($questions->pctMatch),
            $this->validateShowQuestions($questions->showQuestions)
        );
    }

    public function prepareMessengerFormat(string $messenger): string
    {
        if ($messenger[0] !== "@"){
            $messenger = "@" . $messenger;
        }
        return $messenger;
    }

    private function saveQuestions(DTO\Questions $questions, int $userId): bool
    {
        if ($this->questionsRepository->isQuestionsWithUserIdExists($userId)){
            return $this->questionsRepository->updateQuestions($questions, $userId);
        }

        return $this->questionsRepository->insertQuestions($questions, $userId);
    }

    public function getQuestions(int $userId): ?DTO\Questions
    {
        return $this->questionsRepository->getQuestions($userId);
    }

    public function delete(int $userId): bool
    {
        return $this->questionsRepository->delete($userId);
    }
}