<div class="content">
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Отчет о просчетах технологов за период с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div style="background-color: #dbf3ff; font-size: 0.9em; padding: 10px 0px">
            На данный момент просчитано <?=$numtech2;?> заказов на сумму <?=$sumtech2;?>р. Сдано <?=$numrekl2;?> рекламаций. <br>
            В планах еще <?=$numtech0;?> заказов на сумму <?=$sumtech0;?>р. Сдать <?=$numrekl0;?> рекламаций
        </div>
        <div id="report">
            <?php if(isset($techend_list)):?>
            <?php foreach($techend_list as $name=>$list):?>
                <div class="one_tech">
                    <div class="name_tech"><?=$name;?></div>
                    <table>
                        <?php foreach($list as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['tech_date']));?></td>
                                <td <?=$order['style']?>><?=$order['contract']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                            </tr>
                    <?php endforeach;?>
                        <tr>
                            <td colspan="2">Итого заказов</td>
                            <td><?=$count[$name];?></td>
                        </tr>
                        <tr>
                            <td colspan="2">На сумму</td>
                            <td class="rub"><?=$sum[$name];?>р.</td>
                        </tr>
                    </table>
                </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>

    </div>
</div>