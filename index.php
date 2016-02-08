<?php
// включим отображение всех ошибок
ini_set('display_errors',1);
error_reporting(E_ALL);

// подключаем конфиг
include ('config.php');

// Соединяемся с БД
$dbObject = new PDO('mysql:host=' . HOST . ';dbname=' . NAME_BD, USER, PASSWORD);
$dbObject->exec('SET CHARACTER SET utf8');

// проверка подключения

//начать сессию

// Загружаем router
$router = new Router();

// запускаем маршрутизатор
$router->run();