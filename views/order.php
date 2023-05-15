<div class="content" <?=$order['archive']==1?'style="background-color: rgba(248, 218, 110, 0.47);"':''?>>
    <div id="fon"></div>
    <div id="form" class="form">
            Перенести вывоз заказа № <label></label>
            <p>на</p>
            <input type="text" id="newdate" name="newdate" size="8" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this);">
            <input type="button" id="submitok" value="Ok">
    </div>

    <div id="form2" class="form">
        <div id="addmount">
            <input type="hidden" id="oid3">
            <input type="hidden" id="target">
            <div style="height: 50px;">&nbsp;</div>
            <input type="text" id="dateofmount" onfocus="this.select();lcs1(this)" onclick="event.cancelBubble=true;this.select();lcs1(this);">
            <input type="button" value="Назначить" onclick="saveMounting(<?=$ri?>);">
        </div>
    </div>

    <div id="formSms">
                <form method="post" action="">
                    <input type="hidden" value="<?=$oid?>" name="oid">
                    Телефон<br/><input name="phone" value="<?=$order['phone'];?>" pattern="7[0-9]{10}" required placeholder="7YYYXXXXXXX"><br/><br/>

                    Тема <br><select name="tema" id="tema" onChange="getTextMsg('sms');">
                        <option > </option>
                        <?php foreach($sample_sms as $key=>$text):?>
                            <option value="<?=$key;?>"><?=$text['subject_sms'];?></option>
                        <?php endforeach;?>
                    </select>

                    <br/> <br/>
                    Сообщение<br/><textarea name="message" id="message" rows="6" cols="40"></textarea><br/><br/>
                    <input type="submit" name="sendsms" value="Отправить">
                </form>
    </div>
    <div id="formEmail" class="form">
                <form method="post" action="">
                    <input type="hidden" value="<?=$oid?>" name="oid">
                    e-mail<br/><input name="email" value="<?=$order['email'];?>" pattern=".+@.+\.[a-zA-Z]{2,6}" required><br/><br/>

                    Тема <br><select name="tema" id="tema_e" onChange="getTextMsg();">
                        <option > </option>
                        <?php foreach($sample_email as $key=>$text):?>
                            <option value="<?=$key;?>"><?=$text['subject_sms'];?></option>
                        <?php endforeach;?>
                    </select>

                    <br/> <br/>
                    Сообщение<br/><textarea name="emessage" id="e-message" rows="6" cols="40"></textarea><br/><br/>
                    С уважением, коллектив ООО &#171;Галерая мебели&#187;
                    <input type="submit" name="sendmail" value="Отправить">
                </form>
    </div>
    <div id="formnewsum">
        <br>
        <input id="polesum" type="hidden" value="">
        Введите новую сумму
        <input type="text" id="newsum">р.<br><br>
        <input type="button" value="Сохранить" id="changesumm" onclick="changeSumOrder()">
    </div>
    <?php foreach($sample_sms as $key=>$text):?>
        <input type="hidden" id="smp-<?=$key;?>" value="<?=$text['text_sms'];?>">
    <?php endforeach;?>
    <?php foreach($sample_email as $key=>$text):?>
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
<!--        --><?php //debug($stan);?>
    <table border="0" cellspacing="8">
        <?php for ($w=0; $w<count($zagol); $w++):?>
            <tr>
                <td align="right">
                    <?if($zagol[$w]=='Эмаль' || $zagol[$w]=='ПВХ'):?>
                        <a href='/new/oldi?с=gm&t=<?=$zagol[$w];?>&o=<?=$oid?>&con=<?=$order['contract']?>&d=<?=$order['contract_date']?>&p=<?=$stan['plan']?>'>
                    <?endif;?>
                        <?=$zagol[$w];?>
                    <?if($zagol[$w]=='Эмаль' || $zagol[$w]=='ПВХ'):?>
                        </a>
                    <?endif;?>
                </td>

                <?php
                if ($stan[$db[$w]] == 0) $col = '#CCFFFF';
                if ($stan[$db[$w]] == 1) $col = '#666666';
                if ($stan[$db[$w]] == 2) $col = '#33bb00';
                if ($w == 0) $class = "tech";
                else $class = "stan";
                ?>
                <td>
                    <div id="<?=$oid;?>-<?=$w;?>-<?=$stan[$db[$w]];?>" style="background: <?=$col;?>; width:40px; font-size: 0.8em; padding: 2px 0;" class="<?=$class;?>">
                        <?=isset($dbdate[$w])?($stan[$dbdate[$w]]=='0000-00-00'?"&nbsp;":(date("d.m", strtotime($stan[$dbdate[$w]])))):"&nbsp;"?>
                    </div>
                </td>
            </tr>
        <?php endfor; ?>
    </table>
</div>
<div id="od">
    <h2>Договор № <strong id="zakaz"><?=$order['contract'];?></strong> от <span id="datacon"><?php echo date ("d.m.Y",strtotime($order['contract_date']));?></span>    
    </h2>

    <input type="hidden" id="orderid" value="<?=$oid;?>">
    <input type="hidden" id="olddate" value="<?=$stan['plan'];?>">
    <input type="hidden" id="ooo" value="<?=$order['company'];?>">
    <input type="hidden" id="path" value="<?=$path?>">
    
    <div class="delete"
        <?php if($ri != 4&&$ri != 1&&$ri != 55){echo'style="display: none;"';}?>
        >Удалить</div>
    <div class="archive" id="inarch"
        <?php if($ri != 1 || $order['archive']==1){echo'style="display: none;"';}?>
        >В архив</div>
    <div class="archive" id="outarch"
        <?php if($ri != 1 || $order['archive']==0){echo'style="display: none;"';}?>
        >Вернуть в график</div>

    <?php if($ri == 4 || $ri == 3 || $ri == 2|| $ri == 1|| $ri == 55):?>
    <a href="/order/index/<?=$oid?>?printveaw=1" target="print_view"><img src="/images/print.png" width="30px"></a>
        <button onclick="prihKass()">приходник</button>
        <button onclick="torg12()">накладная</button>
        <button class="attention" id="attention" <?=$order['attention']?'style="background-color: rgb(238, 1, 1); color: rgb(249, 228, 216);"':''?> data-attention="<?=$order['attention']?>">Особое внимание</button>
    <?php endif;?>
    <div class="right">
        <div class="oder">
            <h3>О заказе</h3>
            <ins><em>Изделие</em></ins> <?=$order['product'];?><br />
            <br />
            <ins><em>Сумма договора</em></ins> <span class="rub" id="sum"><?=$order['sum'];?>р.</span>
            <?php if($ri == 2 || $ri == 4|| $ri == 1|| $ri == 55):?>
                <input type="button" value="изменить"  onclick="showFormnewsum('sum');">
            <?php endif;?>
            <br />
            <br />
            <ins><em>Скидка</em></ins> <span class="rub" id="rebate"><?=$order['rebate'];?>р.</span>

            <?php if($ri==4|| $ri == 1|| $ri == 55):?>
                <br />
                <br />
                <ins><em>Предоплата</em></ins> <span class="rub" id="prepayment"><?=$order['prepayment'];?>р.</span>
                <input type="button" value="изменить"  onclick="showFormnewsum('prepayment');">

                <br />
                <br />
                <ins><em>Стоимость доставки</em></ins> <span class="rub" id="sumdeliv"><?=$order['sumdeliv'];?>р.</span>
                <input type="button" value="изменить"  onclick="showFormnewsum('sumdeliv');">

                <br />
                <br />
                <ins><em>Вес заказа</em></ins> <span class="rub" id="weight"><?=$stan['weight'];?>кг</span>
                <input type="button" value="изменить"  onclick="showFormnewsum('weight');">

                <br />
                <br />
                <ins><em>Стоимость сборки</em></ins> <span class="rub" id="sumcollect"><?=$order['sumcollect'];?>р.</span>
                <input type="button" value="изменить"  onclick="showFormnewsum('sumcollect');">

            <?php endif;?>
            <br />
            <br />
            <ins><em>Срок договора</em></ins>
            
            
            <?php if ($order['term'] == '0000-00-00'):?>
                <span id="termin"><button onclick="tapOrderTerm();">Установить сроки</button></span>
            <?php else:?>
                <span id="termin"><?=date("d.m.Y", strtotime($order['term']));?></span>
                <?php if($ri == 2 || $ri == 4|| $ri == 1|| $ri == 55 ||$ri == 33):?>
                    <input type="button" value="изменить"  onclick="tapOrderTerm();">
                <?php endif;?>
            <?php endif;?>
            
        </div>
        <div class="farm">
            <h3 id="link">В производство</h3>
            <div >
                <ins><em>Дизайнер</em></ins> <span id="dis" class="disredactiruemyj"><?=$dis;?></span>
                <?php if($ri == 4||$ri == 1||$ri == 55):?>
                    <img src="/images/proposta.gif" class="formdis">
                <?php endif;?>
                <span id="i_dis"></span>
            </div>

<!--            <ins><em>Дизайнер</em></ins> <span id="dis">--><?//=$dis;?><!--</span><br />-->
            <br />
            <ins><em>Технолог</em></ins> <?=$tech;?><br />
            <br />
            <ins><em>Дозамер</em></ins> <?=$date_measure!=''?$date_measure:$button_z;?><br />
            <br />
            <ins><em>Водитель</em></ins> <?=$driver;?><br />
            <br />
            <ins><em>Сборщик</em></ins>
            <?php
            if(isset($colls)){
                foreach($colls as $col){echo $col.' ';}
            }
            ?><br />
            <br />
            <ins><em>Сборка</em></ins> <?=$date_mount!=''?$date_mount:$button;?><br />
            <br />
        </div>
    </div>
    <div class="left">
        <div class="oderer">
            <h3>О заказчике</h3>
            <div class="redaktor" id="redaktor">
                <?php if($ri == 4||$ri == 1||$ri == 55):?>
                    <img src="/images/proposta.gif" class="formimg">
                <?php endif;?>
                <div class="redactiruemyj" id="name">
                    <?=$order['name'];?>
                </div>
                <div class="hidden" id="i_name">
                    <input type="text" value="<?=$order['name'];?>">
                </div>
            </div>
            <div class="redactiruemyj" id="adress">
                <?=$order['adress'];?>
            </div>
            <div class="hidden" id="i_adress">
                <textarea><?=$order['adress'];?></textarea>
            </div>
            <a href="https://yandex.ru/maps/?mode=search&text=<?=$order['adress'];?>" target="_blank"><button>На карте</button></a>
            <?php
            if($order['latlng']==0){?>
                <input type="text" id="latlng_order"><button id="btnll" onclick="saveCoord()">Ввести координаты</button>
            <?php }
            ?>

            <div class="redactiruemyj" id="phone">
                <ins><em>Номер телефона <br />для отправки СМС__</em></ins>
                <b size=4> <a href="tel:+<?=$order['phone'];?>">+<?=$order['phone'];?></a></b>
                <?php if ($ri == 4||$ri == 1||$ri == 55):?>
                    <input type="button" value="Отправить СМС" onclick="showFormSms();"/>
                <?php endif ?>
            </div>
            <div class="hidden" id="i-phone">
                <ins><em>Номер телефона <br />для отправки СМС__</em></ins>
                <input type="text" value="<?=$order['phone'];?>">
            </div>
            <div class="redactiruemyj" id="email">
                <ins><em>E-mail:&nbsp;&nbsp;</em></ins>
                <b size=4> <?=$order['email'];?></b>
                <?php if ($ri == 4||$ri == 1||$ri == 55):?>
                    <input type="button" value="Отправить сообщение" onclick="showFormEmail();"/>
                <?php endif ?>
            </div>
            <div class="hidden" id="i-email">
                <ins><em>E-mail:&nbsp;&nbsp;</em></ins>
                <input type="text" value="<?=$order['email'];?>">
            </div>
            <input class="hidden" type="button" value="Сохранить" onclick="saveChanges();"/>

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
    <div class="imgs">
        <?php
        if(count($files)!=0):
        foreach($files as $file):
//            if(stripos($file,'.jpg' ) === false && stripos($file,'.jpeg' ) === false && stripos($file,'.bmp' ) === false && stripos($file,'.gif' ) === false && stripos($file,'.png' ) === false){
//                continue;
//            }
                ?>
            <a href="<?=$file?>" target="_blank">

                <img src="<?=$file?>">
            </a>
        <?php endforeach;
        endif;?>

    </div>

    <div class="clearfix"></div>

</div>
</div>
