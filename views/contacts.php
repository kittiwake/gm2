<div class="content">
    <div class="list__body-right__top">
        <div class="list__top__actions">
            <a class="button-input button-input_add" href="/contacts/add">
                <span class="button-input-inner__text">Добавить контакт</span>
            </a>
        </div>
    </div>
    <div>
        <br>
        <br>
        Найдено <?=count($list);?> контактов
    </div>
    <table>
        <tr>
            <th>Имя</th>
            <th>Дата и время создания</th>
            <th>Телефон</th>
            <th>e-mail</th>
            <th class="hidden">Добавить</th>
            <th>Удалить</th>
            <th>Добавить задачу</th>
<!--            <th>Заказы</th>-->
        </tr>
        <?php foreach($list as $client):?>
        <tr data-clid="<?=$client['id']?>">
            <td class="contact-line__name">
                <a href="/contacts/client/<?=$client['id']?>" >
                    <?=$client['name']!=''?$client['name']:'Неизвестный контакт';?>
                </a>
            </td>
            <td><?=$client['date'];?> <?=$client['time'];?></td>
            <td><?=$client['phone'];?></td>
            <td><?=$client['email'];?></td>
            <td class="hidden">
                <img src="/images/add-row.png">
            </td>
            <td>
                <div class="del_cont">
                    <img src="/images/delete.png">
                </div>
            </td>
            <td>
                <div class="add_todo">
                    <img src="/images/add-list.png">
                </div>
            </td>
<!--            <td>--><?php //foreach($client['orders'] as $order){
//                    echo $order.', ';
//                }?><!--</td>-->
        </tr>
        <?php endforeach;?>
    </table>

<!--    форма нового контакта и редактирования старого-->
<!--    <div class="modal modal-contact" id="modal_contact">-->
<!--        <div class="modal-body">-->
<!--            <div class="modal-body__inner">-->
<!--                <div class="contact-form">-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="modal modal-todo" id="modal_todo">
        <div class="modal-body">
            <div class="modal-body__inner">
                <div class="todo-form">
                    <div class="cust_card">
                        <input id="customer" type="text" autocomplete="off" placeholder="Контакт, сделка, договор" value="" data-cust-card="">
                        <input type="hidden" id="clid" value="">
                        <input type="hidden" id="leadid" value="">
                    </div>
                    <div id="found_variants" class="cust_card__found">
                    </div>
                    <div>
                        <select id="new_date">
                            <option value="today">Сегодня</option>
                            <option value="next day" selected>Завтра</option>
                            <option value="next week">Через неделю</option>
                            <option value="next month">Через месяц</option>
                            <option value="next year">Через год</option>
                            <option value="date">Указать дату</option>
                        </select>
                        <input type="text" class="invisible" id="input_calendar" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
                        <select id="new_time">
                            <option value="0" selected>Весь день</option>
                            <option value="09:00:00" >09:00</option>
                            <option value="10:00:00" >10:00</option>
                            <option value="11:00:00" >11:00</option>
                            <option value="12:00:00" >12:00</option>
                            <option value="13:00:00" >13:00</option>
                            <option value="14:00:00" >14:00</option>
                            <option value="15:00:00" >15:00</option>
                            <option value="16:00:00" >16:00</option>
                            <option value="17:00:00" >17:00</option>
                            <option value="18:00:00" >18:00</option>
                            <option value="19:00:00" >19:00</option>
                            <option value="20:00:00" >20:00</option>
                        </select>
                        для
                        <select id="to_user">
                            <?php foreach($users as $user_log=>$name):?>
                                <option value="<?=$user_log;?>" <?=$user_log==$log?'selected':''?>><?=$name;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="control-contenteditable" id="text_area">
                        <div class="card-task__type">
                            Связаться с клиентом
                        </div>
                        <div id="text_area__data" class="control-contenteditable__area" contenteditable="true"></div>
                    </div>
                    <div class="card-task__buttons">
                        <button id="btnok" class="button-input task-submit" tabindex="-1">
                            <span class="button-input-inner">Поставить</span>
                        </button>
                        <button id="btncancel" class="button-input button-cancel" tabindex="-1">
                            <span>Отмена</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>