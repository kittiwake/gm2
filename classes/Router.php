<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.10.2015
 * Time: 17:29
 */

class Router {
    private function getRoute() //получить маршрут .htaccess формирует ссылку таким образом что в параметры гет запроса попадает требуемый маршрут
    {
        if (empty($_GET['route']))
        {
            $route = 'index';
        }
        else
        {
            $route = $_GET['route'];
        }
        return $route; //string 'index'
    }

    public function run(){
        $routes = $this->getRoute();
        //определить контроллер и экшн
        $segments = explode('/', $routes);

        $controllerName = 'Controller_' . array_shift($segments);

        $action = array_shift($segments);
        if(empty($action)){
            $action = 'index';
        }
        $actionName = 'action' . ucfirst($action);

        //определить параметры
        $parameters = $segments;

        //подключить контроллер
        $controllerFile = SITE_PATH.DS.'controllers'.DS.$controllerName . '.php';
        if(file_exists($controllerFile)){
            include_once($controllerFile);
        }else{
            die ($controllerName . '.php Not Found');
        }

        //создать объект, вызвать метод
        $controllerObj = new $controllerName;

        //echo "actionName=".$actionName."<br><br><br>";
        if (!call_user_func_array(array($controllerObj, $actionName),$parameters)){
            echo 'Не получилось...';
        }




    }

}