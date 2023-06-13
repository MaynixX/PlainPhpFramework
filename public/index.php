<?php
$loader = require '../vendor/autoload.php';
require_once "../Framework/functions.php";
require_once "../routes.php";

use Framework\Classes\Router;

echo Router::getRoute($_SERVER['REQUEST_URI']);