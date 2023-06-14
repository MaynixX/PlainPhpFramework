<?php

namespace Framework\Classes;

use PDO;
use PDOException;

class Database{
    private static $dbh;

    public static function init(){
        $name = env("db_name");
        $username = env("db_username");
        $password = env("db_password");
        $host = env("db_host");
        self::$dbh = new PDO('mysql:host='.$host.';dbname='.$name, $username, $password);
    }
    public static function fetch(string $prepare, array $args = [], $class = Row::class) : array{
        return self::tryQuery(function() use ($prepare, $args, $class){
            $data = self::execute($prepare, $args);
            return $data->fetchAll(PDO::FETCH_CLASS, $class);
        });
    }
    public static function first(string $prepare, array $args = [], $class = Row::class){
        return self::tryQuery(function() use ($prepare, $args, $class){
            $data = self::execute($prepare, $args);
            return $data->fetchObject($class);
        });
    }
    public static function insert(string $prepare, array $args = []) : int{
        return self::tryQuery(function() use ($prepare, $args){
            self::execute($prepare, $args);
            return self::$dbh->lastInsertID();
        });
    }
    public static function update(string $prepare, array $args = []) : void{
        self::tryQuery(function() use ($prepare, $args){
            $data = self::execute($prepare, $args);
        });
    }
    private static function execute(string $prepare, array $args = []){
        $data = self::$dbh->prepare($prepare);
        $data->execute($args);
        return $data;
    }
    private static function tryQuery(callable $callable){
        try {
            return $callable();
        } catch (PDOException $e) {
            dump($e);
            die;
        }
    }
    private static function transaction(callable $callable){
        self::$dbh->beginTransaction();
        try {
            $s = $callable();
            self::$dbh->commit();
            return $s;
        } catch ( \Exception $e ) {
            self::$dbh->rollBack();
        }
    }
}

Database::init();