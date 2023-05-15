<div class="content">
    <div class="content_ceh">
        <?php foreach($etaps as $etap=>$etap_name):?>
            <div class="span3">
                <div class="span_zagol"><?=$etap_name?></div>
                <?php foreach($orders[$etap] as $order):?>
                    <?php
                    $today = date('Y-m-d');
                    $bgc = '#F0FFFF';
                    if($order[$arr_stan[$etap]]==2) $bgc = '#00b050';
                    if ($order[$arr_stan[$etap]]==0 && $order[$arr_stan_date[$etap]]!=$today) $bgc = '#FF8080';
                    ?>
                    <div class="one_from_list" style="background-color: <?=$bgc;?>">
                        <?=$order['contract']?>
                        <div class="mater">
                            <?=$order['mater']?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
        <div id="size"></div>
    </div>
</div>
