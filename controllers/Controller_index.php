<?php
class Controller_index
{

    function actionIndex()
    {
      //  var_dump($_COOKIE);
      //  setcookie("uid", "", time()-60*60*24);
      //  die;
        if (isset ($_COOKIE['uid']) && isset($_COOKIE['hash'])){
            $user = Users::getUsersByParam('id',$_COOKIE['uid']);
            if($user[0]['user_hash'] == $_COOKIE['hash']){
                $ri = $user[0]['user_right'];
                $log = $user[0]['user_login'];
                setcookie("ri", $ri, time()+60*60*24);
                setcookie("login", $log, time()+60*60*24);

                //генерируем меню в виде layout

                //определяем начальную страницу
                switch($ri){
                    case 0: $cont = '/'.SITE_DIR.'/schedule';
                    case 1: $cont = '/'.SITE_DIR.'/schedule';
                    case 3: $cont = '/'.SITE_DIR.'/schedule';
                    case 4: $cont = '/'.SITE_DIR.'/schedule';
                    case 5: $cont = '/'.SITE_DIR.'/schedule';
                    case 6: $cont = '/'.SITE_DIR.'/schedule';
                    case 7: $cont = '/'.SITE_DIR.'/schedule';
                    case 8: $cont = '/'.SITE_DIR.'/schedule';
                    case 9: $cont = '/'.SITE_DIR.'/schedule';
                    case 17: $cont = '/'.SITE_DIR.'/collector';
                }

            }
            header('Location: '.$cont);

        }else{
            header('Location: /'.SITE_DIR.'/auth/showAuth');

    }

        return true;
    }
}