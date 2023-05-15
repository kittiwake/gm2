<div class="content">
    <div class="content_main">
        <div class="column_content" style="width: 100%;">
        <div class="span1">
            <p>Просчитанные заказы</p>
            <?php foreach($order_end as $key=>$order_month):?>
                <div class="one_month">
                    <div class="name_month"><?=$key;?></div>
                    <div >заказов <?=$count_order[$key];?></div>
                    <div >на сумму <?=$sum_order[$key];?></div>
                <?php foreach($order_month as $order_one):?>
                    <div>
                        <?=$order_one['contract'];?>
                    </div>
                <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
        <div class="span2">
            <p>План работы</p>
            <div class="grafik_tech">
                <table>
                    <tr>
                        <th>Дата сдачи</th>
                        <th>№ заказа</th>
                    </tr>
                    <tr>
                        <td>Просрочено</td>
                        <td>
                            <?php foreach($order_overdue as $one):?>
                                <div>
                                    <div class="tech_cell"><?=$one['contract']?></div>
                                    <div class="tech_cell"><a href="http://192.168.0.99/ship/excel/NewFile?con=<?=$one['contract'];?>&oid=<?=$one['oid'];?>"><input type="button" id="<?=$one['oid'];?>" value="Сдать в работу"></a></div>
                                </div>
                            <?php endforeach;?>
                        </td>
                    </tr>
                    <?php foreach($order_current as $date=>$arr_day):?>
                        <tr>
                            <td><?=date('d.m', strtotime($date));?></td>
                            <td>
                                <?php foreach($arr_day as $one):?>
                                    <div>
                                        <div class="tech_cell"><?=$one['contract'];?></div>
                                        <div class="tech_cell"><a href="http://192.168.0.99/ship/excel/NewFile?con=<?=$one['contract'];?>&oid=<?=$one['oid'];?>"><input type="button" id="<?=$one['oid'];?>" value="Сдать в работу"></a></div>
                                    </div>
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <div>
                <h4><br/><br/>Для внесения изменений в уже внесенные файлы перейдите на страничку: <a href="http://192.168.0.99/ship/excel/NewFile?con=">http://192.168.0.99/ship/excel/NewFile?con=ДОГОВОР</a>, исправьте номер договора в адресной строке и залейте файлы заново.
                </h4>
                <h5>Ошибку "Notice: Undefined index: oid" просто игнорируйте</h5>
            </div>
        </div>
        <div class="span1">
            <p>Сданы рекламации</p>
            <?php foreach($claim_end as $key=>$claim_month):?>
                <div class="one_month">
                    <div class="name_month"><?=$key;?></div>
                    <div >рекламаций <?=$count_claim[$key];?></div>
                    <div >на сумму <?=$sum_claim[$key];?></div>
                    <?php foreach($claim_month as $claim_one):?>
                        <div>
                            <?=$claim_one['contract'];?>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
        </div>
        <div class="phone_list">
            <a onclick="showList('col_list')">Сборщики</a> ||
            <a onclick="showList('dis_list')">Дизайнеры</a> ||
            <a onclick="showList('close')">Свернуть</a>
            <div class="lists" id="col_list">
                <table>
                    <?php foreach($colList as $worker):?>
                        <tr>
                            <td><?=$worker['name']?></td>
                            <td><?=$worker['tel']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <div class="lists" id="dis_list">
                <table>
                    <?php foreach($disList as $worker):?>
                        <tr>
                            <td><?=$worker['name']?></td>
                            <td><?=$worker['tel']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <div class="lists" id="close"></div>
        </div>
    </div>
</div>