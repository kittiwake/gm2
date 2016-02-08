<div class="content">

    <?php if (isset($result)):?>

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
                <td><input type="text" name="num" value="<?=$contract?>" onblur="checkDublication(this.value)"/></td>
            </tr>
            <tr>
                <td align="right">от</td>
                <td><input type="text" name="con_date" value="<?=$con_date?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></td>
            </tr>
            <tr>
                <td align="right">Имя заказчика</td>
                <td><input type="text" name="name" value="<?=$name?>" size="80"/></td>
            </tr>
            <tr>
                <td align="right">Изделие</td>
                <td><input type="text" name="prod" value="<?=$prod?>" size="40"/></td>
            </tr>
            <tr>
                <td align="right">Срок по договору</td>
                <td><input type="text" name="term" value="<?=$termin?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>
                    открытая дата
                    <input type="checkbox" name="otkr" id="otkr" <?php if ($otkr == 1){echo 'checked';}?> /></td>
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
                <td align="right">Предоплата</td>
                <td><input type="text" name="pred" value="<?=$pred?>"/></td>
            </tr>
            <tr>
                <td align="right">Дизайнер</td>
                <td>
                    <select name="dis">
                        <option value="0"> </option>
                        <?php foreach ($disList as $disigner):?>
                            <option value="<?=$disigner['uid']?>" <?php if ($dis == $disigner['uid']){echo 'selected';}?>><?=$disigner['name']?></option>
                        <?php endforeach; ?>

                    </select>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Адрес</td>
                <td><textarea name="adress" cols="70" rows="3"><?=$adress?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">Номер телефона</td>
                <td><input name="phone" pattern="7[0-9]{10}" placeholder="7YYYXXXXXXX" value="<?=$phone?>"></td>
            </tr>
            <tr>
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