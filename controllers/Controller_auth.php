<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 05.12.2015
 * Time: 21:54
 */

class Controller_auth {

    public $error=null;
    function actionShowAuth(){//показываем форму авторизации
        $error = $this->error;
        include (SITE_PATH.'views/auth.php');
        return true;
    }

    function actionIndex(){//обработка формы
              if (isset($_POST['login']) && isset($_POST['pass'])) {

                  $log = $_POST['login'];
                  $pass = $_POST['pass'];
                  $res = Users::getUsersByParam('user_login',$log);

                  if(empty($res) || $res[0]['user_password']!= md5(md5($pass))){
                      $this->error = 'Неверный логин-пароль';
                      $this->actionShowAuth();
                  }else{
                      $hash = Datas::generateCode(20);
                      Users::updateUsersByParam('user_hash', $hash, $res[0]['id']);
                      setcookie("hash", $hash);
                      setcookie("uid", $res[0]['id']);
                      header('Location: /');
                  }
              }
        return true;
    }

}