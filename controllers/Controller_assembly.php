<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 26.11.2015
 * Time: 12:29
 */

class Controller_assembly{
    function actionPlan() {

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

//список сборщиков
        $userList = User_post::getUsersByPost(17);
        $sborList = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
            if($datasb['operative'] == 1){
                $abr = Datas::nameAbr($datasb['name']);
                $sborList[$datasb['id']] = $abr;
            }
        }


        //поставить в план
        $in_plan = array();
        //незакрытые
        $in_process = array();
        //тетрадь сборок
        $ass_list = array();
        $ass = OrderStan::getOrdersByPole('sborka_end','0');
        foreach ($ass as $key=>$value) {
            $moun = Mounting::getMountByPole('oid', $key);
            $orders = Order::getOrderById($key);
            if(!$moun && $orders){
                $in_plan[$key] = array(
                    'con'=>$orders['contract'],
                );
            }

            foreach ($moun as $mont) {
                if($mont['uid']!='0'){
                    $sbname = $sborList[$mont['uid']];
                }else{
                    $sbname='';
                }
                if($mont['m_date']=='0000-00-00'){
                    $in_plan[$key] = array(
                        'con'=>$orders['contract'],
                        'sbname'=>$sbname
                    );
                }else{
                    $ass_list[$mont['m_date']][] = array(
                        'oid' => $key,
                        'con' => $orders['contract'],
                        'adress' => $orders['adress'],
                        'sbname' =>$sbname
                    );
                    //список сборщиков выходных
                    $coll_hol[$mont['m_date']] = Freemen::getFreemen($mont['m_date']);
                }
            }
            $last_mount = Mounting::getMountingLast($key);
            if($last_mount){
                $in_process[$key] = array(
                    'con' => $orders['contract'],
                    'sbname' => $last_mount['uid']
                );
            }
        }
        ksort($ass_list);

        //список выходных с сегодняшнего дня
        $free = Freemen::getFreeDays();
        foreach($free as $i=>$one){
            $free[$i]['name'] = $sborList[$one['uid']];
            $free[$i]['cpdate'] = date('d.m', strtotime($one['date']));
        }

            $page = SITE_PATH.'views/mounting.php';
    //        $page = SITE_PATH.'views/assembly.php';
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

    function actionChangeColl(){

//oid='+oid+'&uid='+coll+'&date=
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];

        Mounting::updateMountingUid($oid, $uid, $date);

        return true;
    }

    function actionDuplicate(){

        if(isset($_POST['submitok'])){
            if(isset($_POST['dubl'])){
                $dubl = $_POST['dubl'];
                $oid = $_POST['oid'];
                $exdate = $_POST['exdate'];//'yyyy-mm-dd'
                if(isset($_POST['newdate'])){
                    $newdate = Datas::dateToDb($_POST['newdate']);//'yyyy-mm-dd'
                }
                if($dubl == 1){
                    //узнать сборщика
                    $uid = Mounting::getMountingLast($oid);
                    //add
                    Mounting::addMounting($oid,$uid['uid'],$newdate);
                }elseif($dubl == 0){
                    //update
                    Mounting::updateMountingDate($oid,$newdate,$exdate);
                }
            }
        }

        header('Location: /'.SITE_DIR.'/assembly/plan');

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
}

?>