<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.06.2018
 * Time: 14:45
 */

class Controller_todo {

    public $sroki = array(
        'lost'=>'Просроченные задачи',
        'todaydo'=>'Задачи на сегодня',
        'tomorrowdo'=>'Задачи на завтра',
        'monthdo'=>'Задачи на месяц',
        'later'=>'Задачи позднее'
    );
    function actionIndex(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $now = getdate();
        $today = mktime(0,0,0,date("m"),date("d"),date("Y"));
        $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
        $nexttomorrow = mktime(0,0,0,date("m"),date("d")+2,date("Y"));
        $nextmonth = mktime(0,0,0,date("m")+1,1,date("Y"));
//        var_dump($now[0]);var_dump($today);die;
        //получить все свои задачи
        $res = Zadacha::getNewTodo($log);
        //сортировать задачи: просроченные,на сегодня, на завтра, на месяц, позднее
        $todoall = array(
            'lost' => array(),
            'todaydo' => array(),
            'tomorrowdo' => array(),
            'monthdo' => array(),
            'later' => array()
        );
        $sroki = $this->sroki;
        foreach($res as $k=>$todo){
            $date_time = strtotime($todo['date'].', '.$todo['time']);
            $todo['contact'] = $todo['sdelka']==null?($todo['client']==null?'':$todo['client']):$todo['sdelka'];//исправить! сюда готовый HTML код для js
            $todo['lost'] = '';
            $todo['active'] = '';
            if($date_time<$today){
                $todo['active'] = 'todo-line__item_active';
                $todo['lost'] = 'todo-line__item-lost';
                $todoall['lost'][]=$todo;
            }
            elseif($date_time<$tomorrow){
                $todo['active'] = 'todo-line__item_active';
                if($date_time<$now[0]&&$todo['time']!='00:00:00'){
                    $todo['lost'] = 'todo-line__item-lost';
                }
                $todoall['todaydo'][]=$todo;
            }
            elseif($date_time<$nexttomorrow){
                $todoall['tomorrowdo'][]=$todo;
            }
            elseif($date_time<$nextmonth){
                $todoall['monthdo'][]=$todo;
            }
            else{
                $todoall['later'][]=$todo;
            }
        }
//var_dump($todoall);die;
        //список получателей сообщений
        $usersres = Users::getUsersByParam('validation',1);
        $users = array();
        foreach($usersres as $user){
            if($user['user_login']==''||$user['name']=='') continue;
            if($user['user_right']!=0){
                $users[$user['user_login']] = $user['name'];
            }
        }
        asort($users);

//        var_dump($todoall);die;
        $style = '<link rel="stylesheet" href="/css/todo.css" title="normal" type="text/css" media="screen" />';
        $script2 = '<script type="text/javascript" src="/scripts/todo.js"></script>';
        $page = SITE_PATH.'views/todoline.php';
        include (SITE_PATH.'views/layout.php');
        return true;

        return true;
    }

    function actionNewTodo(){
        $log = $_SESSION['login'];
//'datetodo='+datetodo+'&timetodo='+timetodo+'&touser='+touser+'&typetodo='+typetodo+'&texttodo='+texttodo+&client='+client+'&sdelka='+sdelka
        $datetodo = $_POST['datetodo'];
        $timetodo = $_POST['timetodo'];
        $touser = $_POST['touser'];
        $typetodo = $_POST['typetodo'];
        $texttodo = $_POST['texttodo'];
        $client = $_POST['client'];
        $sdelka = $_POST['sdelka'];

        if(!preg_match('/(\d{4})-(\d{2})-(\d{2})/',$datetodo)){
            $datetodo = date('Y-m-d',strtotime($datetodo));
        }

        $res = Zadacha::addNewZadacha($datetodo,$timetodo,$log,$touser,$typetodo,$texttodo,$client,$sdelka);

        echo $res;

        return true;
    }

    function actionFindAll(){
        $txt = $_POST['txt']; //минимум 2 символа: 89..., 79..., 23..., БР...,
//        $txt = $_GET['txt']; //минимум 2 символа: 89..., 79..., 23..., БР...,
        $res1 = array();
        $res2 = array();
        $res3 = array();

        //если начинается с цифр, ищем номер сделки
        if(preg_match('/^\d{2}.*/',$txt)){
            $res1 = Sdelki::getSdelkiLikeParam('nomer',$txt);
        }

        //если только цифры, ищем в контактах
        if(preg_match('/^\d+$/',$txt)){
            $res2 = Clients::getClientsLikePhone($txt);
        }

        //если буквы, ищем от 3 символов в именах, номерах сделок,
        if(preg_match('/^\D{3,}/',$txt)){
            $res3 = Clients::getClientsLikeName($txt);
        }
        $res = array_merge($res1,$res2,$res3);
//        var_dump($res);
        echo json_encode($res);
        return true;
    }

    function actionMade(){
        //'id='+zadachaId+'&txt='+text_result,
        $id = $_POST['id'];
        $txt = $_POST['txt'];

        $res1 = Zadacha::updatePole('comment',$txt,$id);
        $res2 = Zadacha::updatePole('stan','done',$id);

        echo $res2&&$res1;
        return true;
    }

    function actionTransfer(){
        //'datetodo='+datetodo+'&timetodo='+timetodo+'&touser='+touser+'&todoid='+zadachaId,
        $login = $_SESSION['login'];

        $datetodo = $_POST['datetodo'];
        $timetodo = $_POST['timetodo'];
        $touser = $_POST['touser'];
        $id = $_POST['todoid'];

//        $datetodo = $_GET['datetodo'];
//        $timetodo = $_GET['timetodo'];
//        $touser = $_GET['touser'];
//        $id = $_GET['zadachaId'];

        if(!preg_match('/(\d{4})-(\d{2})-(\d{2})/',$datetodo)){
            $datetodo = date('Y-m-d',strtotime($datetodo));
        }
        $res1 = Zadacha::getTodoById($id);
        $type = $res1['type_zadacha'];
        $text = $res1['zadacha'];
        $client = $res1['client'];
        $sdelka = $res1['sdelka'];
        $res2 = Zadacha::addNewZadacha($datetodo,$timetodo,$login,$touser,$type,$text,$client,$sdelka);
        $res3 = Zadacha::updatePole('stan','transfer',$id);

//
//        $res1 = Zadacha::updatePole('comment',$txt,$id);
//        $res2 = Zadacha::updatePole('stan','done',$id);
//
        echo $res2&&$res3;
        return true;
    }

    function actionDelete(){
        $id = $_POST['id'];

        $res = Zadacha::updatePole('stan','delete',$id);

        echo $res;
        return true;
    }
}