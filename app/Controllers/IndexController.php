<?php
namespace App\Controllers;

class IndexController extends Controller{
    public function home(){
        $user = ["login" => "admin", "name" => "Иванов Иван"];
        return view("home", compact('user'));
    }
}