<br/>
<br/>
<br/>
<?php if ($result):?>

<p>Заказ добавлен</p>

<?php else:?>

<?php if (isset($errors) && is_array($errors)):?>
    <ul>
        <?php foreach($errors as $error):?>
            <li> - <?=$error;?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<div class="content_main">
    <form action="#" method="post">
        <div>
            <input type="hidden" value="<?=$rw?>" id="rw" name="rw">
            <input type="hidden" id="isdil">
            
            <p id='fordil' <?=$gm==1?'style="display:none"':'';?>>
                Диллер
                <select name="selectdil" id="selectdil" class="diller">
                    <option value="0"> </option>
                    <option value="1" <?php if ($dil == 1){echo 'selected';}?> >не диллер</option>
                    <?php
                    foreach($dillist as $diller):
                    ?>
                    <option value=<?=$diller['id']?> <?php if ($dil == $diller['id']){echo 'selected';}?> data-sign=<?=$diller['sign']?> data-lastnum=<?=$diller['lastnum']?>  data-phone=<?=$diller['phone']?>><?=$diller['name']?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
                №
                <input type="hidden" name="lastolnum" class="diller" id="lastolnum" value="" >
                <input type="text" name="num" class="diller" id="olnum" value="" >
            </p>
            <p>
                Заказ №
                <input type="text" name="con1" class="olcon" id="con1" value="<?=$contract;?>" disabled="disabled">
                <input type="hidden" name="con" class="olcon" id="con" value="<?=$contract;?>">
                от
                <input type="text" name="dcon" id="dcon" value="<?=$dcon;?>" <?= $gm==1?'disabled="disabled"':'onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"';?> >
            </p>
            <p>Крайний срок
                <input type="text" name="term" id="term" value="<?=$term;?>"  <?= $gm==1?'disabled="disabled"':' onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"';?>>
            </p>
            <p>Фасады мдф
                <label><input type="radio" name="tip" id="t1"
                              onclick="document.getElementById('pokrs').style.display = 'none';
                              document.getElementById('defpvh').style.display = 'block';
                              document.getElementById('defemal').style.display = 'none';
                    " value="1" <?php if ($tip == 1){echo 'checked';}?>/>ПВХ  </label>
                <label><input type="radio" name="tip" id="t2"
                              onclick="document.getElementById('pokrs').style.display = 'block';
                              document.getElementById('defpvh').style.display = 'none';
                              document.getElementById('defemal').style.display = 'block';
    " value="2" <?php if ($tip == 2){echo 'checked';}?>/>эмаль</label>
            </p>

            <p>Стоимость <input id="sum" type="text" name="sum" value="<?=$sum;?>" onblur="getSumm(this.id)"/> руб. <label>Безнал <input type="checkbox" name="beznal" id="beznal" <?php if ($beznal == true){echo 'checked';}?>/></label></p>
            <p>Предоплата <input type="text" id="predopl" name="predopl" value="<?=$predopl;?>" onblur="getSumm(this.id)"/> руб.</p>
            <p>Квадратура <input type="text" id="mkv" name="mkv" onblur="getSumm(this.id)" value="<?=$mkv;?>"/> м<sup>2</sup></p>
            <label>Радиусные фасады <input type="checkbox" id="radius" name="radius" <?php if ($radius == true){echo 'checked';}?>/></label>
            <p>Цвет <input type="text" class="" name="color" id="color" value="<?=$color;?>"/></p>
            <p id="pokrs" style="display: <?php if ($tip != 2){echo 'none';}?>">Покрытие
                <select name="pokr" id="pokr">
                    <option value="0"> </option>
                    <option value="1" <?php if ($pokr == 1){echo 'selected';}?> >матовый</option>
                    <option value="2" <?php if ($pokr == 2){echo 'selected';}?> >высокий глянец</option>
                    <option value="3" <?php if ($pokr == 3){echo 'selected';}?> >глянец металлик</option>
                    <option value="4" <?php if ($pokr == 4){echo 'selected';}?> >металлик золото</option>
                    <option value="5" <?php if ($pokr == 5){echo 'selected';}?> >звездное небо</option>
                    <option value="6" <?php if ($pokr == 6){echo 'selected';}?> >хамелеон</option>
                    <option value="7" <?php if ($pokr == 7){echo 'selected';}?> >перламутр насыщенный</option>
                </select>
            </p>
            <p>
                Доп.эффект
                <select id="defpvh" name="defpvh" style="display: <?php if ($tip != 1){echo 'none';}?>; width:120px; height:20px;">
                    <option value="0"> </option>
                    <option value="1" <?php if ($dopef == 1){echo 'selected';}?> >патина</option>
                </select>
                <select id="defemal" name="defemal" style="display: <?php if ($tip != 2){echo 'none';}?>; width:120px; height:20px;">
                    <option value="0"> </option>
                    <option value="1" <?php if ($dopef == 1){echo 'selected';}?> >патина</option>
                    <option value="2" <?php if ($dopef == 2){echo 'selected';}?> >градиент</option>
                    <option value="3" <?php if ($dopef == 3){echo 'selected';}?> >трафарет 1</option>
                    <option value="4" <?php if ($dopef == 4){echo 'selected';}?> >трафарет 2</option>
                    <option value="5" <?php if ($dopef == 5){echo 'selected';}?> >трафарет 3</option>
                </select>
            </p>
            <label>Фотопечать <input type="checkbox" id="ftpech" name="fotopec" <?php if ($fotopec == true){echo 'checked';}?>/></label>

            <div id="customer">
                Заказчик
                <input type="hidden" id="idDil" name="idDil" value="<?=$dil;?>" >
                <input id="nameDil" name="nameDil" type="text" size="60" value="<?=$name_dil;?>" <?= $gm==1?'disabled="disabled"':'';?>>
                <br>
                Номер телефона +7<input id="phoneDil" name="phoneDil" type="text" value="<?=$phone_dil;?>" <?= $gm==1?'disabled="disabled"':'';?>>

            </div>
            <br>
            <p>Примечаниие</p>
            <textarea name="note" rows="3" cols="60"><?=$note;?></textarea>

            <p><input type="submit" name="submit" value="Сохранить"></p>
        </div>
    </form>
</div>
    <div id="newodfon" class="fon"></div>
    <div id="mes"></div>
<?php endif; ?>

