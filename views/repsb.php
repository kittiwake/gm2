<div class="content">
    <div class="list_right">
        <ul>
            <?php
           foreach($coll as $key=>$val): ?>
                <li onclick="showCollector(<?=$key?>)"><?=$val?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="info">
        <div class="caption">
            <form method="post" action="#">
                Заказы, закрытые с
                <input type="text" name="begin" value="<?=$dataot?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
                по
                <input type="text" name="end" value="<?=$datapo?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
                <input type="submit" name="submit" value="Показать" id="rep_show">
            </form>
        </div>

        <?php if(isset($begin)&&isset($end)):?>

            <?php foreach($coll as $key=>$val):?>
                <div class="tables" id="div<?=$key?>" >
                    <div class="collector"><?=$val?></div>
                    <div class="table-right">
                        <div class="one-table">
                            <table>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Дата сборки</th>
                                    <th>Сумма заказа</th>
                                    <th>Стоимость сборки</th>
                                </tr>
                                <?php
                                if (!empty($odderList[$key])){
                                    foreach($odderList[$key] as $ass){ ?>
                                        <tr>
                                            <td><?=$ass['contract']?></td>
                                            <td><?=$ass['sborka_end_date']?></td>
                                            <td><?=$ass['sum']?></td>
                                            <td class="rub">
<!--                                                --><?php //if($ass['target'] == 'assembly'):?>
                                                    <?php echo $ass['sum']*0.1;?>р.
<!--                                                --><?php //else:?>
<!--                                                    --><?php //echo $ass['target']=='measure'?'Замер':'Предв. сборка';?>
<!--                                                --><?php //endif;?>
                                            </td>
                                        </tr>
                                    <?php }}?>
                            </table>
                        </div>
                        <div class="one-table">
                            по безналу
                            <table>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Дата сборки</th>
                                    <th>Сумма заказа</th>
                                    <th>Стоимость сборки</th>
                                </tr>
                                <?php
                                if (!empty($beznal[$key])){
                                    foreach($beznal[$key] as $ass){ ?>
                                        <tr>
                                            <td><?=$ass['contract']?></td>
                                            <td><?=$ass['sborka_end_date']?></td>
                                            <td><?=$ass['sum']?></td>
                                            <td class="rub"><?php echo $ass['sum']*0.1;?>р.</td>
                                        </tr>
                                    <?php }}?>
                            </table>
                        </div>
                        <div class="one-table">
                            дилерские
                            <table>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Дата сборки</th>
                                    <th>Сумма заказа</th>
                                    <th>Стоимость сборки</th>
                                </tr>
                                <?php
                                if (!empty($dillerskie[$key])){
                                    foreach($dillerskie[$key] as $ass){ ?>
                                        <tr>
                                            <td><?=$ass['contract']?></td>
                                            <td><?=$ass['sborka_end_date']?></td>
                                            <td><?=$ass['sum']?></td>
                                            <td class="rub"><?php echo $ass['sum']*0.15;?>р.</td>
                                        </tr>
                                    <?php }}?>
                            </table>
                        </div>
                        <div class="one-table">
                            рекламации и доделки
                            <table>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Дата сборки</th>
                                    <th>Сумма рекламации</th>
                                </tr>
                                <?php
                                if (!empty($rekl[$key])){
                                    foreach($rekl[$key] as $ass){ ?>
                                        <tr>
                                            <td><?=$ass['contract']?></td>
                                            <td><?=$ass['sborka_end_date']?></td>
                                            <td class="rub"><?=$ass['sum']?>р.</td>
                                        </tr>
                                    <?php }}?>
                            </table>
                        </div>
                    </div>
                    <div class="table-left">
                        незакрытые заказы
                        <table>
                            <tr>
                                <th>№ заказа</th>
                                <th>Дата сборки</th>
                                <th>Сумма заказа</th>
                            </tr>
                            <?php
                            if (!empty($dontclose[$key])){
                                foreach($dontclose[$key] as $ass){ ?>
                                    <tr>
                                        <td><?=$ass['contract']?></td>
                                        <td><?=$ass['m_date']?></td>
                                        <td class="rub"><?=$ass['sum']?>р.</td>
                                    </tr>
                                <?php }}?>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach;?>

        <?php endif;?>
    </div>
</div>