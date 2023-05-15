<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Отчет о вывозе рекламаций за период с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($orderList)):?>
                <div class="rep_claim">
                    <table>
                        <tr>
                            <th>Дата</th>
                            <th>Заказ</th>
                            <th>Сумма</th>
                            <th>Дизайнер заказа</th>
                            <th>Конструктор заказа</th>
                            <th>Технолог</th>
                        </tr>
                        <?php foreach($orderList as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['plan']));?></td>
                                <td><?=$order['contract']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                                <td class="name"><?=$order['dis']?></td>
                                <td class="name" <?php if($order['tech'] != $order['techfirst']) echo'style="background: pink;"';?>><?=$order['techfirst']?></td>
                                <td class="name" <?php if($order['tech'] != $order['techfirst']) echo'style="background: pink;"';?>><?=$order['tech']?></td>
                            </tr>
                        <?php endforeach;?>
                        <tr>
                            <td colspan="2">Итого рекламаций</td>
                            <td><?=$count;?></td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="2">На сумму</td>
                            <td class="rub"><?=$sum;?>р.</td>
                            <td colspan="3"></td>
                        </tr>
                    </table>
                </div>
            <?php endif;?>
        </div>

    </div>
</div>