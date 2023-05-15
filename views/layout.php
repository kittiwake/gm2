<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <meta name=”robots” content=”noindex,nofollow”>
    <title>Галерея Мебели</title>
    <link rel="stylesheet" href="/css/style.css" title="normal" type="text/css" media="screen" />
    <link rel="stylesheet" href="/css/new.css" title="normal" type="text/css" media="screen" />
    <script type="text/javascript" src="/scripts/calendar_ru.js"></script>
    <script type="text/javascript" src="/scripts/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="/scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="/scripts/jquery-ui.js"></script>
    <link type="text/css" href="/css/jquery-ui.css" rel="stylesheet" />
<!--    <script type="text/javascript" src="/scripts/socket.js"></script>-->
    <?php if(isset($script)) echo ($script); ?>
    <?php if(isset($style)) echo ($style); ?>
</head>

<body>
<div id="shapka">
    <div id="menu">
<?php echo Navigator::getMenu($ri); ?>

    </div>
    <div id="hello">
        Привет, <a href="/auth/showAuth" ><?=$log?></a>
        <input id="uright" type="hidden" value="<?=$ri?>"/>
    </div>
</div>
<!--когда-то шапку уберем, все меню пойдет как подменю к левому меню-->
<!--
<div id="leftmenu" class="leftmenu">

    <a href="/leads" title="Договора">
        <div>
            <img src="/images/orders.gif" alt="" class="imgmenu"/>
        </div>
    </a>
    <a href="/todo" title="Задачи">
        <div>
            <img src="/images/zadacha.gif" alt="" class="imgmenu"/>
        </div>
    </a>
    <a href="/contacts" title="Контакты">
        <div>
            <img src="/images/contacts.gif" alt="Контакты" class="imgmenu"/>
        </div>
    </a>
    <a href="/report" title="Статистика">
        <div>
            <img src="/images/otchet.gif" alt="" class="imgmenu"/>
        </div>
    </a>
    <a href="#" title="Настройки">
        <div>
            <img src="/images/settings.gif" alt="" class="imgmenu"/>
        </div>
    </a>
    <a href="/callmessages" title="Сообщения">
        <div class="menuimg">
            <img src="/images/messege.gif" alt="" class="imgmenu lastimg"/>
            <div id="newmesnum" class="signal"></div>
        </div>
    </a>

</div>
-->

<?php include ($page); ?>

</body>
<script type="text/javascript" src="/scripts/script.js"></script>
<!--<script type="text/javascript" src="/scripts/callcenter.js"></script>-->
<?php if(isset($script2)) echo ($script2); ?>
</html>
