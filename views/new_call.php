<div class="content">
    <div class="content_main">

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
                    <td><input type="text" name="con" value="<?=$contract;?>" onblur="checkArhiv(this.value)"/></td>
<!--                    <input type="text" name="num" id="num" value="--><?//=$contract?><!--" onblur="checkDublication(this.value)"/>-->
                </tr>
                <tr>
                    <td align="right" valign="top">Адрес</td>
                    <td><textarea name="adress" cols="70" rows="2"><?=$adress?></textarea></td>
                </tr>
                <tr>
                    <td align="right">Дата выезда дизайнера</td>
                    <td><input type="text" name="term" value="<?=$termin?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/></td>
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
                    <td align="right" valign="top">Примечание</td>
                    <td><textarea name="note" cols="70" rows="2"><?=$note?></textarea></td>
                </tr>
                <tr>
                    <td align="right" valign="top">Время</td>
                    <td><input type="text" name="time"><?=$time?></td>
                </tr>
                <tr>
                    <td align="right" valign="top">Холостой</td>
                    <td><input type="text" name="empt"><?=$empt?>р.</td>
                </tr>

                <td>
                    <input type="text" value="<?=$name_men?>" name="name_men">
                </td>
                <td>
                    <input type="submit" name="submit" id="ok" value="Создать">
                </td>
                </tr>

            </table>

        </form>
        <?php endif;?>

    </div>
</div>