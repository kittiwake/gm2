<div class="content">
    <div id="fon"></div>
    <div id="form">
        <form action="duplicate" method="post">
            Сборку заказа № <label></label>
            <input type="hidden" value="" id="oid" name="oid">
            <input type="hidden" value="" id="exdate" name="exdate">
            <p><label><input type="radio" name="dubl" value="0">перенести</label></p>
            <p><label><input type="radio" name="dubl" value="1">продлить</label></p>
            <p>на</p>
            <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);">
            <input type="submit" name="submitok" value="Ok">
        </form>
    </div>
    <div class="planirovanie">
        <div class="ass_row">
            <div class="ass_cell active" id="plan" onclick="inPlanirovanie('plan');">плановые</div>
            <div class="ass_cell passive" id="mount" onclick="inPlanirovanie('mount')">незакрытые сборки</div>
            <div class="ass_cell passive" id="holiday" onclick="inPlanirovanie('holiday')">выходные</div>
        </div>
        <div class="plan_ass" id="in_plan">

            <table>
                <tr>
                    <td>№заказа</td>
                    <td>Дата</td>
                    <td>Сборщик</td>
                </tr>
                <?php foreach($in_plan as $key=>$moun): ?>
                    <tr>
                        <td><?=$moun['con']?></td>
                        <td id="datecoll<?=$key?>">
                            <input type="text" value="" size="8" id="d<?=$key?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);$('#bt<?=$key?>').show();">
                        </td>
                        <td id="namecoll<?=$key?>">
                            <?php if(isset($moun['sbname'])){
                                echo $moun['sbname'];
                            }else{
                                ?>
                                <select id="sb<?=$key?>" onchange="$('#bt<?=$key?>').show();">
                                    <option value="0" selected> </option>
                                    <?php foreach ($sborList as $keysb=>$collector):?>
                                        <option value="<?=$keysb?>"><?=$collector?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php } ?>
                            <input type="button" id="bt<?=$key?>" value="Ok" style="display: none" onclick="saveMounting(this.id,0);">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="plan_ass" id="in_mount">
            <table>
                <tr>
                    <td>№заказа</td>
                    <td>Дата</td>
                </tr>
                <?php foreach($in_process as $key=>$moun): ?>
                    <tr id="str<?=$key?>">
                        <td><?=$moun['con']?></td>
                        <td>
                            <input type="text"  id="d<?=$key?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);$('#bt<?=$key?>').show();">
                            <input type="hidden" id="sb<?=$key?>" value="<?=$moun['sbname']?>">
                            <input type="button" id="bt<?=$key?>" value="Ok" style="display: none" onclick="saveMounting(this.id, 1);">
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <div class="plan_ass" id="in_holiday">
            <?php foreach ($sborList as $keysb=>$collector):?>
                <div id="hol<?=$keysb?>">
                    <?=$collector?>
                    <input type="text" id="hd<?=$keysb?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);">
                    <input type="button" value="Ok" id="hb<?=$keysb?>" onclick="addHoliday(this.id);">
                </div>
            <?php endforeach; ?>
            <br>
            <br>
            <div id="list_holiday">
                <?php foreach($free as $one):?>
                    <div id="<?=$one['uid']?>f<?=$one['date']?>">
                        <?=$one['cpdate']?>  <?=$one['name']?>
                        <input type="button" value="Отменить" onclick="cancelHoliday(this.parentNode.id);">
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="grafik">
        <?php foreach($ass_list as $key=>$mount):
            $date = strtotime($key);?>
            <div class="oneday">
                <div id="date"><?php echo date('d.m', $date)?></div>
                <div class="coll_list">
                    <div class="row">
                        <?php foreach($sborList as $uid=>$collector):?>

                            <div class="cel"
                                <?php if(in_array($uid, $coll_hol[$key])):?>
                                    style="background-color: rosybrown"
                                <?php endif;?>

                                ><?=$collector?></div>

                        <?php endforeach;?>
                    </div>
                </div>
                <div>
                    <table>
                        <?php foreach($mount as $moun):?>
                        <tr>
                            <td>
                                <div id="<?=$moun['oid']?>d<?=$key?>" onclick="showForm(this.id);">
                                    <?=$moun['con']?>
                                </div>
                            </td>
                            <td><?=$moun['adress']?></td>
                            <td>
                                <div id="name<?=$moun['oid']?>d<?=$key?>" onclick="$('#sd<?=$moun['oid']?>d<?=$key?>').show();$(this).hide();">
                                    <?php echo $moun['sbname']=='' ? '&nbsp;' : $moun['sbname']; ?>
                                </div>
                                <div id="sd<?=$moun['oid']?>d<?=$key?>" style="display: none">
                                    <select id="sc<?=$moun['oid']?>d<?=$key?>" onchange="changeColl(this.id);">
                                        <option value="0" selected> </option>
                                        <?php foreach ($sborList as $keysb=>$collector){?>
                                            <?php if(!in_array($keysb, $coll_hol[$key])):?>
                                            <option value="<?=$keysb?>"><?=$collector?></option>
                                            <?php endif;?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <td id="div<?=$moun['oid']?>">
                                <?php if($date<=strtotime('today')):?>
                                    <input type="button" id="<?=$moun['oid']?>" value="Закрыть заказ" onclick="closeOrder(this.id)">
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>