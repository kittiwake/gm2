<div class="content">
    <div class="content_main">
        <div id="report" class="rep_sms">
            <table>
                <tr>
                    <th>Заказ</th>
                    <th style="width: 14%;">дата</th>
                    <th style="width: 14%;">срок</th>
                    <th style="width: 14%;">Сумма</th>
                    <th style="width: 22%;">Дизайнер</th>
                    <th style="width: 22%;">Технолог</th>
                </tr>
                <?php foreach($orders as $order):?>
                <tr data-oid="<?=$order['id']?>">
                    <td>
                        <a href='/order/index/<?=$order['id']?>'>
                            <?=$order['contract']?>
                        </a>
                    </td>
                    <td><?=$order['contract_date']?></td>
                    <td><?=$order['term']?></td>
                    <td><?=$order['sum']?></td>
                    <td><?=$order['designer']==0?'':$disList[$order['designer']]?></td>
                    <td><?=$order['technologist']==0?'':$techList[$order['technologist']]?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    
</div>
