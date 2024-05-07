<?php

require_once("lib.php");

init();

$user = new controller\User();
$user->logout();