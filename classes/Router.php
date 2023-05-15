<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.10.2015
 * Time: 17:29
 */

class Router {

    private $sessErr;

    public function __construct($sessErr) {
        $this->sessErr = $sessErr;
    }

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
//var_dump($segments); die;
        $controller = array_shift($segments);
        if(empty($controller)){
            $controller = 'index';
        }
        $controllerName = 'Controller_' . $controller;

        $action = array_shift($segments);
        if(empty($action)){
            $action = 'index';
        }
        $actionName = 'action' . ucfirst($action);

        //определить параметры
        $parameters = $segments;
//debug($_SESSION);
        switch($this->sessErr){
            case 'You are denied access':
                echo 'Сюда нельзя';
                break;
            case 'session started' :
            case 'session ok' :
                //подключить контроллер
                $controllerFile = SITE_PATH.'controllers'.DS.$controllerName . '.php';
    //var_dump($controllerFile); die;
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
                break;
            case 'Invalid login or password' :
            case 'You need to log in' :
            default:
//                echo 'Вы не прошли авторизацию';
            $controllerFile = SITE_PATH.'controllers'.DS.'Controller_auth.php';
            include_once($controllerFile);
            $controllerObj = new Controller_auth;
            $controllerObj->actionShowAuth();
            break;

        }





    }

}