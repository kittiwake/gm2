<?php

class Navigator {

    public static function getMenu($ri){

        $menu = '<ul id="nav">';
        
        $list = Menu::getMainPoints();
        foreach($list as $main):
            $access = json_decode($main['access']);
 //           debug($access);
            if (isset($access) && in_array($ri, $access)):
                $menu .= '<li><a href="'.$main['url'].'">'.$main['point'].'</a><ul>';
                $seclist = Menu::getSecondPoints($main['id']);
                foreach($seclist as $point):
                    $access1 = json_decode($point['access']);
                    if (isset($access1) && in_array($ri, $access1)):
                        $menu .= '<li><a href="'.$point['url'].'">'.$point['point'].'</a></li>';
                    endif;
                endforeach;
                $menu .= '</ul></li>';
            endif;
        endforeach;
        
        $menu .= '</ul>';
        

  /*      $menu = '<ul id="nav">';

        if(in_array($ri,array(0,1,3,5,6,8,10,17))) $menu .= '<li><a href="#">График</a><ul>';
        if(in_array($ri,array(1,6))) $menu .= '<li><a href="/technologist/schedule">Технологи</a></li>';
        if(in_array($ri,array(0,1,3,8,10))) $menu .= '<li><a href="/skedCeh/getPlan">Цех</a></li>';
        if(in_array($ri,array(1,17))) $menu .= '<li><a href="/collector">Сборки</a></li>';
        if(in_array($ri,array(1,5))) $menu .= '<li><a href="/designer">Замеры</a></li>';
        if(in_array($ri,array(0,1,3,5,6,8,10,17))) $menu .= '</ul></li>';

        if(in_array($ri,array(0,1,2,3,4,6,8,16,20,55,58)))$menu .= '<li><a href="#">Вывоз</a><ul>';
        if(in_array($ri,array(0,1,2,3,4,6,8,16,20,55,58))) $menu .= '<li><a href="/schedule/orders">Вывоз заказов</a></li>';
        if(in_array($ri,array(0,1,2,3,4,6,8,16,20,55,58))) $menu .= '<li><a href="/schedule/claim">Вывоз рекламаций</a></li>';
        if(in_array($ri,array(1,3,4,8))) $menu .= '<li><a href="/schedule/pre"><b>Предварительный</b></a></li>';
        if(in_array($ri,array(1,2,3,55,58))) $menu .= '<li><a href="/claim">Непросчитанные рекламации</a></li>';
        if(in_array($ri,array(1,3,4,16))) $menu .= '<li><a href="/alexandria/schedule">Александрия</a></li>';
        if(in_array($ri,array(1,3,20))) $menu .= '<li><a href="/schedule/mdf">Мдф фасады</a></li>';
        if(in_array($ri,array(0,1,2,3,4,6,8,16,20,55,58)))$menu .= '</ul></li>';

        if(in_array($ri,array(1,4))) $menu .= '<li><a href="/new">Новый заказ</a></li>';

        if(in_array($ri,array(1,2,55))) $menu .= '<li><a href="/new/call">Добавить замер</a></li>';

        if(in_array($ri,array(1,3,4,58))) $menu .= '<li><a href="/assembly/plan">Сборки</a></li>';

        if(in_array($ri,array(1,2,55,58))) $menu .= '<li><a href="/designer/plan">Замеры</a><ul>';
        if(in_array($ri,array(1,2,55,58))) $menu .= '<li><a href="/designer/arhiv">Архив</a></li>';
        if(in_array($ri,array(1,2,55,58))) $menu .= '</ul></li>';

        if(in_array($ri,array(1,3,4,8,55,58))) $menu .= '<li><a href="#">Планирование</a><ul>';
        if(in_array($ri,array(1,3))) $menu .= '<li><a href="/plan/tech">Технологи</a></li>';
        if(in_array($ri,array(1,3))) $menu .= '<li><a href="/plan/ceh">Цеха</a></li>';
        if(in_array($ri,array(1,3,4,8,58))) $menu .= '<li><a href="/delivery/schedule">Снабжение</a></li>';
        if(in_array($ri,array(1,3,8))) $menu .= '<li><a href="/delivery/oldi">Снабжение ОЛДИ</a></li>';
        if(in_array($ri,array(1,3,4,8,55,58))) $menu .= '<li><a href="/logistic">Логистика</a></li>';
        if(in_array($ri,array(1,3))) $menu .= '<li><a href="/plan/stan">Начальник</a></li>';
        if(in_array($ri,array(1,3,8,55,58))) $menu .= '</ul></li>';

        if(in_array($ri,array(1,2,3,4,55,58))) $menu .= '<li><a href="#">Отчеты</a><ul>';
        if(in_array($ri,array(1,3,4))) $menu .= '<li><a href="/report/assembly">Сборки</a></li>';
        if(in_array($ri,array(1,3,58))) $menu .= '<li><a href="/report/aveturnover">Оборот</a></li>';
        if(in_array($ri,array(1,3,58))) $menu .= '<li><a href="/report/technologist">Просчет</a></li>';
        if(in_array($ri,array(1,3,4,58))) $menu .= '<li><a href="/report/export">Вывоз</a></li>';
        if(in_array($ri,array(1,2,3,4,55,58))) $menu .= '<li><a href="/report/expclaim">Рекламации</a></li>';
        if(in_array($ri,array(1,3,58))) $menu .= '<li><a href="/report/logistic">Логистика</a></li>';
        if(in_array($ri,array(1,3,58))) $menu .= '<li><a href="/report/material">Распилы</a></li>';
        if(in_array($ri,array(1,2,3,55,58))) $menu .= '<li><a href="/report/sample">Замеры</a></li>';
        if(in_array($ri,array(1,4,3,58))) $menu .= '<li><a href="/report/sms">СМС</a></li>';
        if(in_array($ri,array(1,4,3,58))) $menu .= '<li><a href="/report/sms/email">E-mail</a></li>';
        if(in_array($ri,array(1,4,3,58))) $menu .= '<li><a href="/report/NP">По заказам</a></li>';
        if(in_array($ri,array(1,2,3,4,55,58))) $menu .= '</ul></li>';

        if(in_array($ri,array(1,2,3,4,6,8,16,55,58))) $menu .= '<li><a href="/find"><img src="/images/find.jpg" style="border-radius: 10px; vertical-align: middle; "/>Найти</a></li>';

        if(in_array($ri,array(1,3,58))) $menu .= '<li><a href="/staff">Кадры</a><ul>';
        if(in_array($ri,array(1,2,3,58))) $menu .= '</ul></li>';

        $menu .= '</ul>';
*/
        return $menu;
    }
}

?>
