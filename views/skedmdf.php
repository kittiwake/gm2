<div class="content">
    <div class="content_ceh">
        <?php foreach($etaps as $etap=>$etap_name):?>
            <div class="span3 <?if($ri==43) echo ('emal');?>">
                <div class="span_zagol"><?=$etap_name?></div>
                <div class="plceh_list2">
                    <?php foreach($orders[$etap] as $order):?>
                        <?php
                        $today = date('Y-m-d');
                        $bgc = '#F0FFFF';
                        if($order[$arr_stan[$etap]]==1) $bgc = '#00b050';
                        if ($order[$arr_stan[$etap]]==0 && $order[$arr_stan_date[$etap]]!=$today) $bgc = '#FF8080';
                        ?>
                        <div class="one_from_list" style="background-color: <?=$bgc;?>" id="<?=$arr_stan[$etap].'-'.$order['id']?>" data-stan="<?=$order[$arr_stan[$etap]];?>">
                            <?=$order['contract']?>
                            <div class="mater">
                                <?=$order['mater']?>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach;?>
        <div id="size"></div>
    </div>
    <div class="plceh_graf btn">
        <button id="stanbtn" onclick="changeMdfCehStan();" disabled>Отметить готовность</button>
    </div>
        <div id="fon" class="planceh"></div>
        <div class="form" id="gotovnost">
            nen xnj-nj
        </div>
    
</div>
