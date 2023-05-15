<?php

// Задаем константы:
define ('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define ('SITE_PATH', $sitePath); // путь к корневой папке сайта
$siteDir =  basename(dirname(__FILE__));
define ('SITE_DIR', $siteDir);


define ('GM_SERVER', '<хостинг>');



на ноутбуке
define('HOST', 'localhost'); 		//сервер
define('USER', 'root'); 			//пользователь
define('PASSWORD', 'mysql'); 			//пароль
define('NAME_BD', '<название>');		//база

define('API_ID', '<ключ sms.ru>');

define('ZADARMA_IP', '<сервер>');
define('API_SECRET', '<ключ>');  // You can get it from https://my.zadarma.com/api/


function __autoload($class_name){

    $array_paths = array('models', 'classes');

    foreach ($array_paths as $path){

        $path = SITE_PATH . $path .DS. $class_name . '.php';
        if (is_file($path)){
            include_once $path;
        }
    }
}

?>