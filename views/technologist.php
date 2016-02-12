<div class="content">
    <div class="content_main">
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
                                    <div class="tech_cell"><input type="button" id="<?=$one['oid'];?>" value="Сдать в работу" onclick="closeTech(this.id);"></div>
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
                                        <div class="tech_cell"><input type="button" id="<?=$one['oid'];?>" value="Сдать в работу" onclick="closeTech(this.id);"></div>
                                    </div>
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
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
</div>