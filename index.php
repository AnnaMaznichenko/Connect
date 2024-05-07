<?php

use model\service;

require_once("lib.php");

init();

$userRepository = new repository\User(createDBConnection());
$authorization = new service\Authorization($userRepository);
$user = new controller\User();

$user->authorization($authorization);