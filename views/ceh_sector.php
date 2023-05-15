<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Галерея Мебели</title>
    <link rel="stylesheet" href="/css/android.css" title="normal" type="text/css" media="screen" />
    <script type="text/javascript" src="/scripts/jquery-2.1.1.js"></script>
</head>

<body>
    <div id="fon"></div>
    <div id="dialog">
        <input type="hidden" value="" id="oid"/>
        Подтвердите готовность заказа <h3></h3> на участке
        <div id="navbtn">
            <div class="nav" id="ok">Подтвердить</div>
            <div class="nav" id="cancel">Отмена</div>
        </div>
    </div>
   <div class="content">
        <div class="list">
            <div id="back" onclick="location.href='/skedCeh/getPlan'">Вернуться в меню</div>
            <?php if(empty($orderList)):?>
                <div id="empty">Обратитесь к начальнику производства</div>
            <?php else:?>
                <?php foreach($orderList as $order):?>
                    <?php $bgcol = strtotime($order[$etap_date])!=strtotime('today') ? '#FF6846' : 'floralwhite';?>
                    <div id="<?=$order['oid'];?>" class="one_from_list" style="background-color: <?=$bgcol;?>">
                        <?=$order['contract'];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</body>

<script type="text/javascript" src="/scripts/androdceh.js"></script>
</html>
