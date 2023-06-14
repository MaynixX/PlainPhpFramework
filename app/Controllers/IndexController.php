<?php
namespace App\Controllers;

use App\Models\User;

class IndexController extends Controller{
    public function home(){
        dump(User::first());
    }
}