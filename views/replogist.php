<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Закупки с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($listin)):?>
            <div class="rep_sms rep_sample">
                <table>
                    <tr>
                        <td></td>
                        <td>Всего на сумму</td>
                        <td><?=$sumin;?>р.</td>
                    </tr>
                    <tr>
                        <th>Дата</th>
                        <th>Куда</th>
                        <th>Адрес</th>
                        <th>Сумма</th>
                        <th>Примечание</th>
                        <th>Водитель</th>
                    </tr>
                    <?php foreach($listin as $onein):?>
                        <tr>
                            <td><?=date('d.m', strtotime($onein['date']));?></td>
                            <td><?=$onein['point'];?></td>
                            <td><?=$onein['address'];?></td>
                            <td class="sum_log"><?=$onein['summ'];?></td>
                            <td><?=$onein['note'];?></td>
                            <td class="drname"><?=$onein['driver']==0?'':$drivers[$onein['driver']];?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td></td>
                        <td>Всего на сумму</td>
                        <td><?=$sumin;?>р.</td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
