<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Замеры с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <select name="disigner">
                    <option value="">все</option>
                    <?php foreach($disval as $disiid=>$disname):?>
                        <option value="<?=$disiid?>" <?=$disid==$disiid?'selected':''?>><?=$disname?></option>
                    <?php endforeach;?>
                </select>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($list)):?>
                <div class="statistic">
                    <table>
                        <tr>
                            <th>Дизайнер</th>
                            <th>выездов</th>
                            <th>заключенных</th>
                            <th>отказов</th>
                            <th>сумма заключенных</th>
                            <th>сумма предоплат</th>
                            <th>сумма остатков</th>
                        </tr>
                        <?php foreach($statist as $uid=>$onedis):?>
                        <tr>
                            <td><?=$dis[$uid]?></td>
                            <td><?=$onedis['vyezd']?></td>
                            <td><?=$onedis['zakl']?></td>
                            <td><?=$onedis['otkaz']?></td>
                            <td><?=$onedis['summ']?></td>
                            <td><?=$onedis['prep']?></td>
                            <td><?=$onedis['ost']?></td>
                        </tr>
                        <?endforeach;?>
                        <tr>
                            <td>Итого</td>
                            <td><?=$itogo['vyezd']?></td>
                            <td><?=$itogo['zakl']?></td>
                            <td><?=$itogo['otkaz']?></td>
                            <td><?=$itogo['summ']?></td>
                            <td><?=$itogo['prep']?></td>
                            <td><?=$itogo['ost']?></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div style="background-color: palegreen" class="uslobozn">Все сдано</div>
                    <div style="background-color: #808080" class="uslobozn">Удален</div>
                    <div style="background-color: #fad5aa" class="uslobozn">В архиве</div>
                    <div style="background-color: honeydew" class="uslobozn">В обработке</div>
                    <div style="background-color: mediumvioletred" class="uslobozn">Отказ</div>
                </div>
                <div class="rep_sms rep_sample">
                    <table>
                        <tr>
                            <th>Дата</th>
                            <th>№ заказа</th>
                            <th>Адрес</th>
                            <th>Дизайнер</th>
<!--                            <th>Заключен</th>-->
                            <th>Сумма</th>
                            <th>Предоплата</th>
                            <th>Доплата</th>
                            <th>Комментарий</th>
                        </tr>
                        <?php foreach($list as $sample):
                            if(($disid!='' && $sample['dis']==$disid) || $disid==''):?>
                            <tr <?=$sample['render'] == 'all'?'bgcolor="Palegreen"':($sample['stan'] == 'delete'?'bgcolor="#808080"':($sample['stan'] == 'arhiv'?'bgcolor="#fad5aa"':($sample['stan'] == 'otkaz'?'bgcolor="mediumvioletred"':'')));?>>
                                <td><?=date('d.m', strtotime($sample['date_dis']));?></td>
                                <td <?=$sample['render'] == 'contract'?'bgcolor="#daa520"':'';?>><?=$sample['contract'];?></td>
                                <td><?=$sample['address'];?></td>
                                <td><?=isset($dis[$sample['dis']])?$dis[$sample['dis']]:'';?></td>
<!--                                <td>--><?//=$sample['stan']=='zakluchen'?'да':'нет';?><!--</td>-->
                                <td class="rub"><?=$sample['sum'];?>р.
                                <?php if($sample['beznal'] == 1){
                                    echo '<img class="rad" src="/images/bank.jpg">';
                                }?>
                                </td>
                                <td class="rub" <?=$sample['render'] == 'money'?'bgcolor="#daa520"':'';?>><?=$sample['prepayment'];?>р.</td>
                                <td class="rub"><?=($sample['sum']-$sample['prepayment']);?>р.</td>
                                <td><?=$sample['note'];?></td>
                            </tr>
                        <?php endif;endforeach;?>
                    </table>
                </div>
            <?php endif;?>
        </div>

    </div>
</div>