<div class="content">
    <div id="list__body-right" class="list__body-right ">

        <div class="list__body-right__top">
            <div class="list__top__actions">
                <button id="todo_add_btn" class="button-input button-input_add">
                    <span class="button-input-inner__text">Добавить задачу</span>
                </button>
            </div>
        </div>

        <div class="pipeline_wrapper pipeline_row">

            <?php foreach($todoall as $srok=>$listtodo):?>
                    <?php if(!empty($listtodo)):?>
                    <div class="pipeline_cell">
                        <div id="status_id_<?=$srok;?>" class="pipeline_status__head">
                            <div class="pipeline_status__head_inner">
                                <div class="pipeline_status__head_title">
                                    <span class="block-selectable"><?=$sroki[$srok];?></span>
                                </div>
                                <span class="block-counter" data-count="<?=count($listtodo);?>"><?=count($listtodo);?> задача</span>
                            </div>
                            <span class="pipeline_status__head_line" style="background: #c3c2c3; color: #c3c2c3;"></span>
                        </div>
                        <div class="pipeline_items__list" data-id="<?=$srok;?>">
                            <?php foreach($listtodo as $item):?>
                            <div class="todo-line__item <?=$item['active']?> " id="id_<?=$item['id']?>">
                                <div class="todo-line__item-contacts">

                                    <div class="todo-line__item-contacts-contact">
                                        <?=$item['contact'];?>
                                    </div>

                                </div>
                                <div class="todo-line__item-data">
                                    <div class="todo-line__item-data-time <?=$item['lost'];?>">
                                        <?=$item['date'];?> <?=$item['time']!='00:00:00'?$item['time']:'Весь день';?>
                                    </div>

                                    <div class="todo-line__item-members<?=$item['from_user']==$item['to_user']?' invisible':''?>">
                                        от <?=$item['from_user'];?>
                                    </div>
                                    <div class="todo-line__item-members">
                                        для <?=$item['to_user'];?>
                                    </div>
                                </div>
                                <div class="todo-line__item-body">
                                    <div class="todo-line__item-body-type">
                                        <?=$item['type_zadacha'];?>:</div>
                                    <p><?=$item['zadacha']?></p>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <?php endif;?>
            <?php endforeach;?>

        </div>
    </div>

    <div class="modal modal-todo" id="modal_todo">
        <div class="modal-body">
            <div class="modal-body__inner">
                <div class="todo-form">
                    <div class="cust_card">
                        <input id="customer" type="text" autocomplete="off" placeholder="Контакт, сделка, договор" value="" data-cust-card="">
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

    <div class="modal modal-todo" id="modal_result">
        <div class="modal-body">
            <div class="modal-body__inner">
                <div class="todo-form">
                    <div id="sdelka_client">
                        <a id="sdelka_result">ссылка на сделку</a>, <a id="contact_result">ссылка на контакт</a>
                    </div>
                    <div id="date-time-lost">
                        <span>дата, время (просрочено)</span> для кого
                    </div>
                    <div id="zadacha_result">
                        <p><b>Связаться с клиентом</b> текст задачи</p>
                    </div>
                    <div class="card-task__result">
                            <textarea class="text_result" id="text_result" placeholder="Результат выпонения/Причина невыполнения"></textarea>
                        <button id="result_btnok" class="button-input task-submit" tabindex="-1">
                            <span class="button-input-inner">Выполнить</span>
                        </button>
                    </div>
                    <div class="card-task__transfer">
                        <div class="transfer_data">
                            <select id="transfer_date">
                                <option value="today">Сегодня</option>
                                <option value="next day" selected>Завтра</option>
                                <option value="next week">Через неделю</option>
                                <option value="next month">Через месяц</option>
                                <option value="next year">Через год</option>
                                <option value="date">Указать дату</option>
                            </select>
                            <input type="text" class="invisible" size="10" id="transfer_input_calendar" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
                            <select id="transfer_time">
                                <option value="00:00:00" selected>Весь день</option>
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
                            <select id="transfer_to_user">
                                <?php foreach($users as $user_log=>$name):?>
                                    <option value="<?=$user_log;?>" <?=$user_log==$log?'selected':''?>><?=$name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <button id="transfer_btn" class="button-input button-cancel" tabindex="-1">
                            <span>Перенести</span>
                        </button>
                    </div>
                    <div class="card-task__buttons">
                        <button id="delete_btn" class="button-input button-cancel" tabindex="-1">
                            <span>Удалить</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>