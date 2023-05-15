<div class="content">
    <div class="navig">
        <div class="nav active_nav" id="first">
            Текущие заказы
        </div>
        <div class="nav passive_nav" id="second">
            Закрытые заказы
        </div>
    </div>
    <div class="content_main">
        <div class="content_orders first_table">
            <table>
                <tr>
                    <th>№заказа</th>
                    <th>дата</th>
                    <th>Адрес</th>
                    <th width="30%">Примечания</th>
<!--                    <th></th>-->
                </tr>

                <?php foreach($mount_plan as $order):?>
                    <tr>
                        <td><?=$order['contract']?></td>
                        <td><?php echo date('d.m', strtotime($order['m_date']));?></td>
                        <td>
                            <b size=4> <a href="tel:+<?=$order['phone'];?>">+<?=$order['phone'];?></a></b>
                            <?=$order['name'];?> <br />
                            <?=$order['adress'];?>
                            <div class="m_note">
                                <?=$order['notes'];?>
                            </div>
                        </td>
                        <td>
                            <ins><em>Стоимость сборки</em></ins> <?=$order['sumcollect'];?>р.<br />
                            <ins><em>Дизайнер</em></ins> <?=$order['designer'];?><br />
                            <ins><em>Технолог</em></ins> <?=$order['technologist'];?><br />
                        </td>
<!--                        <td><input type="button" value="Смотреть" id="--><?//=$order['oid']?><!--" class="cont"></td>-->
                    </tr>
                <?php endforeach;?>
            </table>
            <table>
                <tr>
                    <th>№заказа</th>
                    <th>дата</th>
                    <th>Адрес</th>
                    <th width="30%">Примечания</th>
                </tr>

                <?php foreach($mount_curr as $order):?>
                    <tr>
                        <td><?=$order['contract']?></td>
                        <td><?php echo date('d.m', strtotime($order['m_date']));?></td>
                        <td>
                            <b size=4> <a href="tel:+<?=$order['phone'];?>">+<?=$order['phone'];?></a></b>
                            <?=$order['name'];?><br />
                            <?=$order['adress']?>
                            <div class="m_note">
                                <?=$order['notes'];?>
                            </div>
                        </td>
                        <td>
                            <ins><em>Стоимость сборки</em></ins> <?=$order['sumcollect'];?>р.<br />
                            <ins><em>Дизайнер</em></ins> <?=$order['designer'];?><br />
                            <ins><em>Технолог</em></ins> <?=$order['technologist'];?><br />
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>

        </div>
        <div class="content_orders second_table">
            <table>
                <tr>
                    <th>№заказа</th>
                    <th>когда закрыт</th>
                    <th>сумма заказа</th>
                    <th>нал/безнал</th>
                </tr>
                <?php foreach($mount_end as $order):?>
                    <tr>
                        <td><?=$order['contract']?></td>
                        <td><?php echo date('d.m', strtotime($order['sborka_end_date']));?></td>
                        <td class="rub"><?=$order['sum']?>р.</td>
<!--                        <td class="rub">--><?//=number_format($order['sum'], 2, ',', ' ')?><!--</td>-->
                        <td><?=$order['beznal']?></td>
                    </tr>
                <?php endforeach;?>
            </table>

        </div>
    </div>
</div>