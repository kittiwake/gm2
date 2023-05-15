<div class="content">
<div>
    <?php foreach($messages as $msg):?>
        <div class="message<?=$msg['stan']=='new'?' msg_new':''?><?=$msg['from_user']==$log?' mine_msg':''?>">
            <div class="msg_time">
                <?=$msg['date_time'];?>
            </div>
            <div class="msg_text">
                <?=$msg['text'];?>
            </div>
            <div class="msg_from">
                <?=$msg['from_user']==$log?$list[$msg['to_user']]:$msg['from_user']?>
            </div>
        </div>
    <?php endforeach;?>
</div>
    <div class="msg_tosend">
        <form method="post">
            <table>
                <tr>
                    <td>Кому</td>
                    <td>
                        <select name="touser">
                            <option value="">&nbsp;</option>
                            <?php foreach($list as $login=>$name):?>
                                <option value="<?=$login?>"><?=$name;?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Текст</td>
                    <td>
                        <textarea cols="70" rows="7" name="textmess"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="Отправить">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>