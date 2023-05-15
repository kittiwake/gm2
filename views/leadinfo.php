<div class="content">
    <div class="content-inner-left">
        <div class="client-card__name">
            <div class="client-name">
                <input type="text" id="order_name" placeholder="..." value="<?=$leadarr['nomer']?>">
                <input type="hidden" id="idclient" value="<?=$leadid?>">
            </div>
            <div class="callman" id="callman">
                <?=$leadarr['responsible']?>
            </div>
        </div>
        <?php  if(isset($last_contr)):?>
        <div class="new_lead__helper">
            Последние созданные:
            <?php foreach($last_contr as $contr):?>
                <p><span><?=$contr;?></span></p>
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <div class="client-card">
            <div class="client-card__contacts">
                <div class="client-card__contact-row">
                    <div class="contact-label">телефон</div>
                    <div class="contact-value">
                        <input id="client_phone" type="text" placeholder="..." value="<?=$leadarr['phone']?>">
                    </div>
                </div>
                <div class="client-card__contact-row">
                    <?php var_dump($leadarr);?>
                    <div class="contact-label">Адрес</div>
                    <div class="contact-value">
                        <input id="client_phone2" type="text" placeholder="..." value="<?=$leadarr['address']?>">
                    </div>
                </div>
<!--                <div class="client-card__contact-row">-->
<!--                    <div class="contact-label">телефон</div>-->
<!--                    <div class="contact-value">-->
<!--                        <input id="client_phone3" type="text" placeholder="..." value="--><?//=$leadarr['phone3']?><!--">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="client-card__contact-row">-->
<!--                    <div class="contact-label">e-mail</div>-->
<!--                    <div class="contact-value">-->
<!--                        <input id="email" type="text" placeholder="..." value="--><?//=$leadarr['email']?><!--">-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="client-card__leads">
<!--                <a href="/leads/add/?clid=--><?//=$clid?><!--">-->
                    <button id="btn_add_lead" class="button-input" tabindex="-1">
                        <span class="button-input-inner">Привязать контакт</span>
                    </button>
<!--                </a>-->
                <div class="list-leads">
                    <div class="leads-item">
                        контакты
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