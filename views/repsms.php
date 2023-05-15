<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                <?php if($type == 'sms') echo 'СМС,';?>
                <?php if($type == 'email') echo 'Почтовые сообщения,';?>
                отправленные с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($smsList)):?>
            <div class="rep_sms">
                <table>
                    <tr>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Заказ</th>
                        <th>Текст СМС</th>
                    </tr>
                    <?php foreach($smsList as $order):?>
                        <tr>
                            <td><?=date('d.m.y', strtotime($order['date_mes']));?></td>
                            <td><?=$order['time_mes'];?></td>
                            <td><?=$order['contract'];?></td>
                            <td><?=$order['mes'];?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <?php endif;?>
        </div>

    </div>
</div>