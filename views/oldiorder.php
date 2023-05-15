<div class="content">
    <input type="hidden" id="orderid" value="<?=$ordersList['id']?>">
    <div id="form" class="form">
            Перенести вывоз заказа № <label></label>
            <p>на</p>
            <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);">
            <input type="button" id="oldisubmitok" value="Ok">
    </div>

    <div class="caption" id="zakaz">
        Заказ № <?=$ordersList['contract']?>
    </div>
    <div class="olstan">
        <div class="plandate">
            <img id="strelka" src="/images/strel.jpg" onclick="showFormTransfer();">
                <input type="hidden" id="olddate" value="<?=$ordersList['plan'];?>">
            <div id="plan_date"><?=$plan?></div>
        </div>
        <div class="etaps">
            <?php foreach ($etapList as $etap):?>
                <div class="etap_one">

                    <div>
                        <?=$etap['etap']?>
                    </div>
                    <div>
                        <img id="<?=$etap['etap_stan']?>" src="/images/<?=$images[$etap['etap_stan']]?>.jpg" onclick="change_olStan(this.id);">
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="about">
        <div class="date_list">
            <div class="date_name">Принят</div>
            <div class="date_val"><?=$prinjat?></div>
            <div class="date_name">Срок исполнения</div>
            <div class="date_val"><?=$term?></div>
            <div class="date_name">&nbsp;</div>
            <div class="date_name">сумма</div>
            <div class="date_val"><?=$ordersList['sum']?></div>
            <?php if ($ordersList['beznal'] == 0):?>
                <div class="date_name">остаток</div>
                <div class="date_val"><?=$ostatok?></div>
            <?php else: ?>
                <div class="date_name">безнал</div>
                <?php if ($ordersList['beznal'] == 1):?>
                    <div class="date_val" id="paied"><input type="button" value="Оплачен" id="cash"></div>
                <?php endif; ?>
                <?php if ($ordersList['beznal'] == 2):?>
                    <div class="date_val">Оплачен</div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
        <div class="about_order">
            <div class="row">
                <div class="label">Фасады</div>
                <div class="znach" id="tipe"><?=$tip?></div>
                <div class="input">
                    <label><input type="radio" name="tip" value="1" <?php if ($ordersList['tip'] == 1){echo 'checked';}?>/>ПВХ  </label>
                    <label><input type="radio" name="tip" value="2" <?php if ($ordersList['tip'] == 2){echo 'checked';}?>/>эмаль</label>
                </div>
            </div>
            <div class="row">
                <div class="label">Цвет</div>
                <div class="znach" id="color_pokr">
                    <?=$ordersList['color']?> <?=$pokrytie[$ordersList['pokr']]?>
                </div>
                <div class="input">
                    <input type="text" name="color" value="<?=$ordersList['color'];?>"/>
                    <select name="pokr" id="pokr">
                        <option value="0"> </option>
                        <option value="1" <?php if ($ordersList['pokr'] == 1){echo 'selected';}?> >матовый</option>
                        <option value="2" <?php if ($ordersList['pokr'] == 2){echo 'selected';}?> >высокий глянец</option>
                        <option value="3" <?php if ($ordersList['pokr'] == 3){echo 'selected';}?> >глянец металлик</option>
                        <option value="4" <?php if ($ordersList['pokr'] == 4){echo 'selected';}?> >металлик золото</option>
                        <option value="5" <?php if ($ordersList['pokr'] == 5){echo 'selected';}?> >звездное небо</option>
                        <option value="6" <?php if ($ordersList['pokr'] == 6){echo 'selected';}?> >хамелеон</option>
                        <option value="7" <?php if ($ordersList['pokr'] == 7){echo 'selected';}?> >перламутр насыщенный</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="label">Доп.эффект</div>
                <div class="znach" id="dopeff"><?=$dopefect[$ordersList['dop_ef']]?></div>
                <div class="input">
                    <select id="defemal" name="defemal">
                        <option value="0"> </option>
                        <option value="1" <?php if ($ordersList['dop_ef'] == 1){echo 'selected';}?> >патина</option>
                        <option value="2" <?php if ($ordersList['dop_ef'] == 2){echo 'selected';}?> >градиент</option>
                        <option value="3" <?php if ($ordersList['dop_ef'] == 3){echo 'selected';}?> >трафарет 1</option>
                        <option value="4" <?php if ($ordersList['dop_ef'] == 4){echo 'selected';}?> >трафарет 2</option>
                        <option value="5" <?php if ($ordersList['dop_ef'] == 5){echo 'selected';}?> >трафарет 3</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="label">Квадратура</div>
                <div class="znach" id="kvadr"><?=$ordersList['mkv']?> м<sup>2</sup></div>
                <div class="input">
                    <input type="text" id="mkv" name="mkv" value="<?=$ordersList['mkv'];?>"/> м<sup>2</sup>
                </div>
            </div>
            <div class="row">
                <div class="label">Радиусные фасады</div>
                <div class="znach" id="radiusnye"><?=$yesno[$ordersList['radius']]?></div>
                <div class="input">
                    <input type="checkbox" id="rradius" name="radius" <?php if ($ordersList['radius'] == 1){echo 'checked';}?>/>
                </div>
            </div>
            <div class="row">
                <div class="label">Фотопечать</div>
                <div class="znach" id="fotopechat"><?=$yesno[$ordersList['fotopec']]?></div>
                <div class="input">
                    <input type="checkbox" id="fotopech" name="fotopec" <?php if ($ordersList['fotopec'] == 1){echo 'checked';}?>/>
                </div>
            </div>
            <div class="row">
                <div class="label"></div>
                <div class="znach">
                    <input type="button" value="Изменить" id="but_order">
                </div>
                <div class="input">
                    <input type="button" value="Сохранить изменения" id="but_form">
                </div>
            </div>
            <div id="notes_main">
                <div id="notes">
                    <?=$ordersList['note']?>
                </div>
                <a onclick="showAddNote();">Добавить примечание</a>
                <div id="polenote" style="display: none;">
                    <input type="hidden" value="<?=date('d.m.Y')?>" id="date_today">
                    <textarea rows="3" cols="40" id="note"></textarea>
                    <button onclick="addOldiNote();">Добавить</button>
                </div>
            </div>
        </div>

        <div class="about_customer">
            <div>
                <table>
                    <tr>
                        <td>мдф</td>
                        <td>радиуса</td>
                        <td><?=$tip;?></td>
                    </tr>
                    <tr>
                        <td>
                            <img id="mat_mdf" src="/images/<?=$images['mat_mdf']?>.jpg" onclick="change_olStan(this.id);">
                        </td>
                        <td>
                            <img id="mat_radius" src="/images/<?=$images['mat_radius']?>.jpg" onclick="change_olStan(this.id);">
                        </td>
                        <td>
                            <img id="mat_oblic" src="/images/<?=$images['mat_oblic']?>.jpg" onclick="change_olStan(this.id);">
                        </td>
                    </tr>
                </table>
            </div>
            <input id="cid" type="hidden" value="<?=$customer['id']?>">
            <div class="cust_name">имя</div>
            <div class="cust_val" id="custname"><?=$customer['name']?></div>
            <div class="cust_form">
                <input type="text" id="cname" name="cname" value="<?=$customer['name']?>"/>
            </div>
            <div class="cust_name">телефон</div>
            <div class="cust_val" id="custphone"><?=$customer['phone']?></div>
            <div class="cust_form">
                <input type="text" id="cphone" name="cphone" value="<?=$customer['phone']?>"/>
            </div>
            <div class="cust_name">статус</div>
            <div class="cust_val"><?php if($customer['diller'] == 1) echo 'дилер'; else echo 'заказчик';?></div>
            <div class="cust_form"><?php if($customer['diller'] == 1) echo 'дилер'; else echo 'заказчик';?></div>
<!--            <div class="cust_val">
                <input type="button" id="but_cust" value="Изменить">
            </div>
-->
            <div class="cust_form">
                <input type="button" value="Сохранить изменения" id="cbut_form">
            </div>
        </div>
    </div>

    <?php
    $month = date("m", mktime(0,0,0,date('m'),1,date('Y')));
    $year  = date("Y", mktime(0,0,0,date('m'),1,date('Y')));
    $yearnow  = date("Y", mktime(0,0,0,date('m'),1,date('Y')));
    $months = array('','январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
    ?>

    <div id="fon" class="fon"></div>
    <div id="calendar" >
        <table border="1" cellspacing="0" cellpadding="5"">
            <tr>
                <?php for ($mh=0; $mh<3; $mh++):
                    $mes = $month + $mh;
                    if ($mes > 12)
                    {
                        $mes = $mes - 12;
                        if($yearnow == $year){
                            $year = $year + 1;
                        }
                    }
                    $skip = date("w", mktime(0,0,0,$mes,1,$year)) - 1; // узнаем номер дня недели
                    if($skip < 0)
                    {
                        $skip = 6;
                    }
                    $daysInMonth = date("t", mktime(0,0,0,$mes,1,$year));       // узнаем число дней в месяце
                    $day = 1;
                    ?>
                    <td>
                        <table>
                            <tr>
                                <td colspan="7">
                                    <?=$months[$mes]?>
                                </td>
                            </tr>
                            <tr>
                                <td>ПН</td>
                                <td>ВТ</td>
                                <td>СР</td>
                                <td>ЧТ</td>
                                <td>ПТ</td>
                                <td>СБ</td>
                                <td>ВС</td>
                            </tr>
                            <?php for ($week=0; $week<6; $week++):?>
                                <tr>
                                    <?php for ($dw=0; $dw<7; $dw++):?>

                                        <?php if ($skip>0 || $day>$daysInMonth):?>
                                            <td></td>
                                            <?php $skip--;?>
                                        <?php else:?>
                                            <td>
                                                <div id="<?=$day?>-<?=$mes?>-<?=$year?>" class="cal">
                                                    <?=$day?>
                                                </div>
                                            </td>
                                            <?php $day++;?>
                                        <?php endif;?>

                                    <?php endfor;?>
                                </tr>
                            <?php endfor;?>
                        </table>
                    </td>
                <?php endfor;?>
            </tr>
        </table>
    </div>




</div>

<script>
    $(".matdate").each(function(){
        var text = $(this).text();
        if(text=="0000-00-00") $(this).text('');
        else{
            $(this).text(text.replace(/(\d{4})-(\d{2})-(\d{2})/,'$3.$2'));
        }
    });
</script>
    