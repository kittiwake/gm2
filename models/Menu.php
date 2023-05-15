<?php


class Menu {
    
    public static function getMainPoints(){
        
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('
		SELECT *
		FROM `menu`
		WHERE `active`=1
		AND `parent`=0
		ORDER BY `sequence`
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }
    
    public static function getSecondPoints($par){
        
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('
		SELECT *
		FROM `menu`
		WHERE `active`=1
		AND `parent`=:par
		ORDER BY `sequence`
');
        $res->execute(array(
            'par'=>$par
            ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }
}