<?php
// включим отображение всех ошибок
ini_set('display_errors',1);
error_reporting(E_ALL);

// подключаем конфиг
include ('config.php');
include ('functions.php');
//var_dump($_COOKIE);
// Соединяемся с БД
//$dbObject = new PDO('mysql:host=' . HOST . ';dbname=' . NAME_BD, USER, PASSWORD);
//$dbObject->exec('SET CHARACTER SET utf8');


$sessObj = new Session();
$sessError = $sessObj->start();

// Загружаем router
$router = new Router($sessError);

// запускаем маршрутизатор
$router->run();
