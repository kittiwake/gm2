<div class="content">

    <?php if (isset($result) && $result != '0'):?>

        <p>Заказ добавлен</p>

    <?php else:?>

    <?php if (isset($errors) && is_array($errors)):?>
        <ul>
            <?php foreach($errors as $error):?>
                <li> - <?=$error;?></li>
            <?php endforeach;?>
        </ul>
    <?php endif;?>

    <form method="post" action="#">
        <table width="100%" border="0">
            <tr>
                <td width="170" align="right">Договор № </td>
                <td><input type="text" name="num" id="num" value="<?=$contract?>" onblur="checkDublication(this.value)"/></td>
            </tr>
            <tr>
                <td align="right">от</td>
                <td><input type="text" name="con_date" value="<?=$con_date?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td align="right">ООО</td>
                <td>
                    <select  name="ooo" id="ooo">
                        <option value=''> </option>
                        <option value='gm' <?php if ($ooo == 'gm'){echo 'selected';}?>>Галерея Мебели</option>
                        <option value='als' <?php if ($ooo == 'als'){echo 'selected';}?>>Александрия</option>
                        <option value='mk' <?php if ($ooo == 'mk'){echo 'selected';}?>>ИП Барладян</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>

            <tr>
                <td align="right">Имя заказчика</td>
                <td><input type="text" name="name" id="name" value="<?=$name?>" size="80"/></td>
            </tr>
            <tr>
                <td align="right">Изделие</td>
                <td><input type="text" name="prod" id="prod" value="<?=$prod?>" size="40"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td align="right">Срок по договору</td>
                <td><input type="text" name="term" value="<?=$termin?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                    открытая дата
                    <input type="checkbox" name="otkr" id="otkr" <?php if ($otkr == 1){echo 'checked';}?> /> / 
                    <input type="text" name="calday" id="calday" size="2" /> календарных дней</td>
                    <!--<input type="text" name="calday" id="calday"  /> рабочих дней</td>-->
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td align="right" valign="top">Сумма</td>
                <td>
                    <input type="text" name="sum" value="<?=$sum?>" />
                    <br>
                    <input type="checkbox" name="rassr" id="rassr" <?php if ($rassr == 1){echo 'checked';}?>/>Рассрочка
                    <br>
                    <input type="checkbox" name="beznal" id="beznal" <?php if ($beznal == 1){echo 'checked';}?>/>Безнал
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Размер скидки</td>
                <td><input type="text" name="rebate" value="<?=$rebate?>"/>
                скидка указывается в рублях, либо при указании % пересчитывается в рубли автоматически
                </td>
            </tr>
            <tr>
                <td align="right">Предоплата</td>
                <td><input type="text" name="pred" value="<?=$pred?>"/></td>
            </tr>
            <tr>
                <td align="right">Дизайнер</td>
                <td>
                    <select name="dis" id="dis">
                        <option value="0"> </option>
                        <?php foreach ($disList as $disigner):?>
                            <option value="<?=$disigner['uid']?>" <?php if ($dis == $disigner['uid']){echo 'selected';}?>><?=$disigner['name']?></option>
                        <?php endforeach; ?>

                    </select>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Адрес</td>
                <td><textarea name="adress" id="adress" cols="70" rows="3"><?=$adress?></textarea></td>
            </tr>


            <tr>
                <td align="right">Стоимость доставки</td>
                <td><input type="text" name="sumdeliv" value="<?=$sumdeliv?>"/></td>
            </tr>
            <tr>
                <td align="right">Стоимость сборки</td>
                <td><input type="text" name="sumcollect" value="<?=$sumcollect?>"/></td>
            </tr>


            <tr>
                <td align="right" valign="top">Номер телефона</td>
                <td><input name="phone" id="phone" pattern="7[0-9]{10}" placeholder="7YYYXXXXXXX" value="<?=$phone?>"></td>
            </tr>
            <tr>
                <td align="right" valign="top">E-mail</td>
                <td>
                    <input name="email" id="email" pattern=".+@.+\.[a-zA-Z]{2,6}" value="<?=$email?>">
                    <br>
                    <input type="checkbox" name="agreement" id="agreement" <?php if ($agreement == 'agree'){echo 'checked';}?>/>Согласен на обработку персональных данных
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Примечание</td>
                <td><textarea name="note" cols="70" rows="7"><?=$note?></textarea></td>
            </tr>

            <td></td>
            <td>
                <input type="submit" name="submit" id="ok" value="Добавить">
            </td>
            </tr>

        </table>
    </form>
    <?php endif;?>
</div>