<?php
class Controller_index
{

    function actionIndex()
    {
        include(SITE_PATH . 'views/auth.php');

        return true;
    }
}