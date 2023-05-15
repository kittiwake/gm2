<?php


class Controller_oldi {
    
    function actionOrder($oid){
         $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];


        $ordersList = Oldi::getOrderById($oid);
        $plan = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2',$ordersList['plan']);
        // debug($ordersList);

        $ostatok = $ordersList['sum'] - $ordersList['prepayment'];
        $prinjat = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2.\1',$ordersList['date']);
        $term = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2.\1',$ordersList['term']);

        if ($ordersList['tip'] == 1){
            $tip = 'ПВХ';
        }else{
            $tip = 'эмаль';
        }
        $pokrytie = array('','матовый','высокий глянец','глянец металлик','металлик золото','звездное небо','хамелеон','перламутр насыщенный');
        $dopefect = array('нет','патина','градиент','трафарет 1','трафарет 2','трафарет 3');
        $yesno = array('нет','есть');

        $etapList = Oldi::getEtaps($ordersList['tip']);
        $stan = Oldi::getStan($oid);
//        var_dump($stan);die;

//        if($ordersList['tip'] == 1 && $ordersList['dop_ef'] != 0){
//            $etapList[] = array(
//                "id"=> "10",
//                "etap"=> "спецэффект",
//                "etap_stan"=> "spef"
//            );
//        }
//        var_dump($stan);die;

        $images = Oldi::getNameFile($stan, $ordersList['dop_ef'], $ordersList['radius'], $ordersList['fotopec'],$ordersList['pokr']);

        $idcust = $ordersList['idcustomer'];
        //получить информацию о заказчике
        $customer = Oldi::getCustomer($idcust);

        //print_r($images);
     //   $materials = array();
     //   $materials = Materials::getOrderByOid($id);
     //   $search = ["kg","ml","msq","l","g","one"];
     //   $replace = ["кг","м.пог.","м.кв.","л","г","шт."];
     

        $style = '<link rel="stylesheet" href="/css/oldistyle.css" title="normal" type="text/css" media="screen">';
        $page = SITE_PATH.'views/oldiorder.php';
        include (SITE_PATH.'views/layout.php');
        
        return true;
    }

    public function actionChangeStan(){
        $pole = $_POST['etap'];
        $val = $_POST['val'];
        $oid = $_POST['oid'];

        $answer = Oldi::updateStanByParam($pole,$val,$oid);

        if ($pole == 'otgruz'){
            $d = date('Y-m-d');
            Oldi::updateOrderByParam('plan',$d,$oid);
        }

        return true;
    }

    public function actionChangeDate($pole = 'plan'){
        $oid = $_POST['oid'];
        $datadate = $_POST['date'];

        $d = Datas::checkSunday($datadate);

       $ans = Oldi::updateOrderByParam($pole,$d,$oid);

        return true;
    }
    
    public function actionChangeAbout(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $val = $_POST['val'];

        Oldi::updateOrderByParam($pole,$val,$oid);

        return true;

    }

    public function actionAddNote(){
        $note = $_POST['note'];
        $oid = $_POST['oid'];
//        $note = '<p><b>15.09.2016</b> Крутая фрезеровка</p>';
//        $oid = 2647;

        $answer = Oldi::updateOrderByParam('note',$note,$oid);

        return true;
    }

    public function actionChangeContract(){
        $oid = $_POST['oid'];
        $con = $_POST['con'];
        
        $find = Oldi::getOrdersByParam('contract',$con);
        if(!empty($find)){
            echo 'error';
        }
        else {
            $res = Oldi::updateOrderByParam('contract',$con,$oid);
            echo $res;
        }

        return true;

    }
    
    function actionMalar($oid){
         $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];

//        debug($oid);

        $ordersList = Oldi::getOrderById($oid);
        $plan = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2',$ordersList['plan']);

        $ostatok = $ordersList['sum'] - $ordersList['prepayment'];
        $prinjat = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2.\1',$ordersList['date']);
        $term = preg_replace('/(\d{4})-(\d{2})-(\d{2})/','\3.\2.\1',$ordersList['term']);

        if ($ordersList['tip'] == 1){
            $tip = 'ПВХ';
        }else{
            $tip = 'эмаль';
        }
        $pokrytie = array('','матовый','высокий глянец','глянец металлик','металлик золото','звездное небо','хамелеон','перламутр насыщенный');
        $dopefect = array('нет','патина','градиент','трафарет 1','трафарет 2','трафарет 3');
        $yesno = array('нет','есть');

        $etapList = Oldi::getEtaps(3);

        $stan = Oldi::getStan($oid);

        $images = Oldi::getNameFile($stan, $ordersList['dop_ef'], $ordersList['radius'], $ordersList['fotopec'],$ordersList['pokr']);

        $idcust = $ordersList['idcustomer'];
        //получить информацию о заказчике
        $customer = Oldi::getCustomer($idcust);

//по материалам, заказ материалов

         $materList = Material::getOrderMaterial($oid);
         if(!$materList) $materList = array();

         $categoryList = Material::getAllCategories('o');
         if(!$categoryList) $categoryList = array();

        $style = '<link rel="stylesheet" href="/css/oldistyle.css" title="normal" type="text/css" media="screen">';
        $page = SITE_PATH.'views/oldiordermalar.php';
        include (SITE_PATH.'views/layout.php');
        
        return true;
    }
    
    function actionTransfer(){
        $oid = $_POST['oid'];
        $date = $_POST['date'];

        $res = Oldi::updateOrderByParam('plan', $date, $oid);
echo $res;
        return true;
    }
}