<?php

use App\Controllers\IndexController;
use Framework\Classes\Router;

Router::get("/", new IndexController(), "home");