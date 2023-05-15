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

    public static function checkPole ($pole){

        if (strlen($pole)>0 && $pole!='0'){
            return true;
        }
        return false;
    }

    public static  function dateToDb($date){

        return preg_replace('/(\d{1,2})-(\d{1,2})-(\d{4})/','\3-\2-\1',$date);
    }

    public static function checkSunday($date){//принимает дату в формате DD-MM-YYYY

        if(empty($date))return false;
        $elem = explode('-', $date);
        $D = array_shift($elem);
        $M = array_shift($elem);
        $Y = array_shift($elem);

        $w = date("w", mktime(0, 0, 0, $M, $D, $Y));
        if ($w == 0){
            return date("Y-m-d", mktime(0, 0, 0, $M, $D-1, $Y));
        }
        return date("Y-m-d", mktime(0, 0, 0, $M, $D, $Y));
    }

    public static function substr_function($stroka, $start, $length)
// $stroka - это текст который будем обрезать
// $chislo - это количество символов, котрое должно остаться при обрезании строки
    {
        $stroka = iconv('UTF-8','windows-1251',$stroka ); //Меняем кодировку на windows-1251
        $stroka = substr($stroka ,$start, $length); //Обрезаем строку
        $stroka = iconv('windows-1251','UTF-8',$stroka ); //Возвращаем кодировку в utf-8
        return $stroka;
    }

    public static function isRekl ($contract){//если рекламация, возвращаем true

        if (preg_match('/^.*[РрД][1-9]?$/', $contract) == 1){
            return true;
        }
        return false;
    }

    public static function isDillers ($contract){//если рекламация, возвращаем true

        //список диллеров
        $dillers = array('ROLF','БР','СЕР','NZ');
        foreach($dillers as $dill){
            $pattern = '/^'.$dill.'-/';
            if (preg_match($pattern, $contract) == 1){
                return true;
            }
        }
        return false;
    }

    public static function built_sorter($key) {
        return function ($a, $b) use ($key) {
            if ($a[$key]>$b[$key]) return -1;
            if ($a[$key]<$b[$key]) return 1;
            if ($a[$key]==$b[$key]) return 0;
        };

    }

    public static function sortArrayByVal($array, $param){

        /*
 * $array[0] = array('key_a' => 'z', 'key_b' => 'c');
$array[1] = array('key_a' => 'x', 'key_b' => 'b');
$array[2] = array('key_a' => 'y', 'key_b' => 'a');

function build_sorter($key) {
return function ($a, $b) use ($key) {
return strnatcmp($a[$key], $b[$key]);
};
}

usort($array, build_sorter('key_b'));

foreach ($array as $item) {
echo $item['key_a'] . ', ' . $item['key_b'] . "\n";
}
 *
 * */

        usort($array, self::built_sorter($param));

        return $array;
    }

    public static function nameAbr($fullname){//принимает 2 или 3 слова, 1-ое из которых - фамилия

        $elem = explode(' ', $fullname);
        $sname = array_shift($elem);
        $name = array_shift($elem);
        $fname = array_shift($elem);

        if(isset ($name)){
            $N = self::substr_function($name,0,1);
            $sname .= ' '.$N.'.';
        }
        if(isset ($fname)){
            $N =  self::substr_function($fname,0,1);
            $sname .= $N.'.';
        }
        return $sname;
    }

    public static function nameFathername($fullname){//принимает 2 или 3 слова, 1-ое из которых - фамилия

        $elem = explode(' ', $fullname);
        $sname = array_shift($elem);
        $name = array_shift($elem);
        $fname = array_shift($elem);

        $nfn = '';

        if(isset ($name)){
            $nfn .= $name;
        }
        if(isset ($fname)){
            $nfn .= ' ' . $fname;
        }
        if(!isset ($name) && !isset ($fname)){
            $nfn = $fullname;
        }
        return $nfn;
    }

    public static function userStartPage($ri){
        switch($ri){
            case 0: $cont = '/schedule/orders';
                break;
            case 1: $cont = '/schedule/orders';
                break;
            case 2: $cont = '/claim';
                break;
            case 3: $cont = '/schedule/orders';
                break;
            case 4: $cont = '/schedule/orders';
                break;
            case 5: $cont = '/designer';
                break;
            case 6: $cont = '/technologist/schedule';
                break;
            case 7: $cont = '/technologist/schedule';
                break;
            case 8: $cont = '/delivery/schedule';
                break;
            case 9: $cont = '/schedule/orders';
                break;
            case 10: $cont = '/skedCeh/getPlan';
                break;
            case 15: $cont = '/alexandria/schedule';
                break;
            case 16: $cont = '/schedule/mdf';
                break;
            case 17: $cont = '/collector';
                break;
            case 19: $cont = '/schedule/orders';
                break;
            case 58: $cont = '/report/NP';
                break;
            case 99: $cont = '/skedCeh/getPlan';
                break;
        }
        return $cont;

    }

    public static function getPathFromYear($plan,$contract){

        $arrdte = explode('-',$plan);
        $year = $arrdte[0];

        $path = '/'.$year.'/';
        $pieces = explode("-", $contract);

        if (($pieces[0]+0) != 0 ){
            $path .= $pieces[0].'-'.$pieces[1][0].'00-'.$pieces[1][0].'99/'.$contract;
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Р'){
            $path .= 'Салон/'.$contract;
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Г'){

            $path .= 'Гранд/ГР-'.$pieces[1];

        }
        else{
            $path .= 'Дилеры/'.$contract;
        }

        return $path;
    }

}