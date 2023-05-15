<div class="content">
    <div id="fon"></div>
    <div id="form" class="form">
        Перенести вывоз заказа № <label></label>
        <p>на</p>
        <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);">
        <input type="button" id="submitok" value="Ok">
    </div>

    <div id="formSms">
        <form method="post" action="">
            <input type="hidden" value="<?=$oid?>" name="oid">
            Телефон<br/><input name="phone" value="<?=$order['phone'];?>" pattern="7[0-9]{10}" required placeholder="7YYYXXXXXXX"><br/><br/>

            Тема <br><select name="tema" id="tema" onChange="getTextMsg();">
                <option > </option>
                <?php foreach($sample as $key=>$text):?>
                    <option value="<?=$key;?>"><?=$text['subject_sms'];?></option>
                <?php endforeach;?>
            </select>

            <br/> <br/>
            Сообщение<br/><textarea name="message" id="message" rows="6" cols="40"></textarea><br/><br/>
            <input type="submit" name="sendsms" value="Отправить">
        </form>
    </div>
    <div id="formnewsum">
        Введите новую сумму
        <input type="text" id="newsum">р.
        <input type="button" value="Ok" id="changesumm">
    </div>
    <?php foreach($sample as $key=>$text):?>
        <input type="hidden" id="smp-<?=$key;?>" value="<?=$text['text_sms'];?>">
    <?php endforeach;?>

    <?php if(!empty($errorsms)):?>
        <div id="answersms">
            <?php foreach($errorsms as $error):?>
                <?=$error;?>
            <?php endforeach;?>
        </div>
    <?php endif;?>

    <div class="stanzak">
        <div class="odplandate" id="odplandate" onclick="showFormTransfer();">
            <?=date ("d.m", strtotime($stan['plan']));?>
        </div>
        <table border="0" cellspacing="8">
            <?php for ($w=0; $w<count($zagol); $w++):?>
                <tr>
                    <td align="right"><?=$zagol[$w];?></td>

                    <?php
                    if ($stan[$db[$w]] == 0) $col = '#CCFFFF';
                    if ($stan[$db[$w]] == 1) $col = '#666666';
                    if ($stan[$db[$w]] == 2) $col = '#33bb00';

                    if ($w == 0) $class = "tech";
                    else $class = "stan";
                    ?>



                    <td>
                        <div id="<?=$oid;?>-<?=$w;?>-<?=$stan[$db[$w]];?>" style="background: <?=$col;?>; width:40px;" class="<?=$class;?>">&nbsp;</div>
                    </td>
                </tr>
            <?php endfor; ?>
        </table>
    </div>
    <div id="od">
        <h2>Договор № <strong id="zakaz"><?=$order['contract'];?></strong> от <?php echo date ("d.m.Y",strtotime($order['contract_date']));?>    </h2>
        <input type="hidden" id="orderid" value="<?=$oid;?>">
        <input type="hidden" id="olddate" value="<?=$stan['plan'];?>">
        <div class="delete"
            <?php if($ri != 4){echo'style="display: none;"';}?>
            >Удалить</div>
        <div class="right">
            <div class="oder">
                <h3>О заказе</h3>
                <ins><em>Изделие</em></ins> <?=$order['product'];?><br />
                <br />
                <ins><em>Сумма договора</em></ins> <span><?=$order['sum'];?>р.</span>
                <?php if($ri == 2):?>
                    <input type="button" value="изменить"  onclick="showFormnewsum();">
                <?php endif;?>
                <br />
                <br />
                <ins><em>Срок договора</em></ins> <?=date("d.m.Y", strtotime($order['term']));?><br />

            </div>
            <div class="farm">
                <h3>В производство</h3>
                <ins><em>Дизайнер</em></ins> <?=$dis;?><br />
                <br />
                <ins><em>Технолог</em></ins> <?=$tech;?><br />
                <br />
            </div>
        </div>
        <div class="left">
            <div class="oderer">
                <h3>О заказчике</h3>
                <?=$order['name'];?><br />
                <br />
                <?=$order['adress'];?><br />
                <br /><br />
                <ins><em>Номер телефона <br />для отправки СМС__</em></ins>
                <b size=4> <?=$order['phone'];?></b>
                <?php if ($ri == 4 || $ri == 1):?>
                    <input type="button" value="Отправить СМС" onclick="showFormSms();"/>
                <?php endif ?>
            </div>
            <div class="notes">
                <div id="notediv">
                    <h3>Примечания</h3>
                    <?php foreach ($notes as $note):?>
                        <div style="padding-bottom: 10px;"><ins><em><?=date("d.m.Y", strtotime($note['date']))?></ins></em>  <?=$note['note']?></div>

                    <?php endforeach;?>

                </div>
                <label id="add" onclick="$('#add_note').show()" style="display:block; color:#0033CC">Добавить примечание</label>
                <div id="add_note" style="display:none;">
                    <textarea id="notes" cols="50" rows="7"></textarea>
                    <input type="button" onclick="addNote(<?=$oid;?>)" value="Добавить"/>
                </div>
            </div>
        </div>
        <div class="imgss">
            <?php
            foreach($files as $key=>$file):
                if(stripos($file,'.jpg' ) === false && stripos($file,'.jpeg' ) === false){
                    continue;
                }?>
                <a href="http://192.168.0.99/baza<?=$file?>">
                    <?php $fileres = preg_replace('/.(gif|jpe?g|png|w?bmp|tiff?)$/',"-150x150.\$1",$file);?>
                    <img src="baza<?=$fileres?>">
                </a>
            <?php endforeach;?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>