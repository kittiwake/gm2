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
        $lit1 = Datas::substr_function($contract, -1, 1);
        $lit2 = Datas::substr_function($contract, -2, -1);

        if (($lit1 == 'Р') || ($lit2 == 'Р') || ($lit1 == 'Д') || ($lit2 == 'Д')){
            return true;
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

}