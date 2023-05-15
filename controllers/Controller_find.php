<?php

class Controller_find {
    function actionIndex()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('find','Index');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
       if(isset($_POST["submit"])){
           
            $con = $_POST["con"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $str = $_POST["str"];
            $h = $_POST["h"];
            $f = $_POST["f"];
            
            //список сборщиков
            $colls = array();
            $colls[0]='';
            $users = Users::getUserByPost(17);
            foreach($users as $user){
            $colls[$user['id']]=$user['name'];
            
        }

        $mass = array();
        $mass = Order::getInfoAboutOrder($con,$name,$phone,$str,$h,$f);
        foreach($mass as $key=>$one){
            $mount = Mounting::getMountByPole('oid',$one[0]);
            $dates = array();
            foreach($mount as $k=>$v){
                if(array_key_exists($v['m_date'],$dates)){
                    $dates[$v['m_date']] = $dates[$v['m_date']].', '.$colls[$v['uid']];
                }else{
                    $dates[$v['m_date']] = $v['m_date'].' '.$colls[$v['uid']];
  //                  var_dump($v['m_date']);
  //                  var_dump($v['uid']);
                }
            }
            $mass[$key][10] = '';
            foreach($dates as $data){
                $mass[$key][10] .= $data.'; ';
            }
            $notes = Notes::getNotesByOid($one[0]);
            $mass[$key][11] = '';
            foreach($notes as $k=>$v){
                $mass[$key][11] .= $v['date'].' '.$v['note'].'<br/>';
            }
        }

       } 
        

        $page = SITE_PATH.'views/find.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    public function actionFind(){

            $con = $_POST["con"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $str = $_POST["str"];
            $h = $_POST["h"];
            $f = $_POST["f"];

        //список сборщиков
        $colls = array();
        $colls[0]='';
        $users = Users::getUserByPost(17);
        foreach($users as $user){
            $colls[$user['id']]=$user['name'];
        }

        $mass = array();
        $mass = Order::getInfoAboutOrder($con,$name,$phone,$str,$h,$f);
        foreach($mass as $key=>$one){
            $mount = Mounting::getMountByPole('oid',$one[0]);
            $dates = array();
            foreach($mount as $k=>$v){
                if(array_key_exists($v['m_date'],$dates)){
                    $dates[$v['m_date']] = $dates[$v['m_date']].', '.$colls[$v['uid']];
                }else{
                    $dates[$v['m_date']] = $v['m_date'].' '.$colls[$v['uid']];
  //                  var_dump($v['m_date']);
  //                  var_dump($v['uid']);
                }
            }
            $mass[$key][10] = '';
            foreach($dates as $data){
                $mass[$key][10] .= $data.'; ';
            }
            $notes = Notes::getNotesByOid($one[0]);
            $mass[$key][11] = '';
            foreach($notes as $k=>$v){
                $mass[$key][11] .= $v['date'].' '.$v['note'].'<br/>';
            }
        }

        echo json_encode($mass);
        return true;
    }

    public function actionUser(){

        $pid = $_POST["pid"];
        $users = array();
        $mass = Users::getUserByPost($pid);
        foreach($mass as $one){
            $users[$one['id']]=$one['name'];
        }

        echo json_encode($users);
        return true;
    }

    public function actionDopinfo(){

        $oid = $_POST["oid"];
        $mounts = array();
        $mounts = Mounting::getMountByPole('oid',$oid);

        echo json_encode($mounts);
        return true;
    }


}