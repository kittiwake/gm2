<?php
class Controller_index
{

    function actionIndex()
    {
        $ri = $_SESSION['ri'];
        switch ($ri) {
            case 0:
                $cont = '/schedule/orders';
                break;
            case 1:
                $cont = '/schedule/orders';
                break;
            case 2:
                $cont = '/schedule/orders';
                break;
            case 3:
            case 33:
                $cont = '/schedule/orders';
                break;
            case 4:
                $cont = '/schedule/orders';
                break;
            case 5:
                $cont = '/designer';
                break;
            case 21:
            case 6:
                $cont = '/technologist/schedule';
                break;
            case 7:
                $cont = '/technologist/schedule';
                break;
            case 8:
                $cont = '/delivery/schedule';
                break;
            case 9:
                $cont = '/schedule/orders';
                break;
            case 10:
                $cont = '/skedCeh/getPlan';
                break;
            case 11:
                $cont = '/skedCeh/getPlanMdf';
                break;
            case 12:
                $cont = '/skedCeh/sectorSked/13';
                break;
            case 15:
                $cont = '/schedule/mdf';
                break;
            case 16:
                $cont = '/alexandria/schedule';
                break;
            case 17:
                $cont = '/collector';
                break;
            case 19:
                $cont = '/schedule/orders';
                break;
            case 20:
                $cont = '/schedule/orders';
                break;
            case 41:
                $cont = '/skedCeh/getPlanMdf';
                break;
            case 42:
                $cont = '/skedCeh/getPlanMdf';
                break;
            case 43:
                $cont = '/skedCeh/getPlanMdf';
                break;
            case 44:
                $cont = '/schedule/oldi/2';
                break;
            case 55:
                $cont = '/claim';
                break;
            case 58:
                $cont = '/report/NP';
                break;
            case 99:
                $cont = '/skedCeh/getPlan';
                break;
            case 100:
                $cont = '/schedule/orders';
                break;
            default:
                $cont = '/auth/showAuth';
                break;
        }

        header('Location: ' . $cont);
    }
    function actionError(){
        $page = SITE_PATH.'views/error.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

}
