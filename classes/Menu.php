<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 10.12.2015
 * Time: 12:28
 */

class Menu {

    public static function getMenu($ri){

        $menu = '<ul id="nav">';

        $menu .= '<li><a href="#">График</a><ul>';
        if(in_array($ri,array(1,6,7))) $menu .= '<li><a href="#">Технологи</a></li>';
        if(in_array($ri,array(1,3,10))) $menu .= '<li><a href="#">Цех</a></li>';
        if(in_array($ri,array(17))) $menu .= '<li><a href="/'.SITE_DIR.'/collector">Сборки</a></li>';
        $menu .= '</ul></li>';

        if(in_array($ri,array(0,1,3,4,6,7,8,17))) $menu .= '<li><a href="/'.SITE_DIR.'/schedule">План вывоза</a></li>';

        if(in_array($ri,array(1,4))) $menu .= '<li><a href="/'.SITE_DIR.'/new">Новый заказ</a></li>';

        if(in_array($ri,array(1,3,4))) $menu .= '<li><a href="/'.SITE_DIR.'/assembly/plan">Сборки</a></li>';

        $menu .= '</ul>';

        return $menu;
    }
}
?>
