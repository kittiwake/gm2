<div class="content">
    <div id="od">
        <h2>Замер <strong id="zakaz"><?=$sample['contract'];?></strong></h2>
        <ins><em>Дата выезда</em></ins> <?=date("d.m.Y", strtotime($sample['date_dis']));?><br />
        <ins><em>Адрес</em></ins> <?=$sample['address'];?><br /><br />
        <ins><em>Менеджер</em></ins> <?=$sample['name_men'];?><br />
        <ins><em>Дизайнер</em></ins> <?=$disList[$sample['dis']];?><br /><br />
        <ins><em>Состояние</em></ins>
        <?php
        switch ($sample['stan']){
            case 'zakluchen':
                echo 'Заключен';
                break;
            case 'tekuch':
                echo 'Текущий';
                break;
            case 'new':
                echo 'Не просмотрен дизайнером';
                break;
            case 'otkaz':
                echo 'Отказ';
                break;
            case 'arhiv':
                echo 'В архиве';
                break;
            default:
                echo '';
        }
        ?>

        <br />
        <?php if($sample['stan']=='zakluchen'):?>
            <ins><em>Сумма</em></ins> <?=$sample['sum'];?>р.
            <?php if($sample['beznal']==1):?>
                <img class="rad" src="/images/bank.jpg">
            <?php endif;?>
            <br />
            <ins><em>Предоплата</em></ins> <?=$sample['prepayment'];?>р. <br />
            <ins><em>Сдано на производство</em></ins>
            <?php
            switch ($sample['render']){
                case 'money':
                    echo 'Деньги';
                    break;
                case 'contract':
                    echo 'Договор';
                    break;
                case 'all':
                    echo 'Деньги и договор';
                    break;
                case 'nothing':
                    echo 'Ничего';
                    break;
                default:
                    echo '';
            }
            ?>
            <br />
        <?php endif;?>
        <br /><br />
        <ins><em>Примечание</em></ins> <?=$sample['note'];?><br />

    </div>
</div>

