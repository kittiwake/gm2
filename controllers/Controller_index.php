<?php
class Controller_index
{

    function actionIndex()
    {
      //  var_dump($_COOKIE);
      //  setcookie("uid", "", time()-60*60*24);
      //  die;
        if(!isset ($_COOKIE['uid']) || !isset($_COOKIE['hash'])){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }else{
            $user = Users::getUsersByParam('id',$_COOKIE['uid']);
            if($user[0]['user_hash'] == $_COOKIE['hash']){
                $ri = $user[0]['user_right'];
                $log = $user[0]['user_login'];
                setcookie("ri", $ri, time()+60*60*24);
                setcookie("login", $log, time()+60*60*24);

                //генерируем меню в виде layout

                //определяем начальную страницу
                switch($ri){
                    case 0: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 1: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 3: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 4: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 5: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 6: $cont = '/'.SITE_DIR.'/technologist/schedule';
                        break;
                    case 7: $cont = '/'.SITE_DIR.'/technologist/schedule';
                        break;
                    case 8: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 9: $cont = '/'.SITE_DIR.'/schedule/orders';
                        break;
                    case 17: $cont = '/'.SITE_DIR.'/collector';
                        break;
                }
            }
            header('Location: '.$cont);
        }

        return true;
    }
}