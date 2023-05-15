<?php

class Controller_ajax {

    public function actionGetlost(){

        $list = Order::getPlanByPeriod('today','+5 days');

        echo json_encode($list);
//        echo 'fsafafa';
        return true;
    }

    public function actionTest(){
        $uid = $_GET['uid'];
        $res = Users::getUserByPost(18);
//        $data = array();

        if($res && !empty($res)){
            foreach($res as $one){
                if($one['id']==$uid){
                    $data[0] = $one;
                    $data[1] = Logistic::getOrdersToDriver($uid);
                }
            }
        }

        echo json_encode($data?$data:false);

        return true;
    }


} 