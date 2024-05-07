<?php

namespace controller;

use model\DTO;
use model\service;

class User extends Base {

    public function register(service\Registration $registration): void
    {
        session_start();

        if (!empty($_SESSION["login"])){
            $this->redirect("/ae/questions");
        }

        $userForm = new DTO\UserForm();
        $registrationResult = new service\RegistrationResult();

        if (isset($_POST["send_form"])){
            $userForm->login = trim($_POST["login"]);
            $userForm->password = trim($_POST["password"]);
            $registrationResult = $registration->do($userForm);
            
            if (empty($registrationResult->errors)){
                $user = new DTO\User();
                $user->login = $userForm->login;
                $user->userId = $registrationResult->userId;
                $this->setUserToSession($user);
                $_SESSION["registered"] = true;
                $this->redirect("/ae/questions");
            }
        }
        
        echo $this->render("register", [
            "errors" => $registrationResult->errors, 
            "user" => $userForm,
            "send_form" => $_POST["send_form"]
        ]);
    }
    
    public function authorization(service\Authorization $authorization): void
    {
        session_start();

        if (!empty($_SESSION["login"])){
            $this->redirect("/ae/questions");
        }

        $userForm = new DTO\UserForm();
        $authorizationResult = new service\AuthorizationResult();

        if (isset($_POST["send_form"])){
            $userForm->login = trim($_POST["login"]);
            $userForm->password = trim($_POST["password"]);
            $authorizationResult = $authorization->do($userForm);
            
            if (empty($authorizationResult->errors)){
                $_SESSION["login"] = $userForm->login;
                $_SESSION["authorized"] = true;
                $_SESSION["userId"] = $authorizationResult->userId;
                $this->redirect("/ae/questions");
            }
        }

        echo $this->render("index", [
            "errors" => $authorizationResult->errors, 
            "user" => $userForm,
            "send_form" => $_POST["send_form"]
        ]);
    }

    public function logout(): void
    {
        session_start();
        setcookie(session_name(), "", time() - 3600);
        session_destroy();

        $this->redirect("/ae/index");
    }
}
?>