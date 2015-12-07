<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 10.08.2015
 * Time: 10:42
 */

class Db {

    public static function getConection(){

        $dsn = 'mysql:host='.HOST.'; dbname='.NAME_BD;
        $db = new PDO($dsn,USER,PASSWORD);
        $db -> exec("SET CHARACTER SET utf8");

        return $db;
    }

}