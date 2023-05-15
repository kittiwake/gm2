<div class="content">
    <div class="navig">
        <div class="nav active_nav" id="first">
            Дизайнеры
        </div>
        <div class="nav passive_nav" id="secondtoo">
            Сборщики
        </div>
    </div>
    <div class="content_main">
        <div class="content_orders first_table" id="t5">
            <table>
                <?php foreach($dis_list as $dis):?>
                    <tr>
                        <td>Изменить</td>
                        <td>
                            <input type="button" id="<?=$dis['id']?>" value="Уволить" onclick="uvolit(this.id)">
                        </td>
                        <td><?=$dis['name']?></td>
                        <td><?=$dis['tel']?></td>
                    </tr>
                <?php endforeach;?>
            </table>
            <div>
                <input type="button" id="5" value="Добавить" onclick="showFormOperate(this.id)">
            </div>
        </div>
        <div class="content_orders secondtoo_table" id="t17">
            <table>
                <?php foreach($coll_list as $coll):?>
                    <tr>
                        <td>Изменить</td>
                        <td>
                            <input type="button" id="<?=$coll['id']?>" value="Уволить" onclick="uvolit(this.id)">
                        </td>
                        <td><?=$coll['name']?></td>
                        <td><?=$coll['tel']?></td>
                    </tr>
                <?php endforeach;?>
            </table>
            <div>
                <input type="button" id="17" value="Добавить" onclick="showFormOperate(this.id)">
            </div>
        </div>

    </div>
</div>
<div id="fon"></div>
<div id="formOperate">
    <input type="hidden" name="pid" value="" id="pid">
    <p>Имя</p>
    <input type="text" id="newname">
    <p>Номер телефона</p>
    <input type="text" id="newphone">
    <input type="button" value="Добавить" id="operate">
</div>