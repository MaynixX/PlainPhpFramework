<?php

function dump(){
    foreach (func_get_args() as $item) {
        echo "<pre>";
        print_r($item);
        echo "<pre>";
    }
    die;
}
function abort(string|int $error = ""){
    die($error);
}
function view(string $path, array $variables = []){
    if(!file_exists("../views/".$path.".php")) abort("Вьюшки <b>views/".$path.".php</b> не существует");
    ob_start();
    foreach ($variables as $key=>$value) {
        ${$key} = $value;
    }
    require "../views/".$path.".php";
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}