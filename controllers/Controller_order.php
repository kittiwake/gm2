<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 11.01.2016
 * Time: 13:10
 */

class Controller_order {

    function actionIndex($oid){
        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        $zagol = array('Просчет','Материал','Распил','ЧПУ','Кромка','Присадка','Гнутье','Эмаль','ПВХ','Фотопечать','Пескоструй','Витраж','oracal','Фасады','Упакован','Отгружен');
        $db = array("tech_end","mater","raspil","cpu","kromka","pris_end","gnutje","emal","pvh","photo","pesok","vitrag","oracal","fas","upak_end","otgruz_end");

        $order = Order::getOrderById($oid);
        $order_stan = OrderStan::getOrdersByPole('oid', $oid);
        $stan = $order_stan[$oid];

        $us_dis = Users::getUserById($order['designer']);
        $dis = $us_dis['name'];
        $us_tech = Users::getUserById($order['technologist']);
        $tech = $us_tech['name'];

        //сборщик
        $mount = Mounting::getMountingLast($oid);
        if(!$mount){
            $coll = '';
            $date_mount = '';
            $m_phone = '';
        }else{
            $coll_id = $mount['uid'];
            $user = Users::getUserById($coll_id);
            $coll = $user['name'];
            $m_phone = $user['tel'];
            $date_mount = date("d.m.y", strtotime($mount['m_date']));
        }

        //шаблоны смс
        $sample = Sms::getSamples();
        $search = array(
            '%name%',
            '%con%',
            '%date%',
            '%m_date%',
            '%collector%',
            '%phone%'
        );
        $replace = array(
            $order['name'],
            $order['contract'],
            date("d.m.y", strtotime($stan['plan'])),
            $date_mount,
            $coll,
            $m_phone
        );
        foreach ($sample as $key=>$sampleone){
            $str = $sampleone['text_sms'];
            $newstr = str_replace($search,$replace,$str);
            $sample[$key]['text_sms'] = $newstr;
        }

        $notes = Notes::getNotesByOid($oid);
        if(isset($_POST['sendsms'])){
            $phone = $_POST['phone'];
            $message = $_POST['message'];
            $sms = Sms::send($phone, $message);
            $errorsms = array();
            switch ($sms){
                case 100:
                    $errorsms[]='Сообщение отправлено';
                    Sms::save($oid,$message);
                    break;
                case 201: $errorsms[]='Не хватает средств на лицевом счету';
                    break;
                case 202: $errorsms[]='Неправильно указан получатель';
                    break;
                case 203: $errorsms[]='Нет текста сообщения';
                    break;
                case 205: $errorsms[]='Сообщение слишком длинное (превышает 8 СМС)';
                    break;
                case 206: $errorsms[]='Будет превышен или уже превышен дневной лимит на отправку сообщений';
                    break;
                case 207: $errorsms[]='На этот номер (или один из номеров) нельзя отправлять сообщения';
                    break;
                case 220: $errorsms[]='Сервис временно недоступен, попробуйте чуть позже';
                    break;
                default: $errorsms[]='Сообщение не отправлено, обратитесь к администратору';
            }
        }
        $page = SITE_PATH.'views/order.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionAddnote(){
        $oid = $_POST['oid'];
        $note = $_POST['note'];

        Notes::setNote($oid, $note);

        return true;
    }

    function actionChangeStan(){
        $oid = $_POST['oid'];
        $p = $_POST['table'];
        $val = $_POST['val'];
        $bd = array("tech_end","mater","raspil","cpu","kromka","pris_end","gnutje","emal","pvh","photo","pesok","vitrag","oracal","fas","upak_end","otgruz_end");
        $pole = $bd[$p];

        OrderStan::updateStanByParam($pole, $val, $oid);

        return true;
    }

    function actionTransfer(){
        $oid = $_POST['oid'];
        $date = $_POST['date'];

        OrderStan::updateStanByParam('plan', $date, $oid);

        return true;
    }
}