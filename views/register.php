<div class="content">
    <?php if (isset($result)):?>

        <p>Пользователь зерегистрирован</p>

    <?php else:?>

        <?php if (isset($errors) && is_array($errors)):?>
            <ul>
                <?php foreach($errors as $error):?>
                    <li> - <?=$error;?></li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
    пользователь должен быть принят на работу и внесен в базу как работник

<form method="post" action="#">
    <table>
        <tr>
            <td>

            </td>
            <td>
                <select name="user">
                    <option value="0"> </option>
                    <?php foreach($users as $us):?>
                        <option value="<?=$us['id']?>" <?php if ($uid == $us['id']){echo 'selected';}?>><?=$us['name']?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                логин
            </td>
            <td>
                <input type="text" value="<?=$log?>" name="login">
            </td>
        </tr>
        <tr>
            <td>
                пароль
            </td>
            <td>
                <input type="text" value="<?=$pass?>" name="password">
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" name="submit" value="Зарегистрировать">
            </td>
        </tr>
    </table>
</form>
<?php endif;?>
</div>