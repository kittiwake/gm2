<div class="content">
    <div class="aveturnover">

За период с июля 2014 по сегодняшний месяц общий оборот составляет <b class="rub"><?=$allsum;?>р.</b><br>
    Средний оборот в месяц <b><?=$sredn;?>р.</b><br>
    </div>
    <div class="turnover">
    <br>
    За последние 12 месяцев:
    <table>
        <tr>
            <th>месяц</th>
            <th>всего заказов</th>
            <th>на сумму</th>
            <th>рекламаций и довозов в добавок</th>
        </tr>
        <?php for($m=0; $m<12; $m++):?>
            <tr>
                <td><?=date('m.Y', strtotime('today -'.$m.' month'));?></td>
                <td><?=$arr[$int-$m-1]['COUNT(sum)'];?></td>
                <td class="sum rub"><?=$arr[$int-$m-1]['SUM(sum)'];?>р.</td>
                <td><?=$rekl[$int-$m-1]['COUNT(sum)'];?></td>
            </tr>
        <?php endfor; ?>
    </table>
    </div>
    <div class="content_main">
        <div class="rep_form">
            <form method="post">
                Оборот за период с
                <input type="text" name="dataot" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                по
                <input type="text" name="datapo" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                <input type='submit' name="submit" value="Ok" />
            </form>
        </div>
        <div id="report" class="columns">
            <?php if(isset($orderList)):?>
                <div class="one_tech columns-two">
                    <table>
                        <tr>
                            <th colspan="2">Всего заказов</th>
                            <th><?=$count;?></th>
                        </tr>
                        <tr>
                            <th colspan="2">На сумму</th>
                            <th class="rub"><?=$sum;?>р.</th>
                        </tr>
                        <tr>
                            <th colspan="2">Рекламаций на сумму</th>
                            <th class="rub"><?=$claimsum;?>р. (<?=isset($pers)?$pers.'%':''?>)</th>
                        </tr>
                        <?php foreach($orderList as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['plan']));?></td>
                                <td <?=$order['style']?>><?=$order['contract']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php endif;?>
            <?php if(isset($dillList)):?>
                <div class="one_tech columns-two">
                    <table>
                        <tr>
                            <th colspan="2">Всего заказов</th>
                            <th><?=$countdil;?></th>
                        </tr>
                        <tr>
                            <th colspan="2">На сумму</th>
                            <th class="rub"><?=$sumdil;?>р.</th>
                        </tr>
                        <tr>
                            <th colspan="2">Рекламаций на сумму</th>
                            <th class="rub"><?=$claimsumdil;?>р. (<?=isset($persdil)?$persdil.'%':''?>)</th>
                        </tr>
                        <?php foreach($dillList as $order):?>
                            <tr>
                                <td><?=date('d.m.y', strtotime($order['plan']));?></td>
                                <td <?=$order['style']?>><?=$order['contract']?></td>
                                <td class="rub"><?=$order['sum']?>р.</td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php endif;?>
        </div>

    </div>

</div>