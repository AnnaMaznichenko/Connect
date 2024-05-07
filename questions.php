<?php

use model\service;

require_once("lib.php");

init();

$questionsRepository = new repository\Questions(createDBConnection());
$questioning = new service\Questioning($questionsRepository);
$questions = new controller\Questions();
$questions->questioning($questioning);

?>
