<div class="content">
    <?php if (isset($error)){
        echo $error;
    }
    ?>
    <form method="post" action="/<?=SITE_DIR;?>/auth">
        <table>
            <tr>
                <td>Логин</td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Войти" name="auth"></td>
            </tr>
        </table>
    </form>
</div>