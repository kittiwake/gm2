<div class="content">
    <div class="claim">
        <table>
            <tr>
                <th>заказ</th>
                <th>технолог</th>
                <th>сумма</th>
                <th></th>
            </tr>
            <?php foreach($orderList as $order) :?>
                <tr>
                    <td class="cont"  id="<?=$order['oid'];?>"><?=$order['contract'];?></td>
                    <td class="tech"><?=$order['tech'];?></td>
                    <td class="sum_order" id="sum-<?=$order['oid'];?>"><?=$order['sum'];?></td>
                    <td><button id="b<?=$order['oid'];?>" class="but" onclick="showChangeSum(this.id);">Изменить</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>