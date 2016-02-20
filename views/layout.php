<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Галерея Мебели</title>
    <link rel="stylesheet" href="/<?=SITE_DIR;?>/css/style.css" title="normal" type="text/css" media="screen" />
    <link rel="stylesheet" href="/<?=SITE_DIR;?>/css/new.css" title="normal" type="text/css" media="screen" />
    <script type="text/javascript" src="/<?=SITE_DIR;?>/scripts/calendar_ru.js"></script>
    <script type="text/javascript" src="/<?=SITE_DIR;?>/scripts/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="/<?=SITE_DIR;?>/scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="/<?=SITE_DIR;?>/scripts/jquery-ui.js"></script>
    <link type="text/css" href="/<?=SITE_DIR;?>/css/jquery-ui.css" rel="stylesheet" /></head>
</head>

<body>
<div id="shapka">
    <div id="menu">

<?php echo Menu::getMenu($ri); ?>

    </div>
    <div id="hello">
        Привет, <a href="/<?=SITE_DIR;?>/auth/showAuth" onclick="killCookies();"><?=$log?></a>
    </div>
</div>

<?php include ($page); ?>

</body>
<script type="text/javascript" src="/<?=SITE_DIR;?>/scripts/script.js"></script>

</html>
