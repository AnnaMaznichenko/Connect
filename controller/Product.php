<?php

namespace controller;

use model\service;
use model\DTO;

class Product extends Base {

    public function productReceiving(service\ProductReceiving $productReceiving): void
    {
        $userQuestionsExist = true;
        $searchResult = new DTO\SearchResult(null, []);

        try {
            $searchResult = $productReceiving->search($this->getUserFromSession()->userId);
        } catch (service\UserQuestionsNotFoundException $e) {
            $userQuestionsExist = false;
        }
        
        echo $this->renderMain(
            $this->render("product", [
                "userQuestionsExist" => $userQuestionsExist,
                "searchResult" => $searchResult
            ]),
            "Результат поиска",
        );
    }
}