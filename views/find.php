<div class="content">
    <form action='#' method='post' >
        Номер договора
        <input type="text" id="con" name="con" class="findorder"  value="">
        Имя заказчика
        <input type="text" id="name" name="name" class="findorder"  value="">
        Номер телефона
        <input type="text" id="phone" name="phone" class="findorder"  value="">
        <br />
        адрес
        <br />
        улица
        <input type="text" id="str" name="str" class="findorder"  value="">
        дом
        <input type="text" id="h" name="h" class="findorder"  value="">
        квартира
        <input type="text" id="f" name="f" class="findorder"  value="">
        <input type="submit" name='submit'>
        <div id="list">
            <?php if(isset($mass)&&!empty($mass)):?>
            <?php foreach($mass as $elem):?>
            <div class='elem_list'>
                <hr/>
                <p><a href='/order/index/<?=$elem[0];?>'>
                    <b class='ssylka'><?=$elem[1];?></b></a> 
                    от <?=$elem[5]?></p>
                <p><?=$elem[2];?> тел.:<?=$elem[3];?> адрес:<?=$elem[4];?></p>
                <p>Срок по договору: <?=$elem[9];?></p>
                <p>Дата вывоза: <?=$elem[6];?></p>
                <p>Дизайнер: <?=$elem[8];?></p>
                <p>Технолог: <?=$elem[7];?></p>
                <p>Сборки: <?=$elem[10];?></p>
                <div class='note'><?=$elem[11];?></div>
            </div>
            <?php endforeach; endif;?>
        </div>
    </form> 
</div>
