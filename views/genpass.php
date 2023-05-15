<div class="content">
    <div class="content_main">
        <div class='rep_sms'>
            <table>
                <tr>
                    <th>
                        Имя
                    </th>
                    <th>
                        Логин
                    </th>
                    <th>Права доступа</th>
                    <th>Должность</th>
                    <th></th>
                </tr>
                <?php foreach($list as $user): ?>
                    <tr>
                        <td id='name<?=$user['id']?>'> <?=$user['name']?> </td>
                        <td id='log<?=$user['id']?>'> <?=$user['user_login']?> </td>
                        <td> <?=$user['user_right']?> </td>
                        <td> <?=$user['post']?> </td>
                        <td>
                            <button onclick="showFormName(<?=$user['id']?>);">Изменить имя</button>
                            <button onclick="showFormLogin(<?=$user['id']?>);">Изменить логин</button>
                            <button onclick="showFormPass(<?=$user['id']?>);">Изменить пароль</button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <div id='fon'></div>
    <input type='hidden' id='uidtochange'/>
    <div class='form' id='formName'>
        Новое имя
        <input type='text' id='newname'/>
        <button onclick="changeName();">Переименовать</button>
    </div>
    <div class='form' id='formLogin'>
        Новый логин
        <input type='text' id='newlog'/>
        <button onclick="changeLogin();">Переименовать</button>
    </div>
    <div class='form' id='formPass'>
        Новый пароль
        <input type='text' id='newpass' />
        <button onclick="changePass();">Изменить</button>
    </div>
</div>