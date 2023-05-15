<?php

class Allowed {
    
    public static function getAllowed($contr,$act){
        $db = Db::getConection();

        $res = $db->prepare("
SELECT *
FROM `allowed`
WHERE `controller`= :contr
AND `action`=:act
");
        $res->execute(array(
            ':contr'=>$contr,
            ':act'=>$act
        ));
//        $empty = $res->rowCount() === 0;
//        if ($empty) return false;

        $res->setFetchMode(PDO::FETCH_ASSOC);
        $row = $res->fetch();
        return $row['allowed'];
    }

    
}