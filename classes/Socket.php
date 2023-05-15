<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 18.04.2018
 * Time: 14:18
 */

class Socket {
    function send($path, $data){
        $host = "http://151.248.126.105";
        $port = 2202;
        // $path = "/feedauth";
//        $path = "/notifycalling";


//        switch($path) {
//            case '/feedauth':
//                $data = array('role' => "managerOne", 'token' => "20000722222222222222222222222222", 'ttl' => 172800);
//                break;
//            case '/notifycalling':
//                $data = array('roles' => array("managerOne", "managerTwo"), 'customer_data' => "some data(".rand(1000,9999).") in any format...");
//                break;
//        }
//        $data = json_encode($data);

        $ch = curl_init($host.$path);
        curl_setopt($ch, CURLOPT_PORT, $port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $alldata = array(
            'request' => "$host:$port ".var_export($data, true),
            'response' => $response,
            'responseCode' => $responseCode,
            'curlErrno' => $curl_errno,
            'curlError' => $curl_error
        );
//        print_r($alldata);
    }
} 