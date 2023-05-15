<div class="content">
    <div class="content_main">
        <ul>Добавить
            <li class="staff" id="add-5">дизайнера</li>
            <li class="staff" id="add-17">сборщика</li>
            <li class="staff" id="add-18">водителя</li>
            <li class="staff" id="add-6">технолога</li>
        </ul>
        <ul>Удалить
            <li class="staff" id="del-5">дизайнера</li>
            <li class="staff" id="del-17">сборщика</li>
            <li class="staff" id="del-18">водителя</li>
            <li class="staff" id="del-6">технолога</li>
        </ul>
        <?php if ($ri==1):?>
        <a href="http://192.168.0.99/ship/users/">Цеховые работники</a> (база упаковщиков - доступ только внутри сети фабрики)
        <?php endif;?>
    </div>
    <div class="form" id="form_add">
<!--        инпут с автозаполнением, проверка, есть ли такой юзер, список его pid,
            если есть - ошибка;
            если есть работник, узнать uid и записать в базу пару uid=>pid;
            если нет работника, создать запись и в users, и в user-post; -->
        <input type="hidden" value="" id="post_id">
        <input id="new_worker" type="text" size="35">
        <button onclick="appoint();">Добавить</button>
    </div>
    <div class="form" id="form_del">
<!--        получить список работников по указанному pid-->
    </div>
    <div id="fon"></div>
</div>