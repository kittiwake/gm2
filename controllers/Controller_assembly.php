<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 26.11.2015
 * Time: 12:29
 */

class Controller_assembly{

    function actionPlan() {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allow = Allowed::getAllowed('assembly','Plan');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        if(isset($_POST['submitok'])){
            if(isset($_POST['dubl'])) {
                $dubl = $_POST['dubl'];
                $oid = $_POST['oid'];
                $exdate = $_POST['exdate'];//'yyyy-mm-dd'
                if (isset($_POST['newdate'])) {
                    $newdate = Datas::dateToDb($_POST['newdate']);//'yyyy-mm-dd'
                    if ($dubl == 1) {
                        //узнать сборщиков
                        $uids = Mounting::getMountingLast($oid);
                        //add
                        foreach ($uids as $uid) {
                            if ($uid['m_date'] != $newdate) {
                                Mounting::addMounting($oid, $uid['uid'], $newdate);
                            }
                        }
                    } elseif ($dubl == 0) {
                        //update
                        Mounting::updateMountingDate($oid, $newdate, $exdate);
                    }
                }
            }
        }

//список сборщиков
        $userList = User_post::getUsersByPost(17);
        $sborList = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
            if($datasb['validation'] == 1){
                $abr = Datas::nameAbr($datasb['name']);
                $sborList[$datasb['id']] = $abr;
            }
        }
        asort($sborList);

        //поставить в план
        $in_plan = array();
        //тетрадь сборок
        $ass_list = array();
        $ass = OrderStan::getOrdersByPole('sborka_end','0');
        foreach ($ass as $key=>$value) {
            $moun = Mounting::getMountByPole('oid', $key);
            $orders = Order::getOrderById($key);
            $notes = Notes::getNotesByOid($key);
            $m_notes = '';
            foreach($notes as $note){
                if($note['use'] == 'mounting'){
                    $date_html = date('d.m', strtotime($note['date']));
                    $m_notes .= '<br><b>'.$date_html.'</b> '.$note['note'];
                }
            }
            $finaldate = strtotime('today + 7 days');
            if(!$moun && $orders && strtotime($ass[$key]['plan'])<$finaldate){
                $color = 'lightcyan';
                if($ass[$key]['upak_end']==2)$color = 'green';
                if($ass[$key]['otgruz_end']==2)$color = 'yellow';
                $in_plan[$key] = array(
                    'con'=>$orders['contract'],
                    'color'=>$color
                );
            }

            foreach ($moun as $mont) {
                if($mont['uid']!='0'){
                    $sbname = $sborList[$mont['uid']];
                    $uid = $mont['uid'];
                }else{
                    $sbname='';
                    $uid = 0;
                }
                if($mont['m_date']=='0000-00-00'){
                    $color = 'lightcyan';
                    if($ass[$key]['upak_end']==2)$color = 'green';
                    if($ass[$key]['otgruz_end']==2)$color = 'yellow';
                    $in_plan[$key] = array(
                        'con'=>$orders['contract'],
                        'color'=>$color
                    );
                }else{
                    if(!isset($ass_list[$mont['m_date']][$key])){
                        $ass_list[$mont['m_date']][$key] = array(
                            'oid' => $key,
                            'con' => $orders['contract'],
                            'sum' => $orders['sum'],
                            'adress' => $orders['adress'],
                            'target' => $mont['target'],
                            'sbname' =>array($uid=>$sbname),
                            'm_note' => $m_notes
                        );
                    }else{
                        $ass_list[$mont['m_date']][$key]['sbname'][$uid] = $sbname;
                    }
                    //список сборщиков выходных
                    $coll_hol[$mont['m_date']] = Freemen::getFreemen($mont['m_date']);
                }
            }
        }
        ksort($ass_list);

        //список выходных с сегодняшнего дня
        $free = Freemen::getFreeDays();
        // debug($sborList);
        foreach($free as $i=>$one){
            $free[$i]['name'] = $sborList[$one['uid']];
            $free[$i]['cpdate'] = date('d.m', strtotime($one['date']));
        }

        $week = array('воскресенье','понедельник','вторник','среда','четверг','пятница','суббота');

//        $style = '<link rel="stylesheet" href="/css/staff.css" title="normal" type="text/css" media="screen" />';
        $script2 = '<script type="text/javascript" src="/scripts/assembly.js"></script>';
        $page = SITE_PATH.'views/mounting.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionGetName(){

        //получить id сборщиков
        $list_id = User_post::getUsersByPost('17');
        //узнать их имена
        foreach($list_id as $post){
            $user = Users::getUserById($post['uid']);
            $abr = Datas::nameAbr($user['name']);
            $collectors[$post['uid']] = $abr;
        }
        echo json_encode($collectors);

        return true;
    }

    function actionSetChanges(){

//oid='+oid+'&uid='+coll+'&date=
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $greed = $_POST['greed'];// 1 - && ; 0 - || ;
        $date = $_POST['date'];
        $datedb = Datas::dateToDb($date);
        if($uid == 'no'){
            if(!empty($date)) {
                Mounting::updateMountingDate($oid, $datedb);
            }
        }elseif($greed==1){
            if(!empty($date)) {
                Mounting::addMounting($oid, $uid, $datedb);
            }
        }elseif(!empty($date) || $uid!='0'){
            Mounting::addMounting($oid, $uid, $datedb);
        }
        return true;
    }
    function actionAddMounting(){

//oid='+oid+'&uid='+coll+'&date=
        $oid = $_POST['oid'];
        if(isset($_POST['uid']) && $_POST['uid'] != 'undefined') $uid = $_POST['uid'];
        else $uid = null;
        if(isset($_POST['target']) && $_POST['target'] != 'undefined') $target = $_POST['target'];
        else $target = 'assembly';
        if (isset($_POST['datemsec'])) $datemsec = $_POST['datemsec'];
        else $datemsec = strtotime($_POST['date']);
        $datedb = date('Y-m-d', $datemsec);

        if($uid!=null) {
            $mount = Mounting::getMountByOidDate($oid, $datedb);
            $count = count($mount);
            if($count==1 && $mount[0]['uid']==0){
                //изменить
                Mounting::updateMountingUid($oid, '0', $datedb, $uid);
            }else{
                //добавить запись
                Mounting::addMounting($oid, $uid, $datedb, $target);
            }
        }else{
            Mounting::addMounting($oid, '0', $datedb, $target);
        }
        return true;
    }

    function actionCollHoliday(){

        if(!empty($_POST['date'])){
            $datedb = Datas::dateToDb($_POST['date']);
            $uid = $_POST['uid'];
            //проверка наличия записи
            $list = Freemen::getFreeday($uid);
            if(!in_array($datedb,$list)){
                Freemen::addFree($uid,$datedb);
                $user = Users::getUserById($uid);
                $name = Datas::nameAbr($user['name']);
                echo $name.'f'.$datedb.'f'.$uid;
            }
        }

        return true;
    }

    function actionCancelHoliday(){

        $uid = $_POST['uid'];
        $datedb = $_POST['date'];
        Freemen::dellFree($uid, $datedb);

        return true;
    }

    function actionDelCollector(){

        $uid = $_POST['uid'];
        $datemsec = $_POST['date'];
        $oid = $_POST['oid'];

        $datedb = date('Y-m-d', $datemsec);
        //проверить колво записей на эту дату этот заказ, если >1, удалить запись, иначе исправить сборщика

        $mount = Mounting::getMountByOidDate($oid, $datedb);
        $count = count($mount);

        if($count>1){
            //delete
            Mounting::delMounting($oid, $uid, $datedb);
        }else{
            //update
            Mounting::updateMountingUid($oid, $uid, $datedb);
        }
        echo($count);

        return true;
    }

    function actionGetFreemen(){
        $date = $_POST['date'];
        $dbdate = date('Y-m-d', $date);
        $freemen = Freemen::getFreemen($dbdate);
        echo json_encode($freemen);

        return true;
    }

    function actionChangeTarget(){
        $target = $_POST['target'];
        $oid = $_POST['oid'];
        $colldate = $_POST['colldate'];
        $date_db = date('Y-m-d', strtotime($colldate));
        $ch_res = Mounting::updateMountingTarget($oid,$date_db,$target);
        $res = '';
        switch($target){
            case 'measure':
                $res = 'Замер';
                break;
            case 'previously':
                $res = 'Контрольная сборка';
                break;
            case 'assembly':
                $db = Order::getOrderById($oid);
                $sum = $db['sum'];
                $res = $sum.'р.';
                break;
        };
        echo $res;
        return true;
    }
    function actionAddNote(){
        $oid = $_POST['oid'];
        $text = $_POST['note'];
        $res = Notes::setNote($oid,$text,'mounting');

        echo !$res;
        return true;
    }
}

?>