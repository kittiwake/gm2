<style>
    #map {
        width: 100%;
        height: 100vh;
    }
</style>


<div class="content">
    <div class="content_main">
        <div class="span_zagol">
            <div id="today"><a href="/logistic">сегодня</a></div>
            <a href="/logistic/index/<?=$date-60*60*24*7;?>">
                <span><<&nbsp;&nbsp;</span>
            </a>
            <a href="/logistic/index/<?=$date-60*60*24;?>">
                <span>&nbsp;&nbsp;<&nbsp;&nbsp;</span>
            </a>
            &nbsp;&nbsp;<?=$day;?>&nbsp;&nbsp;
            <a href="/logistic/index/<?=$date+60*60*24;?>">
                <span>&nbsp;&nbsp;>&nbsp;&nbsp;</span>
            </a>
            <a href="/logistic/index/<?=$date+60*60*24*7;?>">
                <span>&nbsp;&nbsp;>></span>
            </a>
        </div>
        <div class="log_cont">
            <a href="/logistic/?printveaw=1&date=<?=$date?>" target="print_view"><img src="/images/print.png"></a>
            <h1>Закупки&nbsp;&nbsp;<img src="/images/1.jpg" onclick="showForm2();"></h1>
            <table>
                <tr>
                    <th>Куда</th>
                    <th>Адрес</th>
                    <th>Сумма</th>
                    <th>Примечание</th>
                    <th>Водитель</th>
                    <th>Удалить/Перенести</th>
                </tr>
                <?php foreach($listin as $onein):?>
                    <tr id="<?=$onein['id']?>">
                        <td class="change point"><?=$onein['point'];?></td>
                        <td class="change addr"><?=$onein['address'];?></td>
                        <td class="sum_log" <?php if($ri == 8 || $ri == 3|| $ri == 15||$ri == 1):?>onclick="tapChangeSumLog(this, event);"<?php endif;?>><?=$onein['summ'];?>
                        </td>
                        <td class="change lognote"><?=$onein['note'];?></td>
                        <td class="drname">
                            <span onclick="showForm3(this.parentNode.parentNode.id);">
                                <?=$onein['driver']==0?'назначить':$drivers[$onein['driver']];?>
                            </span>
                        </td>
                        <td>
                            <?php if($ri == 8 || $ri == 3|| $ri == 15||$ri == 1):?>
                            <!--                        редактировать -->
                            <img src="/images/proposta.gif" onclick="updateLogist(this)" class="show">&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--                        удалить выезд-->
                            <img src="/images/2.jpg" onclick="delLogist(this.parentNode.parentNode.id)">&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--                        перенести-->
                            <img src="/images/strel.jpg" onclick="showForm4(this.parentNode.parentNode.id);">
                        <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                    <td></td>
                    <td class="bold">итого</td>
                    <td class="bold"><?=$sumin;?>р.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="log_cont">
            <a href="/logistic/?printveaw=2&date=<?=$date?>" target="print_view"><img src="/images/print.png"></a>
            <h1>Вывозы&nbsp;&nbsp;<img src="/images/1.jpg" onclick="showForm1(<?=$date?>);"></h1>
            <table>
                <tr>
                    <th>Заказ</th>
                    <th>Адрес</th>
                    <th>Остаток</th>
                    <th>Примечание</th>
                    <th>Водитель</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach($listout as $onein):?>
                    <tr id="<?=$onein['id']?>">
                        <td><?=$onein['contract'];?></td>
                        <td><?=$onein['address'];?>
                            <input type="hidden" class="coords" id="ll<?=$onein['id']?>" value="<?=$onein['latlng'].', '.$onein['contract'].', '.$onein['driver'];?>">
                        </td>
                        <td><?=$onein['summ'];?></td>
                        <td><?=$onein['note'];?></td>
                        <td class="drname">
                            <span onclick="showForm3(this.parentNode.parentNode.id);">
                                <?=$onein['driver']==0?'назначить':$drivers[$onein['driver']];?>
                            </span>
                        </td>
                        <td>
                            <!--                        удалить выезд-->
                            <img src="/images/2.jpg" onclick="delLogist(this.parentNode.parentNode.id)">&nbsp;&nbsp;&nbsp;&nbsp;
<!--                            <!--                        перенести-->
<!--                            <img src="/images/strel.jpg" onclick="">-->
                        </td>
                    </tr>
                <?php
                $ost_in = $ost_in + $onein['summ'];
                endforeach;?>
            </table>
            <div class="bold">вывозов на <?=$sumout;?>р.; 30%=<?=$percent;?>р.; остаток <?=$ost_in?>р.</div>
        </div>
    </div>
</div>
<div id="fon"></div>
<div class="form" id="form1">
    <form action="#" method="post">
        <!--    список заказов на отгрузку в указанный день-->
        <select id="point" name="point" onchange="getInfo(this.value);">
            <option value="0">&nbsp;</option>
        </select>
        <h6>*Если заказа нет в списке, значит в графике вывоза он стоит не на этот день</h6><br>
        Адрес <textarea name="address" id="address" cols="40" rows="2"></textarea>
<!--        <input type="text" name="address" id="address" ><br>-->
        Сумма <input type="text" name="sum" id="sum" disabled size="10">
        Предоплата <input type="text" name="predopl" id="predopl" disabled size="10"><br>
        Остаток <input type="text" name="ostatok" id="ostatok"><!--если нал, не расср, не рекл --><br>
        Примечание <textarea name="note" id="note" cols="40" rows="3"></textarea>
        <input type="submit" name="addOut" value="Добавить">
    </form>
</div>
<div class="form" id="form2">
    <form action="#" method="post">
        <input type="text" name="point" id="point"><br><br>
        Адрес <textarea name="address" id="address" cols="40" rows="2"></textarea><br><br>
        Сумма <input type="text" name="sum" id="sum"><br>
        Примечание <textarea name="note" id="note" cols="40" rows="2"></textarea><br><br>
        <input type="submit" name="addIn" value="Добавить">
    </form>
</div>
<div class="form" id="form3">
    <!--        список водителей-->
    <div class="list_user" id="us0">
        <label><input type="radio" name="usname" value="0">удалить</label>
    </div>
    <br>
    <?php foreach($drivers as $uid=>$name):?>
        <div class="list_user" id="us<?=$uid;?>">
            <label><input type="radio" name="usname" value="<?=$uid;?>"><?=$name;?></label>
        </div>
    <?php endforeach;?>
    <br>
    <input type="button" value="Назначить" onclick="changeDriver()"><!-- заменить в базе (js) -->
</div>
<div class="form" id="form4">
    <input type="hidden" value="" id="logid">
    <input type="text" id="term" value="" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
    <button onclick="transposition()">Перенести</button>
</div>

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
        var masscoords = document.getElementsByClassName('coords');
//        var latlng;
        var colors = setColors();

        for (var k= 0; k<masscoords.length; k++){
            if(masscoords[k].value.charAt(0) != 0){
                var latlng = masscoords[k].value;
                var lat_lng = latlng.split(', ');
                var lat = parseFloat(lat_lng[0]),
                    lng = parseFloat(lat_lng[1]),
                    con = lat_lng[2],
                    driver = lat_lng[3];
                var label = 'us'+driver;
                var marker = new google.maps.Marker({
                    position: {lat: lat, lng: lng},
                    map: map,
                    label:con,
                    icon: {
                        path: 'm 0,34 7,-19 40,0 0,-30 -94,0 0,30 40,0 z',
                        anchor: new google.maps.Point(0,34),
                        scale: 1,
                        fillColor: colors[label],
                        fillOpacity:0.6,
                        strokeWeight:1
                    }
                });
            };
        }

//        var markerС = new google.maps.Marker({
//            position: {lat: 55.753574, lng: 37.623286},
//            map: map,
//            label:'CENTER',
//            icon: {
//                path: 'm 0,34 7,-19 47,0 0,-30 -108,0 0,30 47,0 z',
//                anchor: new google.maps.Point(0,34),
//                scale: 1,
//                fillColor: 'pink',
//                fillOpacity:0.6,
//                strokeWeight:1
//            }
//        });

//        var goldStar = {
//            path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
//            fillColor: 'yellow',
//            fillOpacity: 0.8,
//            scale: 1,
//            strokeColor: 'gold',
//            strokeWeight: 14
//        };
//



//        var marker = new google.maps.Marker({
//            position: {lat: 55.753554, lng: 37.623226},
//            map: map
//        });
//        var marker2 = new google.maps.Marker({
//            position: {lat: 55.756654, lng: 37.522126},
//            map: map
//        });

    }
    function setColors(){
        var listColors = new Object();;
        var listUser = document.getElementsByClassName('list_user');
        var colors = ['red','blue','green','yellow','aqua','gold','orange','indigo','violet','pink','thistle','lavender','brown','silver'];
        for(var k=0; k<listUser.length; k++){
            var usid = listUser[k].id;
            listColors[usid] = colors[k];
        }
        return listColors;
    }
</script>
