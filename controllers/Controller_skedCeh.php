<?php

class Controller_skedCeh {

    public $arr_stan_date = array('raspil_date', 'cpu_date', 'gnutje_date', 'kromka_date', 'pris_date', 'emal_date', 'pvh_date', 'photo_date', 'pesok_date', 'vitrag_date', 'oracal_date', 'fas_date', 'upak_date','krivolin_date');
    public $arr_stan = array('raspil', 'cpu', 'gnutje', 'kromka', 'pris_end', 'emal', 'pvh', 'photo', 'pesok', 'vitrag', 'oracal', 'fas', 'upak_end','krivolin');
    public $arr_olstan = array('raspil','frez','obk','pvh','shlif1','grunt','shlif2','emal','polir','upak','klej');
    public $arr_olstan_date = array('raspil_date','frez_date','obk_date','pvh_date','shlif1_date','grunt_date','shlif2_date','emal_date','polir_date','upak_date','klej_date');

    // public $arr_olstan_date = array(
    //     'raspil_date',
    //     'frez_date',
    //     'obk_date',
    //     'pvh_date',
    //     'grunt_date',
    //     'emal_date',
    //     'polir_date',
    //     'upak_date',
    //     'klej_date',
    //     'shlif1_date',
    //     'shlif2_date'
    // );
    // public $arr_olstan = array(
    //     'raspil',
    //     'frez',
    //     'obk',
    //     'pvh',
    //     'grunt',
    //     'emal',
    //     'polir',
    //     'upak',
    //     'klej',
    //     'shlif1',
    //     'shlif2'
    // );
    // public $olshablon = array(
    //     array(
    //         0=>'пила',
    //         1=>'фрезер',
    //         2=>'обкатка',
    //         8=>'шлифовка/клей',
    //         3=>'пвх'
    //     ),
    //     array(
    //         9=>'шлифовка1',
    //         4=>'грунт',
    //         10=>'шлифовка2',
    //         5=>'эмаль',
    //         6=>'полировка',
    //         7=>'упаковка'
    //         )
    //     );





    public function actionGetPlan2(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        if($ri == 99){
            include (SITE_PATH.'views/menuceh.php');
        }else{
            $orders = array();
            $etaps = array(
                0=>'Распил',
                3=>'Кромка',
                4=>'Присадка',
                13=>'Криволинейка',
                2=>'Гнутье',
                11=>'Фасады',
                12=>'Упаковка'
            );
            $arr_stan_date = $this->arr_stan_date;
            $arr_stan = $this->arr_stan;
            foreach ($etaps as $etap=>$val){
                $orders[$etap] = OrderStan::getPlanToday($arr_stan_date[$etap],$arr_stan[$etap]);
            }
//var_dump($orders);
            $script = '<script type="text/javascript" src="/scripts/ceh_script.js"></script>';
            $page = SITE_PATH.'views/sked_ceh.php';
            include (SITE_PATH.'views/layout.php');

            return true;
        }
        return true;
    }

    public function actionGetPlan(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(0,1,3,8,10,99,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        if($ri == 99){
            include (SITE_PATH.'views/menuceh.php');
        }else{
            $orders = array();
            $etaps = array(
                0=>'Распил',
                3=>'Кромка',
                4=>'Присадка',
                13=>'Криволинейка',
//                2=>'Гнутье',
//                11=>'Фасады',
//                12=>'Упаковка'
            );
            $arr_stan_date = $this->arr_stan_date;
            $arr_stan = $this->arr_stan;
            foreach ($etaps as $etap=>$val){
//                $orders[$etap] = OrderStan::getPlanToday($arr_stan_date[$etap],$arr_stan[$etap]);
                $orders[$etap] = Sequence::getSequenceTillToday($arr_stan[$etap],$arr_stan_date[$etap]);
            }
//var_dump($orders);
            $script = '<script type="text/javascript" src="/scripts/ceh_script.js"></script>';
            $page = SITE_PATH.'views/sked_ceh.php';
            include (SITE_PATH.'views/layout.php');

            return true;
        }
        return true;
    }

    public function actionGetPlanMdf(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(0,1,3,8,11,33,41,42,43,98,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        $vis = in_array($ri, array(41,42,43))?$ri:3;
        $etaps_list = Oldi::getEtaps($vis);
        foreach ($etaps_list as $num_etap=>$list){
            $etaps[$num_etap] = $list['etap'];
            $arr_stan_date[$num_etap] = $list['etap_date'];
            $arr_stan[$num_etap] = $list['etap_stan'];
        }
        foreach ($etaps as $etap=>$val){
            $orders[$etap] = Sequence::getOldiSequenceTillToday($arr_stan[$etap],$arr_stan_date[$etap]);
        }
        if($ri == 41){
            $arr_stan[]='cpu';
            $arr_stan_date[]='cpu_date';
            $etaps[]='ЧПУ';
            $ord = Sequence::getSequenceTillToday('cpu','cpu_date');
            foreach($ord as $k=>$o){
                if($o['cpu']==2){
                    $ord[$k]['cpu'] = 1;
                }
            }
            $orders[] = $ord;
        }

        $page = SITE_PATH.'views/skedmdf.php';
        $style = '<link rel="stylesheet" href="/css/cehmdf.css" title="normal" type="text/css">';
        $script = '<script type="text/javascript" src="/scripts/ceh_script.js"></script>';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    
/*    public function actionGetPlanMdf2(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(0,1,3,8,11,41,42,43,98,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
            $orders = array();
            
            $etaps = array(
                0=>'Распил',
                1=>'Фрезеровка',
                2=>'Обкатка',
                10=>'Шлифовка/клей',
                3=>'ПВХ',
                4=>'Шлифовка1',
                5=>'Грунт',
                6=>'Шлифовка2',
                7=>'Эмаль',
                8=>'Полировка'
            );
            //public $arr_olstan = array('raspil','frez','obk','pvh','grunt','emal','polir','upak','klej');
            
            $arr_stan_date = $this->arr_olstan_date;
            $arr_stan = $this->arr_olstan;
            
            foreach ($etaps as $etap=>$val){
//                $orders[$etap] = OrderStan::getPlanToday($arr_stan_date[$etap],$arr_stan[$etap]);
                $orders[$etap] = Sequence::getOldiSequenceTillToday($arr_stan[$etap],$arr_stan_date[$etap]);
            }
            //получить список на фрезер из верхн цеха
            $ord = Sequence::getSequenceTillToday('cpu','cpu_date');
            foreach($ord as $k=>$o){
                if($o['cpu']==2){
                    $ord[$k]['cpu'] = 1;
                }
            }
            $orders[] = $ord;
            // debug($ord);
//var_dump($orders);

        if($ri == 500){
            echo '<pre>';
            print_r ($arr_stan);
            print_r ($arr_stan_date);
            echo '</pre>';
            
        }
        else{
            if($ri == 41){
            $etaps = array(
                    0=>'Распил',
                    1=>'Фрезеровка',
                    2=>'Обкатка',
                    11=>'ЧПУ'
                );
                $arr_stan[]='cpu';
                $arr_stan_date[]='cpu_date';
                // debug($arr_stan);
                $page = SITE_PATH.'views/skedmdf.php';
                $style = '<link rel="stylesheet" href="/css/cehmdf.css" title="normal" type="text/css">';
            }else if($ri == 42){
                $etaps = array(
                    10=>'Шлифовка/клей',
                    3=>'ПВХ',
                );
                $page = SITE_PATH.'views/skedmdf.php';
                $style = '<link rel="stylesheet" href="/css/cehmdf.css" title="normal" type="text/css">';
            }else if($ri == 43){
                $etaps = Oldi::getEtaps(3,'visual_malar');
                debug($orders);
                $page = SITE_PATH.'views/skedmdf.php';
                $style = '<link rel="stylesheet" href="/css/cehmdf.css" title="normal" type="text/css">';
            }else
            {
                $script = '<script type="text/javascript" src="/scripts/ceh_script.js"></script>';
                $page = SITE_PATH.'views/sked_ceh.php';
            }
        
            $script = '<script type="text/javascript" src="/scripts/ceh_script.js"></script>';
            include (SITE_PATH.'views/layout.php');
        }
        return true;
    }
*/
    public function actionSectorSked($sector){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        // $allowed = array(1,3,4,8,58,100);
        // if(!in_array($ri,$allowed)){
        //     die("Нет доступа к этой странице!");
        // }

        $etap_date = $this->arr_stan_date[$sector];
        $etap_end = $this->arr_stan[$sector];
        $orderList = OrderStan::getNeVipolnEtap($etap_date, $etap_end);

        if($ri==12){
            $style = '<link rel="stylesheet" href="/css/android.css" title="normal" type="text/css" media="screen" />';
            $script = '<script type="text/javascript" src="/scripts/androdceh.js"></script>';
            $page = SITE_PATH.'views/ceh_sector13.php';
            include (SITE_PATH.'views/layout.php');
        }else{
            include (SITE_PATH.'views/ceh_sector.php');
        }
        return true;
    }

    public function actionClose(){
        $oid = $_POST['oid'];
        $sector = $_POST['etap'];
        $etap_date = $this->arr_stan_date[$sector];
        $etap_end = $this->arr_stan[$sector];
        $date = date('Y-m-d');
        $res1 = OrderStan::updateStanByParam($etap_end,'2',$oid);
        $res = OrderStan::updateStanByParam($etap_date,$date,$oid);
        echo $res1&&$res;

        return true;
    }

} 