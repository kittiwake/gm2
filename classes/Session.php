<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 23.01.2017
 * Time: 10:41
 */

class Session {

    public $error=null;

    function start()
    {
        if (isset($_POST['auth'])) {
            //проверяем логин-пароль
            if (isset($_POST['login']) && isset($_POST['pass'])) {

                $log = $_POST['login'];
                $pass = $_POST['pass'];
                $res = Users::getUsersByParam('user_login',$log);
                if(empty($res) || $res[0]['user_password']!= md5(md5($pass))){
                    $this->error = 'Invalid login or password';
                }elseif($res[0]['validation']!= 1){
                    $this->error = 'You are denied access';

                }else{
                    $ri = $res[0]['user_right'];
                    $ea = $res[0]['external_access'];
                    // if(!in_array($ri,array(1,2,3,4,5,6,7,8,17,21,41,44,55)) && $_SERVER["REMOTE_ADDR"] != "195.191.158.226"){
                    if($ea!=1 && $_SERVER["REMOTE_ADDR"] != "195.191.158.226"){
                        $this->error = 'You are denied access';
                    }
                    else{
                        session_start();
                        $this->error = 'session started';
                        $_SESSION['ri'] = $res[0]['user_right'];
                        $_SESSION['login'] = $res[0]['user_login'];
                        $_SESSION['uid'] = $res[0]['id'];
                        $_SESSION['pas'] = $res[0]['user_password'];
                        $_SESSION['internal'] = $res[0]['internal'];

                        $array = array('100','202','203','204');
                        if(array_search($_SESSION['internal'],$array)!==false){
                            $salt = md5($log);
                            $token = md5($salt.time().$log);
                            setcookie('token', $token);
                            setcookie('login', $log);
                            $data = array('role' => $log, 'token' => $token, 'ttl' => 172800);
                            $data = json_encode($data);
  //                          $socketObj = new Socket();
  //                          $socket = $socketObj->send('/feedauth',$data);
                        }
                        //логирование по неделям
                        $w = date("z");
                        $file = SITE_PATH . 'logs/log'.$w.'.txt';
                        $text = date('Y-m-d H:i:s') .' !! '; //Добавим актуальную дату
                        $text .= $_SERVER['REMOTE_ADDR'] . ' !! ';
                        $text .= $log .' !! '; 
                        $text .= $_SERVER['REQUEST_URI'] . ' !! ';
                        $text .= $_SERVER['HTTP_USER_AGENT'];
                        $fOpen = fopen($file,'a');
                        file_put_contents($file, $text . PHP_EOL, FILE_APPEND);
                    }
                }
                
                $errlog = $log . ' ! ' . $this->error;
            }
        }
        elseif(isset($_GET['out']) && $_GET['out']==1){
            session_start();
            session_unset();
            session_destroy();
            setcookie('PHPSESSID', '', -1);
            header('Location: /');
        }
        elseif(isset($_GET['ajax']) && $_GET['ajax']==1){
            session_start();
            $this->error = 'session started';
        }
        elseif(!empty($_COOKIE['PHPSESSID']) && session_start())
        {

            if(sizeof($_SESSION)>0){
                $log = $_SESSION['login'];
                $res = Users::getUsersByParam('user_login',$log);
                $ri = $res[0]['user_right'];
                $ea = $res[0]['external_access'];
                if($ri != $_SESSION['ri'] || $res[0]['validation']!= 1){
                    $this->error = 'You need to log in';
                    $errlog = $log . ' ! Accaunt is closed';
                }
                elseif($_SESSION['pas'] != $res[0]['user_password']){
                    $this->error = 'You need to log in';
                    $errlog = $log . ' ! The PASS is new';
                }
                else{
                    // if(!in_array($ri,array(1,2,3,4,5,6,7,8,17,21,41,44,55)) && $_SERVER["REMOTE_ADDR"] != "195.191.158.226"){
                    if($ea!=1 && $_SERVER["REMOTE_ADDR"] != "195.191.158.226"){
                        $this->error = 'You are denied access';
                        $errlog = $log . ' ! External input';
                    }else{
                        $this->error = 'session ok';
                        //логирование по неделям
                        $w = date("z");
                        $file = SITE_PATH . 'logs/log'.$w.'.txt';
                        $text = date('Y-m-d H:i:s') .' !! '; //Добавим актуальную дату
                        $text .= $_SERVER['REMOTE_ADDR'] . ' !! ';
                        $text .= $log .' !! '; 
                        $text .= $_SERVER['REQUEST_URI'] . ' !! ';
                        $text .= $_SERVER['HTTP_USER_AGENT'];
                        $fOpen = fopen($file,'a');
                        file_put_contents($file, $text . PHP_EOL, FILE_APPEND);
                    }
                }
            }else{
                $this->error = 'You need to log in';
                $errlog = 'The session has expired';
            }
        }
        else{
            $this->error = 'You need to log in';
            $errlog = 'New entry';
        }
        if(isset($errlog)){
            $w = date("z");
            $errfile = SITE_PATH . 'logs/errlog'.$w.'.txt';
            $text = date('Y-m-d H:i:s') .' ! '; //Добавим актуальную дату
            $text .= $_SERVER['REMOTE_ADDR'] . ' ! ';
            $text .= $errlog . ' ! '; 
            $text .= $_SERVER['REQUEST_URI'] . ' ! ';
            $text .= $_SERVER['HTTP_USER_AGENT'];
            $fOpen = fopen($errfile,'a');
            file_put_contents($errfile, $text . PHP_EOL, FILE_APPEND);
        }
        return $this->error;
    }
    
} 
