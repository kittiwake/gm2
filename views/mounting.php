<div class="content">
    <input type="hidden" id="oid3" value="">
    <input type="hidden" id="m_date" value="">

    <div id="fon"></div>
    <div id="change_target"></div>
    <div id="duplicate" class="form">
        <form method="post" action="#">
            Сборку заказа № <label></label>
            <input type="hidden" value="" id="oid" name="oid">
            <input type="hidden" value="" id="exdate" name="exdate">
            <p><label><input type="radio" name="dubl" value="0">перенести</label></p>
            <p><label><input type="radio" name="dubl" value="1">продлить</label></p>
            <p>на</p>
            <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs1(this)" onclick="event.cancelBubble=true;this.select();lcs1(this);">
            <input type="submit" name="submitok" value="Ok">
        </form>
    </div>
    <div id="form2" class="form">
        <div id="notes">

        </div>
        <br>
        <br>
        <br>
        <div id="addmount">
            <input type="text" id="dateofmount" onfocus="this.select();lcs1(this)" onclick="event.cancelBubble=true;this.select();lcs1(this);">
            <br>
            <label><input type="radio" name="target" value="assembly" checked> Сборка</label>
            <br>
            <label><input type="radio" name="target" value="measure"> Замер</label>
            <br>
            <label><input type="radio" name="target" value="previously"> Шаблон</label>
            <br>
            <input type="button" value="Назначить" onclick="saveMounting(<?=$ri?>);">
        </div>
    </div>
    <div class="form" id="form3">
<!--        выходных сборщиков удаляет скрипт js-->
        <?php foreach($sborList as $uid=>$name):?>
            <div class="list_user" id="us<?=$uid;?>">
                <label><input type="radio" name="colname" value="<?=$uid;?>"><?=$name;?></label>
            </div>
        <?php endforeach;?>
        <input type="button" value="Добавить" onclick="addMount();">
    </div>
    <div class="planirovanie">
        <div class="ass_row">
            <div class="ass_cell active" id="plan" onclick="inPlanirovanie('plan');">плановые</div>
            <div class="ass_cell passive" id="holiday" onclick="inPlanirovanie('holiday')">выходные</div>
        </div>
        <div class="plan_ass" id="in_plan">
            <?php foreach($in_plan as $key=>$moun): ?>
                <div onclick="showFormAddingMount(<?=$key;?>)" style="background-color: <?=$moun['color']?>"><?=$moun['con']?></div>
            <?php endforeach;?>
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
                <?php if($date>=strtotime('today')):?>
                    <div class="free" id="free-<?=$date;?>">
                        Выходные
                        <?php foreach($sborList as $uid=>$name):?>
                            <div class="list_free_user" id="free<?=$uid;?>-<?=$date?>" style="display: none">
                                <?=$name;?>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
                <div class="table">
                    <div class="date" id="date-<?=$date;?>"><?php echo date('d.m', $date)?>, <?php echo $week[date('w', $date)]?></div>
                    <div>
                        <table>
                            <?php foreach($mount as $moun):?>
                                <tr>
                                    <td width="50px">
                                        <div id="<?=$moun['oid']?>d<?=$key?>" onclick="showForm(this.id);">
                                            <?=$moun['con']?>
                                        </div>
                                    </td>
                                    <td id="<?=$moun['oid']?>td<?=$key?>" width="30px" onclick="changeTarget(this);">
                                        <?php if($moun['target'] != 'assembly'):?>
                                            <?php echo $moun['target']=='measure'?'Замер':'Шаблон'?>
                                        <?php else:?>
                                            <?=$moun['sum']?>р.
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?=$moun['adress']?>
                                        <div class="m_note">
                                            <?=$moun['m_note']?>
                                        </div>
                                        <button onclick="addMountNote(this,'sta')">Добавить примечание</button>
                                        <div style="display: none">
                                            <textarea rows="2" cols="45"></textarea>
                                            <button onclick="addMountNote(this,'add')">Cохранить</button>
                                        </div>
                                    </td>
                                    <td  width="50px">
                                        <!--               <div id="name<?=$moun['oid']?>d<?=$key?>" onclick="$('#sd<?=$moun['oid']?>d<?=$key?>').show();$(this).hide();">
                                    <?php echo $moun['sbname']=='' ? '&nbsp;' : $moun['sbname']; ?>
                                </div> -->
                                        <?php foreach($moun['sbname'] as $uid=>$collector):?>
                                            <div>
                                                <?=$collector;?>
                                                <img src="/images/0.jpg" onclick="delCol(<?=$moun['oid'];?>,<?=$uid;?>,<?=$date?>);">
                                            </div>
                                        <?php endforeach;?>
                                        <div><img src="/images/1.jpg" onclick="showFormAddingCol(<?=$moun['oid'];?>, <?=$date;?>, 17)"></div>
                                    </td>
                                    <td id="div<?=$moun['oid']?>" width="50px">
                                        <?php if($date<=strtotime('today') && $moun['target'] == 'assembly'):?>
                                            <input type="button" id="<?=$moun['oid']?>" value="Закрыть заказ" onclick="closeOrder(this.id,<?=$ri?>)">
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>



