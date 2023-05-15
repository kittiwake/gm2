<div class="content">
    <input type="hidden" id="oid3" value="">
    <input type="hidden" id="m_date" value="">

    <div id="fon"></div>
    <div id="duplicate" class="form">
        <form method="post" action="#">
            Выезд на заказ <label></label>
            <input type="hidden" value="" id="oid" name="oid">
            <input type="hidden" value="" id="exdate" name="exdate">
            <p>перенести на</p>
            <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs1(this)" onclick="event.cancelBubble=true;this.select();lcs1(this);">
            <input type="submit" name="submitok" value="Ok">
        </form>
    </div>

    <div class="form" id="form3">
        <?php foreach($disList as $uid=>$name):?>
            <div>
                <label><input type="radio" name="colname" value="<?=$uid;?>"><?=$name;?></label>
            </div>
        <?php endforeach;?>
        <input type="button" value="Сохранить" onclick="changeSample();">
    </div>

    <div class="form" id="change">
        <br>
        <div id="full_note" style="display: none"></div>
        <div id="old_note" style="display: none"></div>
        <div id="note_change"></div>
        <input type="button" value="Сохранить" onclick="changeSampleNote();">
    </div>
    <a name="home"></a>
    <div class="menu_rel">
        <div id="day" class="menu active" ><a href="#<?=strtotime('today');?>">Сегодня</a></div>
        <div id="plan" class="menu passive" onclick="inPlanDis('plan');" style="display: none">График</div>
        <div id="contacts" class="menu passive" onclick="inPlanDis('contacts');">Контакты</div>
        <div id="holiday" class="menu passive" onclick="inPlanDis('holiday');">Выходные</div>
    </div>
    <div style="position: fixed; right: 20px; bottom: 20px;"><a href="#home">Наверх</a></div>
    <div id="in_plan" class="grafik plan_dis">
        <?php foreach($samples as $key=>$sample):
            $date = strtotime($key);?>
            <div class="oneday">
                <a name="<?=$date;?>"></a>
                <div id="date" class="date"><?php echo date('d.m', $date)?>, <?php echo $week[date('w', $date)]?></div>
                <div>
                    <table>
                        <?php foreach($sample as $one_sample):?>
                            <tr bgcolor="<?=$one_sample['str_color'];?>" id="<?=$one_sample['id']?>">
                                <td width="50px" bgcolor="<?=$one_sample['con_color'];?>">
                                    <div class="change contr">
                                        <?=$one_sample['contract']?>
                                    </div>
                                </td>
                                <td  width="50px">
                                    <?php if($one_sample['dis_name']==''){?>
                                        <div><img src="/images/1.jpg" onclick="showFormAddingCol(<?=$one_sample['id'];?>, <?=$date;?>, 5)"></div>
                                    <?php }else{?>
                                        <?=$one_sample['dis_name']?>
                                        <img src="/images/3.jpg" onclick="showFormAddingCol(<?=$one_sample['id'];?>, <?=$date;?>, 5)">
                                    <?php } ?>
                                </td>
                                <td >
                                    <div class="change addr">
                                        <?=$one_sample['address']?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$one_sample['note']?>
                                    </div>
                                    <button onclick="showChangeNote(this)">Изменить</button>
                                </td>
                                <td>холостой <div class="change summ"><?=$one_sample['empty']?></div>р.</td>
                                <td>
                                    <button id="<?=$one_sample['id']?>d<?=$key?>" onclick="showForm(this.id)">Перенести</button>
                                    <button onclick="updateSample(this);" class="show">Редактировать</button>
                                    <button onclick="changeStanDisN(this, 'arhiv')">В архив</button>
                                    <button onclick="delSampleManager(this);">Удалить</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div id="in_contacts" class="plan_dis in_contacts" style="display: none">
        <?php foreach($dList as $dis):?>
            <div class="ass_row">
                <div class="dis_cell"><?=$dis['name']?></div>
                <div class="dis_cell"><?=$dis['tel']?></div>
            </div>
        <?php endforeach;?>
    </div>
    <div  id="in_holiday" class="plan_dis in_holiday" style="display: none">
        <div>
            <select name="dis" id="dis">
                <option value="0"> </option>
                <?php foreach ($disList as $id=>$name):?>
                    <option value="<?=$id?>"><?=$name?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" id="hol_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
            <button onclick="addHolidayDis();">Выходной</button>
            <div id="answerholiday"></div>
            <div class="content_main">
                <?php foreach($holidays as $holiday):?>
                <div class="ass_row" id="hol-<?=$holiday['id']?>">
                    <div class="dis_cell"><?=$holiday['date_dis']?></div>
                    <div class="dis_cell"><?=$holiday['dis_name']?></div>
                    <div class="dis_cell">
                    <button onclick="cancelHolDis(this);">Отменить</button>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>



