<?php

class Menu {

    public static function getMenu($ri){

        $menu = '<ul id="nav">';

        $menu .= '<li><a href="#">График</a><ul>';
        if(in_array($ri,array(1,6,7))) $menu .= '<li><a href="/'.SITE_DIR.'/technologist/schedule">Технологи</a></li>';
        if(in_array($ri,array(1,3,10))) $menu .= '<li><a href="#">Цех</a></li>';
        if(in_array($ri,array(17))) $menu .= '<li><a href="/'.SITE_DIR.'/collector">Сборки</a></li>';
        $menu .= '</ul></li>';

        $menu .= '<li><a href="#">Вывоз</a><ul>';
        if(in_array($ri,array(0,2,1,3,4,6,7,8,17))) $menu .= '<li><a href="/'.SITE_DIR.'/schedule/orders">Вывоз заказов</a></li>';
        if(in_array($ri,array(0,1,2,3,4,6,7,8,17))) $menu .= '<li><a href="/'.SITE_DIR.'/schedule/claim">Вывоз рекламаций</a></li>';
        if(in_array($ri,array(1,2))) $menu .= '<li><a href="/'.SITE_DIR.'/claim">Непросчитанные рекламации</a></li>';
        $menu .= '</ul></li>';

        if(in_array($ri,array(1,4))) $menu .= '<li><a href="/'.SITE_DIR.'/new">Новый заказ</a></li>';

        if(in_array($ri,array(1,3,4))) $menu .= '<li><a href="/'.SITE_DIR.'/assembly/plan">Сборки</a></li>';

        $menu .= '<li><a href="#">Планирование</a><ul>';
        if(in_array($ri,array(1,7))) $menu .= '<li><a href="/'.SITE_DIR.'/plan/tech">Технологи</a></li>';
        if(in_array($ri,array(1,3))) $menu .= '<li><a href="/'.SITE_DIR.'/plan/ceh">Цеха</a></li>';
        $menu .= '</ul></li>';

        $menu .= '<li><a href="#">Отчеты</a><ul>';
        if(in_array($ri,array(1,3))) $menu .= '<li><a href="/'.SITE_DIR.'/report/assembly">Сборки</a></li>';
        if(in_array($ri,array(1))) $menu .= '<li><a href="/'.SITE_DIR.'/report/aveturnover">Оборот</a></li>';
        $menu .= '</ul></li>';

        $menu .= '</ul>';

        return $menu;
    }
}
?>
