    <div id="fon"></div>
    <div id="dialog">
        <input type="hidden" value="" id="oid"/>
        Подтвердите готовность заказа <h3></h3> на участке
        <div id="navbtn">
            <div class="nav" id="ok">Подтвердить</div>
            <div class="nav" id="cancel">Отмена</div>
        </div>
    </div>
   <div class="content">
        <div class="list">
            <?php if(empty($orderList)):?>
                <div id="empty">Обратитесь к начальнику производства</div>
            <?php else:?>
                <?php foreach($orderList as $order):?>
                    <?php $bgcol = strtotime($order[$etap_date])!=strtotime('today') ? '#FF6846' : 'floralwhite';?>
                    <div id="<?=$order['oid'];?>" class="one_from_list" style="background-color: <?=$bgcol;?>">
                        <?=$order['contract'];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
