<div class="content">
    <div class="aveturnover">

За период с июля 2014 по сегодняшний месяц общий оборот составляет <b><?=$sum;?>р.</b><br>
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
                <td class="sum"><?=$arr[$int-$m-1]['SUM(sum)'];?>р.</td>
                <td><?=$rekl[$int-$m-1]['COUNT(sum)'];?></td>
            </tr>
        <?php endfor; ?>
    </table>
    </div>
</div>