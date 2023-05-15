<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Спецотчет о вывозе заказов за период с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($orderList)):?>
                <div class="rep_np">
                    <table>
                        <?php foreach($orderList as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['plan']));?></td>
                                <td><?=$order['name']?></td>
                                <td><?=$order['product']?></td>
                                <td><?=$order['adress']?></td>
                                <td><?=$order['phone']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php endif;?>
        </div>

    </div>
</div>