<div class="content">
    <div class="content-inner-left">
        <div class="client-card__name">
            <div class="client-name">
                <input type="text" id="client_name" placeholder="..." value="<?=$clientarr['name']?>">
                <input type="hidden" id="idclient" value="<?=$clid?>">
            </div>
            <div class="callman" id="callman">
                <?=$clientarr['callmen']?>
            </div>
        </div>
        <div class="client-card">
            <div class="client-card__contacts">
                <div class="client-card__contact-row">
                    <div class="contact-label">телефон</div>
                    <div class="contact-value">
                        <input id="client_phone" type="text" placeholder="..." value="<?=$clientarr['phone']?>">
                    </div>
                </div>
                <div class="client-card__contact-row">
                    <div class="contact-label">телефон</div>
                    <div class="contact-value">
                        <input id="client_phone2" type="text" placeholder="..." value="<?=$clientarr['phone2']?>">
                    </div>
                </div>
                <div class="client-card__contact-row">
                    <div class="contact-label">телефон</div>
                    <div class="contact-value">
                        <input id="client_phone3" type="text" placeholder="..." value="<?=$clientarr['phone3']?>">
                    </div>
                </div>
                <div class="client-card__contact-row">
                    <div class="contact-label">e-mail</div>
                    <div class="contact-value">
                        <input id="email" type="text" placeholder="..." value="<?=$clientarr['email']?>">
                    </div>
                </div>
            </div>
            <div class="client-card__leads">
                <a href="/leads/add/?clid=<?=$clid?>">
                    <button id="btn_add_lead" class="button-input" tabindex="-1">
                        <span class="button-input-inner">Создать заявку</span>
                    </button>
                </a>
                <div class="list-leads">
                    <div class="leads-item">
                        номер заказа
                        на каком этапе
                    </div>
                </div>
            </div>
        </div>
        <div class="client-buttons hidden" id="buttons_block">
            <button id="btnok" class="button-input task-submit" tabindex="-1">
                <span class="button-input-inner">Сохранить</span>
            </button>
            <button id="btncancel" class="button-input button-cancel" tabindex="-1">
                <span>Отмена</span>
            </button>
        </div>
    </div>
    <div class="content-inner-right"></div>
</div>