<?php

use model\service;

require_once("lib.php");

init();

$questionsRepository = new repository\Questions(createDBConnection());
$productReceiving = new service\ProductReceiving($questionsRepository);
$product = new controller\Product();
$product->productReceiving($productReceiving);

?>