<?php

use model\service;

require_once("lib.php");

init();

$userRepository = new repository\User(createDBConnection());
$registration = new service\Registration($userRepository);
$user = new controller\User();

$user->register($registration);

