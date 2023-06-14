<?php

namespace App\Models;

use Framework\Classes\Database;

abstract class Model{
    protected static $table;

    public static function all(){
        return Database::fetch("SELECT * FROM `".static::$table."`", [], get_called_class());
    }

    public static function first(){
        return Database::first("SELECT * FROM `".static::$table."`", [], get_called_class());
    }
}