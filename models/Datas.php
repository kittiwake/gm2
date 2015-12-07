<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 10.10.2015
 * Time: 8:54
 */

class Datas {

    public static function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
}