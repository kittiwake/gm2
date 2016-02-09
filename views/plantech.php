<div class="content">
    <div id="korzina"></div>
    <div id="korzina2"></div>
    <div class="planirovanie">
        <table>
            <tr>
                <th>заказ</th>
                <th>сумма</th>
                <th>срок</th>
                <th>дизайнер</th>
            </tr>
            <?php foreach($no_appoint as $order):?>
                <tr>
                    <td id="td<?=$order['oid'];?>">
                        <div class="oder_drag" id="<?=$order['oid'];?>">
                            <?=$order['contract'];?>
                        </div>
                    </td>
                    <td><?=$order['sum'];?></td>
                    <td><?=date('d.m', strtotime($order['term']));?></td>
                    <td><?=array_key_exists($order['designer'],$disList)?$disList[$order['designer']]:'';?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>

    <div class="grafik">
        <div class="tech_table">
            <div class="day_row">
                <div class="nametech tech_date">
                    Дата
                </div>
                <?php foreach($techList as $techone): ?>
                    <div class="nametech">
                        <?=$techone['name']?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php for($d=0; $d<15; $d++):
                $yyyymmdd = date('Y-m-d', strtotime('today + '.$d.' days - 1 day'));
                ?>
                <div class="day_row">
                    <div class="tech_date tech_cell">
                        <?=date('d.m', strtotime('today + '.$d.' days - 1 day'));?>
                    </div>
                    <?php foreach($techList as $techone): ?>
                        <div class="tech_cell" id="<?=$techone['uid'];?>-<?=$yyyymmdd?>">
                            <?php if(array_key_exists($techone['uid'].'-'.$yyyymmdd,$no_reckoning)): ?>
                                <?php foreach($no_reckoning[$techone['uid'].'-'.$yyyymmdd] as $oid=>$contract): ?>
                                    <div class="oder_drag_gr" id="<?=$oid;?>">
                                        <?=$contract;?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>