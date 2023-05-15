<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ГМ карты</title>
<!--    <link rel="stylesheet" href="/css/style.css" title="normal" type="text/css" media="screen" />-->
<!--    <link rel="stylesheet" href="/css/new.css" title="normal" type="text/css" media="screen" />-->
<!--    <script type="text/javascript" src="/scripts/calendar_ru.js"></script>-->
<!--    <script type="text/javascript" src="/scripts/jquery-2.1.1.js"></script>-->
<!--    <script type="text/javascript" src="/scripts/jquery.cookie.js"></script>-->
<!--    <script type="text/javascript" src="/scripts/jquery-ui.js"></script>-->
<!--    <link type="text/css" href="/css/jquery-ui.css" rel="stylesheet" />-->
<!--    --><?php //if(isset($script)) echo ($script); ?>
<!--    --><?php //if(isset($style)) echo ($style); ?>
    <!-- 2. Необходимо стилизовать этот элемент, задать ему высоту и ширину чтобы он был виден на странице -->
    <style>
        *{
            margin: 0;
        }
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>

</head>
<body>

<!-- 1. Создаем элемент внутри которого у нас будет отображаться карта Google Maps -->
<div id="map"></div>
<!-- 3. Подключаем библиотеку Google Maps Api, чтобы создать карту -->
<!-- Атрибуты async и defer - позволяют загружать этот скрипт асинхронно, вместе с загрузкой всей страницы  -->
<!-- В подключении библиотеки Google Maps Api в конце указан параметр callback, после  подключения и загрузки этого Api сработает функция initMap для отрисовки карты,  которую мы описали выше -->
<!--AIzaSyBaU2sxGxc6XXN9l-7lUsGiUBf6Snc6-js-->

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaU2sxGxc6XXN9l-7lUsGiUBf6Snc6-js&callback=initMap">
</script>

<!-- 4. Пишем скрипт который создаст и отобразит карту Google Maps на странице. -->
<script type="text/javascript">



    // Определяем переменную map
    var map;

    // Функция initMap которая отрисует карту на странице
    function initMap() {

        var point = new google.maps.LatLng(55.753574, 37.623286);
//        В переменной map создаем объект карты GoogleMaps и вешаем эту переменную на #map
        map = new google.maps.Map(document.getElementById('map'), {
            // При создании объекта карты необходимо указать его свойства
            // center - определяем точку на которой карта будет центрироваться
//            55.753574, 37.623286
            center: point,
            // zoom - определяет масштаб. 0 - видно всю платнеу. 18 - видно дома и улицы города.
            zoom: 11
        });
        var marker = new google.maps.Marker({
            position: {lat: 55.753554, lng: 37.623226},
            map: map
        });
        var marker2 = new google.maps.Marker({
            position: {lat: 55.756654, lng: 37.522126},
            map: map
        });

    }
</script>




</body>
</html>