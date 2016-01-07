<div class="content">
    <div class="col_left">
        <h3>Закрытые заказы</h3>
        (за последние 30 дней)
        <table>
            <tr>
                <th>№заказа</th>
                <th>дата сборки</th>
                <th>сумма заказа</th>
                <th>нал/безнал</th>
            </tr>
            <?php foreach($order_end as $order):?>
            <tr>
                <td><?=$order['contract']?></td>
                <td><?=$order['sborka_end_date']?></td>
                <td><?=$order['sum']?></td>
                <td><?=$order['beznal']?></td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <div class="col_right">
        <h3>Запланированные</h3>
        <table>
            <?php foreach($order_plan as $order):?>
                <tr>
                    <td><?=$order['sborka_date']?></td>
                    <td><?=$order['contract']?></td>
                    <td><?=$order['product']?></td>
                </tr>
                <tr>
                    <td colspan="3"><?=$order['adress']?></td>
                </tr>
                <tr>
                    <td colspan="3"><?=$order['phone']?> <?=$order['name']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
    <div class="col_center">
        <h3>Текущие заказы</h3>
        <table>
            <tr>
                <th>№заказа</th>
                <th>дата</th>
                <th>Адрес</th>
                <th></th>
            </tr>

            <?php foreach($order_current as $order):?>
                <tr>
                    <td><?=$order['contract']?></td>
                    <td><?=$order['sborka_date']?></td>
                    <td><?=$order['adress']?></td>
                    <td><input type="button" value="Закрыть сборку"  id="<?=$order['oid']?>" onclick="closeOrder(this.id)"></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>