<?php

// Задаем константы:
define ('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define ('SITE_PATH', $sitePath); // путь к корневой папке сайта
//echo SITE_PATH;
//C:\OpenServer\domains\localhost\gm17\
$siteDir =  basename(dirname(__FILE__));
define ('SITE_DIR', $siteDir);

//константы для подключения к базе данных
define('HOST', 'localhost'); 		//сервер
define('USER', 'root'); 			//пользователь
define('PASSWORD', ''); 			//пароль
define('NAME_BD', 'bdgm');		//база


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