<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Распил с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report">
            <?php if(isset($orderList)):?>
            <div class="rep_sms rep_sample">
                <table>
                    <tr>
                        <td></td>
                        <td>Всего материала</td>
                        <td><?=$sum;?> лист.</td>
                    </tr>
                    <tr>
                        <th>Дата</th>
                        <th>Заказ</th>
                        <th>Кол-во</th>
                   </tr>
                    <?php foreach($orderList as $onein):?>
                        <tr>
                            <td><?=date('d.m', strtotime($onein['raspil_date']));?></td>
                            <td><?=$onein['contract'];?></td>
                            <td><?=$onein['noteboss'];?></td>
                            
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td></td>
                        <td>Всего материала</td>
                        <td><?=$sum;?> лист.</td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
 
