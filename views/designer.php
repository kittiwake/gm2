<div class="content">
    <div class="content_main">
        <div class="column_content" style="width: 100%;">
            <div class="span1 dispan1">
                <p>Заказы в производстве</p>
                <?php foreach($order_in_fabr as $key=>$order):?>
                    <div style="background-color: <?=$order['bgcol']?>">
                        <?=$order['contract'];?>
                    </div>
                    <?php if(array_key_exists($order['oid'],$claims)):?>
                        <?php foreach($claims[$order['oid']] as $oneclaim):?>
                            <?php if($oneclaim['contract']!=$order['contract']):?>
                                <div style="background-color: pink">
                                    <?=$oneclaim['contract'];?>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
            <div class="span2 dispan2">
                <p>Замеры</p>
                <div class="grafik_dis">
                    <?php if(count($sample_new) !=0 ):?>
                        <div>Новопоступившие замеры</div>
                        <table>
                            <tr>
                                <th>Дата выезда</th>
                                <th>№ заказа</th>
                                <th>Адрес</th>
                                <th>Описание</th>
                                <th>Холостой</th>
                                <th></th>
                            </tr>
                            <?php foreach($sample_new as $new):?>
                                <tr id="<?=$new['id']?>">
                                    <td><?=date('d.m', strtotime($new['date_dis']));?></td>
                                    <td ><?=$new['contract']?></td>
                                    <td><?=$new['address']?></td>
                                    <td class="tdnote">
                                        <div class="notedis" id="notes<?=$new['id']?>">
                                            <?=$new['note']?>
                                        </div>
                                        <input type="button" value="Добавить" onclick="addNoteDis(this)">
                                    </td>
                                    <td><?=$new['empty']?>р.</td>
                                    <td>
                                        <input type="hidden" value="<?=$new['sum']?>" id="sum<?=$new['id']?>">
                                        <input type="hidden" value="<?=$new['prepayment']?>" id="pr<?=$new['id']?>">
                                        <input type="hidden" value="<?=$new['render']?>" id="ren<?=$new['id']?>">
                                        <input type="button" value="Принял" onclick="changeStanDisN(this, 'tekuch')">
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    <?php endif;?>
                    <?php if(count($sample_zakl) !=0 ):?>
                        <div>Заключенные договора</div>
                        <table>
                            <tr>
                                <th>Дата выезда</th>
                                <th>№ заказа</th>
                                <th>Адрес</th>
                                <th>Описание</th>
                                <th>Холостой</th>
                                <th></th>
                            </tr>
                            <?php foreach($sample_zakl as $zakl):?>
                                <tr id="<?=$zakl['id']?>">
                                    <td><?=date('d.m', strtotime($zakl['date_dis']));?></td>
                                    <td ><?=$zakl['contract']?></td>
                                    <td><?=$zakl['address']?></td>
                                    <td class="tdnote">
                                        <div class="notedis" id="notes<?=$zakl['id']?>">
                                            <?=$zakl['note']?>
                                        </div>
                                        <input type="button" value="Добавить" onclick="addNoteDis(this)">
                                    </td>
                                    <td><?=$zakl['empty']?>р.</td>
                                    <td>
                                        <input type="hidden" value="<?=$zakl['sum']?>" id="sum<?=$zakl['id']?>">
                                        <input type="hidden" value="<?=$zakl['prepayment']?>" id="pr<?=$zakl['id']?>">
                                        <input type="hidden" value="<?=$zakl['render']?>" id="ren<?=$zakl['id']?>">
                                        <?php if($zakl['render'] == 'nothing' || $zakl['render'] == 'money'):?>
                                            <input type="button" value="Договор сдан" onclick="changeRender(this, 'contract');">
                                        <?php endif;?>
                                        <?php if($zakl['render'] == 'nothing' || $zakl['render'] == 'contract'):?>
                                            <input type="button" value="Деньги сданы" onclick="changeRender(this, 'money');">
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    <?php endif;?>
                    <table>
                        <tr>
                            <th>Дата выезда</th>
                            <th>№ заказа</th>
                            <th>Адрес</th>
                            <th>Описание</th>
                            <th>Холостой</th>
                            <th></th>
                        </tr>
                        <?php foreach($sample_plan as $sample):?>
                            <tr  id="<?=$sample['id']?>">
                                <td><?=date('d.m', strtotime($sample['date_dis']));?></td>
                                <td style="background-color: <?=$sample['render']=='money'?'gold':($sample['render']=='contract'?'tomato':'inherit');?>"><?=$sample['contract']?></td>
                                <td><?=$sample['address']?></td>
                                <td class="tdnote">
                                    <div class="notedis" id="notes<?=$sample['id']?>">
                                        <?=$sample['note']?>
                                    </div>
                                    <input type="button" value="Добавить" onclick="addNoteDis(this)">
                                </td>
                                <td><?=$sample['empty']?>р.</td>
                                <td>
                                    <input type="hidden" value="<?=$sample['sum']?>" id="sum<?=$sample['id']?>">
                                    <input type="hidden" value="<?=$sample['prepayment']?>" id="pr<?=$sample['id']?>">
                                    <input type="hidden" value="<?=$sample['render']?>" id="ren<?=$sample['id']?>">
                                    <input type="button" value="Заключен" onclick="changeStanDisN(this, 'zakluchen')">
                                    <input type="button" value="В архив" onclick="changeStanDisN(this, 'arhiv')">
                                    <input type="button" value="Отказ" onclick="changeStanDisN(this, 'otkaz')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                    <div onclick="showElement('arhiv_table');">Показать архив</div>
                    <div id="arhiv_table" style="display: none;">
                        <table>
                            <tr>
                                <th>Дата выезда</th>
                                <th>№ заказа</th>
                                <th>Адрес</th>
                                <th>Описание</th>
                                <th>Холостой</th>
                                <th></th>
                            </tr>
                            <?php foreach($sample_arhiv as $sample):?>
                                <tr id="<?=$sample['id']?>">
                                    <td><?=date('d.m', strtotime($sample['date_dis']));?></td>
                                    <td style="background-color: <?=$sample['render']=='money'?'gold':($sample['render']=='contract'?'tomato':'inherit');?>"><?=$sample['contract']?></td>
                                    <td><?=$sample['address']?></td>
                                    <td class="tdnote">
                                        <div class="notedis" id="notes<?=$sample['id']?>">
                                            <?=$sample['note']?>
                                        </div>
                                    </td>
                                    <td><?=$sample['empty']?>р.</td>
                                    <td>
                                        <input type="button" value="Восстановить" onclick="changeStanDisN(this, 'tekuch')">
<!--                                        <input type="button" value="Удалить" onclick="delSampleDis(this)">-->
                                        <input type="button" value="Отказ" onclick="changeStanDisN(this, 'otkaz')">
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="span1">
                <p>Заказы закрыты</p>
                <?php foreach($order_last_month as $order_one):?>
                    <div class="dis">
                        <div class="dis_cont">
                            <a href="/designer/closed/<?=$order_one['oid']?>"><?=$order_one['contract'];?></a>
                        </div>
                        <div class="dis_cont">
                            <?=date('d.m',strtotime($order_one['sborka_end_date']));?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<div id="fon"></div>
<div class="form">
    <p>Добавить примечание</p>
    <input type="text" id="note">
    <button>Добавить</button>
</div>
