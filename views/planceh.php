<div class="content">
    <input type="hidden" id="pole">
    <div class="plc_date">
        <a href="/<?=SITE_DIR?>/plan/ceh/<?=$date-60*60*24;?>"><span><< </span></a>
        <span id="date"><?=$userdate;?></span>
        <a href="/<?=SITE_DIR?>/plan/ceh/<?=$date+60*60*24;?>"><span> >></span></a>
    </div>
    <div class="plc_graf">
        <div class="plc_content_main">
            <?php for($i=0; $i<2; $i++):?>
            <div class="plc_table">
                <?php foreach($shablon[$i] as $key=>$val):?>
                    <div class="span3" id="<?=$key;?>">
                        <div class="span_zagol"><?=$val;?></div>
                        <div class="splc_list">
                            <?php if(strtotime($userdate) == strtotime('today')):?>
                                <?php foreach($graf_y[$arr_stan_date[$key]] as $oid => $arrord):?>
                                    <div style="background-color: hotpink">
                                        <?=$arrord['contract']?>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                            <?php foreach($graf[$arr_stan_date[$key]] as $oid => $arrord):?>
                                <div>
                                    <?=$arrord['contract']?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <?php endfor;?>
        </div>
    </div>
    <div class="plc_list">
        <?php for($d=0; $d<8; $d++):?>
            <div class="plc_oned">
                <div><?=date('d.m', strtotime('today')+$d*24*3600)?></div>
                <?php if(isset($orders[$d])):?>
                    <?php foreach($orders[$d] as $key=>$arr):?>
                        <div class="for_plan" id="<?=$arr['oid'].'-'.$stan_gotov[$arr['oid']]['stan'];?>"><?=$arr['con'];?></div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        <?php endfor;?>
        <div class="plc_oned"> еще</div>
    </div>
</div>