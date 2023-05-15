<div class="content">
    <div class="assembly">
        <div class="ass_table">
            <?php foreach ($sborki as $key=>$val):?>
            <div class="ass_row">
                <div class="ass_date"><?=$key?></div>
                <div class="ass_day">
                    <div class="assd_table">
                        <?php foreach ($val as $sborka):?>
                        <div class="assd_row">
                            <div class="ass_con"><?=$sborka['con']?></div>
                            <div class="ass_con"><?=$sborka['coll']?></div>
                            <div class="ass_con" id="div<?=$sborka['oid']?>" style="width: 50px; padding-right: 40px;">
                                <input type="button" id="<?=$sborka['oid']?>" value="Закрыть заказ" onclick="closeOrder(this.id,<?=$ri?>)">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="to_plan">
        <form method="post" action="#">

            <input type="hidden" name="numord" value="<?=$count?>">

            <div class="pl_table">
                <div class="submit">
                    <input type="submit" name="submit" value="Сохранить изменения">
                </div>
                <? $i = 0;
                foreach($plansb as $planovaya): ?>
                    <div class="pl_row">
                        <div class="pl_con" <?php if($planovaya['otgruz']==2) echo 'style="background-color: #FFFF99"';?>>
                            <input type="hidden" value="<?=$planovaya['oid']?>" name="c<?=$i?>">
                            <?=$planovaya['con']?>
                        </div>
                        <div class="pl_con" id="divd<?=$planovaya['oid']?>">
                            <?php if($planovaya['sbdate'] == '0000-00-00'){?>
                                <input type="text" name="d<?=$planovaya['oid']?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                            <?php }else{?>
                                <p id="pd<?=$planovaya['oid']?>" onclick="rewrite(this.id)"><?=$planovaya['sbdate']?></p>
                            <?php }?>
                        </div>
                        <div class="pl_con" id="divsb<?=$planovaya['oid']?>">
                            <?php if($planovaya['coll'] == '0'){?>
                                <select name="sb<?=$planovaya['oid']?>">
                                    <option value="0"> </option>
                                    <?php foreach ($sborList as $collector):?>
                                        <option value="<?=$collector['uid']?>"><?=$collector['name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php }else{?>
                                <p id="psb<?=$planovaya['oid']?>" onclick="rewritesb(this.id)"><?=$planovaya['coll']?></p>

                            <?php }?>

                        </div>
                    </div>
                <?php $i++;
                endforeach; ?>
            </div>
        </form>
    </div>
</div>