<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Входящий звонок</title>
    <script type="text/javascript" src="/scripts/infoclient.js"></script>
    <style type="text/css">
        .head, .head2{
            background-color: lightgreen;
        }
        .head{
            font-size: 1.3em;
            text-align: center;
        }
        .btn{
            float: right;
        }
        .zagol, .punkt{
            background-color: greenyellow;
            width: 30%;
            text-align: right;
            padding-right: 5px;
            margin-right: 10px;
        }
        .zagol{
            float: left;
        }
        .row{
            padding: 5px;
        }
        .cell{
            display: inline-block;
            max-width: 65%;
        }
        .order{
            width: 43%;
            display: inline-block;
            border: 2px aquamarine solid;
            margin: 5px;
        }
    </style>
</head>
<body>
<div class="content">
    <input type="hidden" id="idclient" value="<?=$addid;?>"/>
    <div class="btn">
        <button>включить запись</button>
    </div>
    <div class="head">
        <?=$phone;?>
    </div>

    <?php if($new):?>
        <button>Новый контакт</button>
<!--        показать форму для введения данных о клиенте-->
        <button>Добавить к контакту</button>
<!--        форма для поиска контакта по имени, по номеру договора-->
        <button id="err" onclick="">В мусор</button>
<!--        отметить, что номер не клиентский-->

    <?php else:?>
    <div class="info">
        <div class="row">
            <div class="zagol">Имя</div>
                <?=$name;?>
        </div>
        <div class="row">
            <div class="zagol">Откуда о нас узнали</div>
            Откуда о нас узнали
        </div>
        <div class="row">
            <div class="zagol">Контакты</div>
            <?=$res['phone']!=''?$res['phone'].", ":'';?>
            <?=$res['phone2']!=''?$res['phone2'].", ":'';?>
            <?=$res['phone3']!=''?$res['phone3'].", ":'';?>
            <?=$res['email']!=''?$res['email']:'';?>
        </div>
            <div class="orders">
                <h4>Информация о заказах</h4>
                <?php if($res['contracts']==1):
                    foreach($res2 as $order):
                ?>
                        <div class="order">
                            <div class="row head">
                                <div class="cell "><?=$order['contract'];?> от <?=$order['contract_date'];?></div>
                            </div>
                            <div class="row">
                                <div class="cell punkt">Изделие</div>
                                <div class="cell"><?=$order['product'];?></div>
                            </div>
                            <div class="row">
                                <div class="cell punkt">Адрес</div>
                                <div class="cell"><?=$order['adress'];?></div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <div class="cell punkt">Менеджер</div>
                                    <div class="cell"><?=$order['manager'];?></div>
                                </div>
                                <div class="row">
                                    <div class="cell punkt">Дизайнер</div>
                                    <div class="cell"><?=$order['design'];?></div>
                                </div>
                                <div class="row">
                                    <div class="cell punkt">Технолог</div>
                                    <div class="cell"><?=$order['technologist'];?></div>
                                </div>
                                <div class="row">
                                    <div class="cell punkt">Водитель</div>
                                    <div class="cell"><?=$order['driver'];?></div>
                                </div>
                                <div class="row">
                                    <div class="cell punkt">Сборщик</div>
                                    <div class="cell"></div>
                                </div>
                            </div>
                        </div>
                <?php endforeach; endif;?>
            </div>
    </div>
    <?php endif;?>

    <input type="text" id="namecl"/>
</div>
</body>