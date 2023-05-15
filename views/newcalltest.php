<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Галерея Мебели</title>
    <link rel="stylesheet" href="/css/style.css" title="normal" type="text/css" media="screen" />
    <script type="text/javascript" src="/scripts/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="/scripts/newcall.js"></script>
    <?php if(isset($script)) echo ($script); ?>
    <?php if(isset($style)) echo ($style); ?>
</head>
<body>
<input type="hidden" id="callId" value="<?=$tel;?>"/>
<div id="head">
Входящий вызов
</div>
<div id="cont">
<!--    <button>включить запись</button>-->
    <div class="head">
        <div class="clientid" id="clientid"><?=$clientinfo['id'];?></div>
        <?=$tel;?>
    </div>
    <?php if ($clientinfo['callmen'] == ''){?>
    <div class="info">
        <button class="butt" onclick="addContact(<?=$clientinfo['id'];?>)">Добавить к контакту</button>
        <button class="butt" onclick="contractErr(<?=$clientinfo['id'];?>)">В мусор</button>
        <form method="post">
            <input type="hidden" name="clientid" value="<?=$clientinfo['id'];?>"/>
            <div class="rowcl">
                <div class="zagol">Имя</div>
                <div class="cellcl">
                    <input type="text" id="namecl" size="60" name="namecl"/>
                </div>
                <div class="cellcl errorcl"><?=isset($errn)?$errn:''?></div>
            </div>
            <div class="rowcl">
                <div class="zagol">Откуда узнали</div>
                <div class="cellcl">
                    <input type="text" id="istochcl" name="istochcl" size="60"/>
                </div>
            </div>
            <div class="rowcl">
                <div class="zagol">e-mail</div>
                <div class="cellcl">
                    <input type="text" id="mailcl" name="mailcl" size="60"/>
                </div>
            </div>
            <div class="rowcl">
                <div class="zagol">Дополнительные номера: 1)</div>
                <div class="cellcl">
                    <input type="text" id="phone2" name="phone2" size="60"/>
                </div>
            </div>
            <div class="rowcl">
                <div class="zagol">2)</div>
                <div class="cellcl">
                    <input type="text" id="phone3" name="phone3" size="60"/>
                </div>
            </div>
            <input type="submit" value="Готово" name="submit"/>
        </form>
    </div>
    <?php }else{?>
        <div class="info">
            <div class="rowcl">
                <div class="zagol">Имя</div>
                <div class="cellcl">
                    <?=$clientinfo['name'];?>
                </div>
            </div>
            <div class="rowcl">
                <div class="zagol">Контакты</div>
                <div class="cellcl">
                    <?php
                    if ($clientinfo['phone'] != '') echo $clientinfo['phone'].', ';
                    if ($clientinfo['phone2'] != '') echo $clientinfo['phone2'] . ', ';
                    if ($clientinfo['phone3'] != '') echo $clientinfo['phone3'] . ', ';
                    if ($clientinfo['email'] != '') echo $clientinfo['email'] . ', ';
                    ?>
                </div>
            </div>
        </div>
        <div class="orders">
            <h4>Информация о заказах</h4>
            <?php
            if ($clientinfo['contracts'] == 'yes'){
            foreach ($clientinfo['orders'] as $k => $order) {?>
            <div class="ordercl">
                <div class="rowcl head">
                    <div class="cellcl">
                        <?=$order['contract']?> от <?=$order['contract_date']?>
                    </div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Изделие</div>
                    <div class="cellcl"><?=$order['product']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Адрес</div>
                    <div class="cellcl"><?=$order['adress']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Менеджер</div>
                    <div class="cellcl"><?=$order['manager']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Дизайнер</div>
                    <div class="cellcl"><?=$order['design']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Технолог</div>
                    <div class="cellcl"><?=$order['technologist']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Водитель</div>
                    <div class="cellcl"><?=$order['driver']?></div>
                </div>
                <div class="rowcl">
                    <div class="cellcl punkt">Сборщик</div>
                    <div class="cellcl"></div>
                </div>
            </div>
            <?php
            }
            }else{?>
            tel
            <?php } ?>
        </div>
    <?php } ?>
</div>
</body>
</html>