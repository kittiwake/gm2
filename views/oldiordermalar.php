<div class="content">
    <input type="hidden" id="orderid" value="<?=$ordersList['id']?>">

    <div class="caption" id="zakaz">
        Заказ № <?=$ordersList['contract']?>
    </div>
    <div class="olstan">
        <div class="plandate">
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
        <div class="about_order">
            <div class="row">
                <div class="label">Фасады</div>
                <div class="znach" id="tipe"><?=$tip?></div>
            </div>
            <div class="row">
                <div class="label">Цвет</div>
                <div class="znach" id="color_pokr">
                    <?=$ordersList['color']?> <?=$pokrytie[$ordersList['pokr']]?>
                </div>
            </div>
            <div class="row">
                <div class="label">Доп.эффект</div>
                <div class="znach" id="dopeff"><?=$dopefect[$ordersList['dop_ef']]?></div>
            </div>
            <div class="row">
                <div class="label">Квадратура</div>
                <div class="znach" id="kvadr"><?=$ordersList['mkv']?> м<sup>2</sup></div>
            </div>
            <div class="row">
                <div class="label">Радиусные фасады</div>
                <div class="znach" id="radiusnye"><?=$yesno[$ordersList['radius']]?></div>
            </div>
            <div class="row">
                <div class="label">Фотопечать</div>
                <div class="znach" id="fotopechat"><?=$yesno[$ordersList['fotopec']]?></div>
            </div>
            <div class="row">
                <div class="label"></div>
            </div>
            <div id="notes_main">
                <div id="notes">
                    <?=$ordersList['note']?>
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
        </div>
    </div>
        <section id="oldi">
            <div class="deliv_mater">
                <div class="deliv_list">
                    <table>
                        <tr>
                            <th>категория</th>
                            <th>материал</th>
                            <th>кол-во</th>
                            <th>дата привоза</th>
                            <th>Состояние</th>
                        </tr>
                        <?php if(!empty($materList)):?>
                            <?php foreach($materList as $mater):
                                if($mater['otdel']=='o'):?>
                                    <tr id="tr<?=$mater['id']?>" data-materid="<?=$mater['id']?>" data-logistid="<?=$mater['logist_id']?>"  data-con="<?=$contract?>">
                                        <td><?=$categoryList[$mater['catid']]?></td>
                                        <td class="color" bgcolor="<?=$mater['status']?>"><?=$mater['designation']?></td>
                                        <td>
                                            <input type="text" class="deliv-input" value="<?=$mater['count']?>" placeholder="не задано" data-pole="count">
                                        </td>
                                        <td style="position: relative">
                                            <input type="text" size="10" class="deliv-input_date" disabled selected data-pole="plan_date" value="<?=$mater['plan_date']=='0000-00-00'?'':preg_replace('/(\d{4})-(\d{2})-(\d{2})/','$3-$2-$1',$mater['plan_date'])?>">
                                        </td>
                                        <!--                            --><?php //if($ri==8):?>
                                        <td>

                                            <label><input type="radio" value="orangered" disabled selected name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'orangered' ? 'checked':'';?>>заказан</label><br>
                                            <label><input type="radio" value="forestgreen" disabled selected name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'forestgreen' ? 'checked':'';?>>привезен</label><br>
                                            <label><input type="radio" value="lavender" disabled selected name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'lavender' ? 'checked':'';?>>отмена</label><br>
                                            <?php if($mater['status'] == 'lavender'):?>
                                            <input type="button" id="bt<?=$mater['id']?>" value="Удалить"  onclick="delMaterial(this.id);">
                                            <?php endif;?>
                                        </td>
                                        <!--                                --><?php //endif;?>
                                    </tr>
                                <?php endif;
                            endforeach;?>
                        <?php endif;?>
                    </table>
                </div>
                <div class="deliv_add" data-otd="o">
                    Добавить позицию
                    <select name="category" id="category">
                        <option value="20" disabled selected>эмаль</option>
                    </select>
                    <input type="text" id="oldi">
                    <input type="button" value="Добавить" onclick="addMaterMalar(this.parentNode)">
                </div>
            </div>
        </section>

    <?php
    $month = date("m", mktime(0,0,0,date('m'),1,date('Y')));
    $year  = date("Y", mktime(0,0,0,date('m'),1,date('Y')));
    $yearnow  = date("Y", mktime(0,0,0,date('m'),1,date('Y')));
    $months = array('','январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
    ?>

    <div id="fon" class="fon"></div>
</div>

<script>
    $(".matdate").each(function(){
        var text = $(this).text();
        if(text=="0000-00-00") $(this).text('');
        else{
            $(this).text(text.replace(/(\d{4})-(\d{2})-(\d{2})/,'$3.$2'));
        }
    });
    var delivinputs = document.getElementsByClassName('deliv-input');
    if(delivinputs){
        var currentval_val = '';
        for(var j=0; j<delivinputs.length; j++){
            delivinputs[j].addEventListener('focus', function(){
                currentval_val = this.value;
            });
            delivinputs[j].addEventListener('change',function(){
                var newval = this.value,
                    idlogist = this.parentNode.parentNode.dataset.logistid,
                    materid = this.parentNode.parentNode.dataset.materid;
                // console.log(materid);
//                        console.log(newval);
                $.ajax({
                    url:'/delivery/ChangeCount',
                    type:'post',
                    data:'idmater='+materid+'&count='+newval,
                    success:function(data){
                        console.log(data);
                        if(!data){
                            location.reload();
                        }
                    }
                });
            });
        }
    }
    </script>
    