<?php

namespace controller;

use model\service;
use model\DTO;

class Questions extends Base {

    public function questioning(service\Questioning $questioning): void
    {
        session_start();

        if (empty($_SESSION["login"])){
            $this->redirect("/ae/index");
        }

        $registered = !empty($_SESSION["registered"]);
        $authorized = !empty($_SESSION["authorized"]);

        unset($_SESSION["registered"], $_SESSION["authorized"]);

        $questionsForm = new DTO\Questions();
        $errors = [];

        $questions = $questioning->getQuestions($this->getUserFromSession()->userId);

        if (empty($_POST["send_form"]) && ($questions !== null)){
            $questionsForm->messenger = $questions->messenger;
            $questionsForm->messengerType = $questions->messengerType;
            $questionsForm->location = $questions->location;
            $questionsForm->question1 = $questions->question1;
            $questionsForm->question2 = $questions->question2;
            $questionsForm->pctMatch = $questions->pctMatch;
            $questionsForm->showQuestions = $questions->showQuestions;
            $questionsForm->ignoreLocation = $questions->ignoreLocation;
        }

        $saved = false;
        if (isset($_POST["send_form"])){
            $questionsForm->messenger = trim($_POST["messenger"]);
            $questionsForm->messengerType = isset($_POST["messengerType"]) ? $_POST["messengerType"] : "";
            $questionsForm->location = $_POST["location"];
            $questionsForm->question1 = $_POST["question1"];
            $questionsForm->question2 = $_POST["question2"];
            $questionsForm->pctMatch = !empty($pctMatch = trim($_POST["pctMatch"])) ? (int)$pctMatch : 0;
            $questionsForm->showQuestions = isset($_POST["showQuestions"]) ? $_POST["showQuestions"] : "";
            $questionsForm->ignoreLocation = (int)isset($_POST["ignoreLocation"]);

            $errors = $questioning->save($questionsForm, $this->getUserFromSession());

            $saved = empty($errors);
        }

        if (isset($_POST["delete_form"])){
            $questioning->delete($this->getUserFromSession()->userId);
            $this->redirect("/ae/questions");
        }

        echo $this->renderMain(
            $this->render("questions", [
                "registered" => $registered,
                "authorized" => $authorized,
                "login" => $_SESSION["login"],
                "errors" => $errors,
                "questions" => $questionsForm,
                "saved" => $saved
            ]),
            "Анкета",
        );
    }
}
?>