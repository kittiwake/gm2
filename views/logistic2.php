<style>
    #map {
        width: 100%;
        height: 100vh;
    }
    .noteh{
        display: none;
    }
    .lognote:hover > .noteh{
        display: block;
    }
    .lognote:hover > .errorh{
        display: none;
    }
    .errorh{
        color: red;
    }
    .errorsnab{
        width: 400px;
height: 200px;
top: 20%;
position: absolute;
background: bisque;
z-index: 10;
left: 30%;
border: 10px solid blanchedalmond;
color: #d50000;
font-size: 1.7em;
text-align: center;
    }
</style>

<?php
if(isset($err)&&$err!=''):?>
    <div class="errorsnab">
    <p><?=$err?></p>
    <button onclick='this.parentNode.style.display="none"'>Ясно</button>
    </div>
<?php
endif;
?>

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
            <h1>Закупки&nbsp;&nbsp;
                <?php if($ri == 8||$ri == 33):?>
                    <!--<a href="/delivery/schedule">-->
                <?php endif;?>
                        <img src="/images/1.jpg" onclick="showForm2();">
                <?php if($ri == 8||$ri == 33):?>
                    <!--</a>-->
                <?php endif;?>
            </h1>

            <table>
                <tr>
                    <th>Куда</th>
                    <th>Адрес</th>
                    <th>Сумма</th>
                    <th>Примечание</th>
                    <th>Водитель</th>
                    <th>Удалить/Перенести</th>
                </tr>
                <?php if(isset($points)):
                foreach($points as $provid=>$provlist):?>
                    <tr class="autopoint" id="<?=$provlist['logist_id']?>">
                        <td>
                            <?=$provlist['name'];?>
                        </td>
                        <td>
                            <?=$provlist['ords']?>
                            
                        </td>
                        <td><?=$provlist['s']?></td>
                        <td class="change lognote"><?=$provlist['note'];?></td>
                        <td class="drname">
                            <span onclick="showForm3(this.parentNode.parentNode.id);">
                                <?=$provlist['driver']==0?'назначить':$drivers[$provlist['driver']];?>
                            </span>
                        </td>
                        <td>
                            <?php if($ri == 8 || $ri == 3|| $ri == 4 || $ri == 15||$ri == 1 || $ri == 33):?>
                                <!--                        редактировать -->
                                <img src="/images/proposta.gif" onclick="updateLogist(this)" class="show">&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--                        перенести-->
                                <img src="/images/strel.jpg" onclick="showForm4(this.parentNode.parentNode.id);">
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;endif;?>

                <?php foreach($listin as $onein):?>
                    <tr id="<?=$onein['id']?>">
                        <td class="change point"><?=$onein['point'];?></td>
                        <td class="change addr">
                            
                            <?php if(isset($onein['auto'])):?>
                            <div class="addr">
                                <div>
                                    <?=$onein['address'];?>
                                </div>
                                    <img src="/images/proposta.gif" onclick="showinpAddr(this,<?=$onein['pointid'];?>)" >&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="inpAddr hidden print_ignore">
                                <input type="text" value="">
                                <img src="/images/save.png" onclick="saveProvAddr(this,<?=$onein['pointid'];?>)" >&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <?php else:?>
                            <?=$onein['address'];?>
                            <?php endif;?>
                        </td>
                        <td class="sum_log" <?php if(($ri == 8 || $ri == 3 || $ri == 4 || $ri == 15 || $ri == 1 || $ri == 33) && !isset($onein['auto'])):?>onclick="tapChangeSumLog(this, event);"<?php endif;?>><?=$onein['summ'];?>
                        </td>
                        <td class="change lognote">
                            <?php if(isset($onein['error'])):?>
                                <span class="errorh"><?=$onein['error'];?></span>
                                <span class="noteh"><?=$onein['note'];?></span>
                            <?php else:?>
                                <?=$onein['note'];?>
                            <?php endif;?>
                        </td>
                        <td class="drname">
                            <span onclick="showForm3(this.parentNode.parentNode.id);">
                                <?=$onein['driver']==0?'назначить':$drivers[$onein['driver']];?>
                            </span>
                        </td>
                        <td>
                            <?php if(isset($onein['auto'])):?>
                                <img src="/images/strel.jpg" onclick="showForm4(this.parentNode.parentNode.id);">
                            <?php else:?>
                                <?php if($ri == 8 || $ri == 3 || $ri == 4 || $ri == 15||$ri == 1 || $ri == 33 || $ri == 55):?>
                                    <!--                        редактировать -->
                                    <img src="/images/proposta.gif" onclick="updateLogist(this)" class="show">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                              <!--                        удалить выезд-->
                                    <img src="/images/2.jpg" onclick="delLogist(this.parentNode.parentNode.id)">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                                <!--                        перенести-->
                                    <img src="/images/strel.jpg" onclick="showForm4(this.parentNode.parentNode.id);">
                                <?php endif;?>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td class="bold">итого</td>
                    <td class="bold"></td>
                    <td class="bold"><?=$summat+$sumin;?>р.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold"></td>
                    <td class="bold">на материалы</td>
                    <td class="bold"><?=isset($summat)?$summat:0;?>р.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold">на расходники</td>
                    <td class="bold"><?=isset($sumin)?$sumin:0;?>р.</td>
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
    <input type="hidden" value="" id="logauto">
    <input type="text" id="term" value="" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
    <button onclick="transposition()">Перенести</button>
</div>


