<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Отчет о вывозе заказов за период с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($orderList)):?>
                <div class="one_tech">
                    <table>
                        <?php foreach($orderList as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['plan']));?></td>
                                <td <?=$order['style']?>><?=$order['contract']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                            </tr>
                        <?php endforeach;?>
                        <tr>
                            <td colspan="2">Итого заказов</td>
                            <td><?=$count;?></td>
                        </tr>
                        <tr>
                            <td colspan="2">На сумму</td>
                            <td class="rub"><?=$sum;?>р.</td>
                        </tr>
                        <tr>
                            <td colspan="2">Рекламаций в добавок</td>
                            <td><?=$claims;?></td>
                        </tr>
                    </table>
                </div>
            <?php endif;?>
        </div>

    </div>
</div>