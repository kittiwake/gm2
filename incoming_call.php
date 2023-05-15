<?php
/*
 * Information about incoming calls
 * Callback link for your site
 */
if (isset($_GET['zd_echo'])) exit($_GET['zd_echo']);

include_once ('config.php');
//    define('ZADARMA_IP', '185.45.152.42');
//    define('API_SECRET', 'e40c324633b9bc275c5e');  // You can get it from https://my.zadarma.com/api/
$remoteIp = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

$event =  filter_input(INPUT_POST, 'event');
$pbxid =  filter_input(INPUT_POST, 'pbx_call_id');
$callStart = filter_input(INPUT_POST, 'call_start'); // start time of call;
$callerId = filter_input(INPUT_POST, 'caller_id');
$calledDid = filter_input(INPUT_POST, 'called_did');
$destination = filter_input(INPUT_POST, 'destination');
//$internal = filter_input(INPUT_POST, 'internal');
//$callerId = isset($_POST['caller_id'])?$_POST['caller_id']:'';
//выкидываем +
//$callerId = preg_replace('/\+(\d{11})/','$1',$callerId);
//$calledDid = isset($_POST['called_did'])?$_POST['called_did']:'';
//$destination = isset($_POST['destination'])?$_POST['destination']:'';
$internal = isset($_POST['internal'])?$_POST['internal']:'';
$duration = isset($_POST['duration'])?$_POST['duration']:'';
$disposition = isset($_POST['disposition'])?$_POST['disposition']:'';
$status_code = isset($_POST['status_code'])?$_POST['status_code']:'';
$is_recorded = isset($_POST['is_recorded'])?$_POST['is_recorded']:'';
$call_id_with_rec = isset($_POST['call_id_with_rec'])?$_POST['call_id_with_rec']:'';

//$callerId = $event!='NOTIFY_OUT_START'?filter_input(INPUT_POST, 'caller_id'):filter_input(INPUT_POST, 'internal'); // number of calling party;

//$calledDid = filter_input(INPUT_POST, 'called_did'); // number of called party;
$dest = $destination!=null?$destination:$calledDid;
$res = Incall::add($event,$callStart,$pbxid,$callerId,$dest,$internal,$duration,$disposition,$status_code,$is_recorded,$call_id_with_rec);

if ($callStart && ($remoteIp == ZADARMA_IP)) {
    $signature = getHeader('Signature');  // Signature is send only if you have your API key and secret
    //почему НОТИФАУ_СТАРТ не пишется в базу?
    //НОТИФАЙ_ИНТЕРНАЛ работает
    //НОТИФАЙ_АНСВЕР работает, менеджер определяется и пишется в базу клиентов
    switch ($event){
        case 'NOTIFY_START':
            $signatureTest = base64_encode(hash_hmac('sha1', $callerId . $calledDid . $callStart, API_SECRET));
            if ($signature == $signatureTest) {
                if($calledDid=='74951281135'){
                    //звонок в Восточный ветер
                    echo json_encode(array(
                        'redirect' => 503,
                        'caller_name' => ''
                    ));
                    exit();
                }
                else{
                    $client = Clients::getClientByPhone($callerId);
                    if(!!$client){
                        if($client['contracts']=='yes'){
                            echo json_encode(array(
                                'redirect' => 204,//переадрес на офисмендж
                                'caller_name' => ''
                            ));
                            exit();
                        }
                        else{
                            if($client['callmen']!=''){
                                $callmen = $client['callmen'];
                                $resint = Users::getUsersByParam('user_login',$callmen);
                                $int = $resint[0]['internal'];
                                switch($int) {
                                    case '202':
                                        echo json_encode(array(
                                            'redirect' => 2,//переадрес на 202 и 203
                                            'caller_name' => ''
                                        ));
                                        exit();
                                        break;
                                    case '203':
                                        echo json_encode(array(
                                            'redirect' => 3,//переадрес на 202 и 203
                                            'caller_name' => ''
                                        ));
                                        exit();
                                        break;
                                }
                            }
                        }
                    }
                    else{
                        //проверка в базе сотрудников
                        $res = Users::getUsersByParam('tel',$callerId);
                        if(empty($res)){
                            $res = Clients::addClient($callerId);
                        }
                    }
                }
            }
            break;
        case 'NOTIFY_INTERNAL':
            $signatureTest = base64_encode(hash_hmac('sha1', $callerId . $calledDid . $callStart, API_SECRET));
            if ($signature == $signatureTest) {
                //сокеты
                $res = Users::getUserByInternal($internal);
                $user = $res['user_login'];
                $res = Users::getUsersByParam('tel',$callerId);
                if(empty($res)){
                    $data = array('roles' => array($user), 'customer_data' => $callerId);
                    $data = json_encode($data);
                    $socketObj = new Socket();
                    $socket = $socketObj->send('/notifycalling', $data);
                }
            }
                break;
        case 'NOTIFY_END':
            $signatureTest = base64_encode(hash_hmac('sha1', $callerId . $calledDid . $callStart, API_SECRET));
            if ($signature == $signatureTest) {
                switch ($disposition){
                    case 'answered':
                        //проверить запись разговора
                        break;
                    case 'busy':
                    case 'no answer':
                    case 'failed':
                    case 'line limit':
                        $user = Users::getUserByInternal($internal);
                        $res = Callmess::addNewMessage($user['user_login'],'Неотвеченный вызов','zadarma.com');
                        break;
                    case 'no money':
                        //сообщение о балансе бухгалтеру
                        $user = Users::getUserByInternal(301);
                        $res = Callmess::addNewMessage($user['user_login'],'На виртуальной АТС нет средств для приема и совершения звонков','zadarma.com');
                        break;
                    case 'cancel':
                        //сообщение о нарушении
                        $user = Users::getUserByInternal(301);
                        $txt = 'Был отменен входящий звонок от ' . $callerId . ' на номер ' . $calledDid;
                        $res = Callmess::addNewMessage($user['user_login'],$txt,'zadarma.com');
                        break;
                };
            }
                break;
        case 'NOTIFY_OUT_START':
            $signatureTest = base64_encode(hash_hmac('sha1', $internal . $destination . $callStart, API_SECRET));
            break;
        case 'NOTIFY_ANSWER':
            $signatureTest = base64_encode(hash_hmac('sha1', $callerId . $destination . $callStart, API_SECRET));
            if ($signature == $signatureTest) {
                $us = Users::getUserByInternal($internal);
                $manager = $us['user_login'];
                $client = Clients::getClientByPhone($callerId);
                $clientId = $client['id'];
                $res = Clients::updateParam($clientId,'callmen',$manager);
            }
            break;
    }
}



function getHeader($name)
{
    $headers = getallheaders();
    foreach ($headers as $key => $val) {
        if ($key == $name) return $val;
    }
    return null;
}

?>

</form>