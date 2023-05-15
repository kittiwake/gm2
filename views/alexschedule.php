<div class="content">
    <div id="newContent">
        <table class="plan">
            <?php for($W = 0; $W < $nW+2; $W++): ?>
                <tr>
                    <?php for($w=1; $w<7; $w++):
                        $wd = $w-1;
                        $day_date = $begin+$W*7*24*3600+$w*24*3600;
                        if($today == $day_date) $daycolor = '#008000';
                        elseif ($today > $day_date) $daycolor = '#ff0';
                        else $daycolor = '#0ff';?>
                        <td>
                            <table class="oneday">
                                <tr>
                                    <td colspan="2" bgcolor="<?=$daycolor?>">
                                        <?php
                                        echo date('d.m', $day_date);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                if (isset($orderList[$day_date])):
                                    foreach($orderList[$day_date] as $oid=>$day):?>
                                        <?php
                                        // определение цвета ячейки
                                        $cbgcol = 'c0e6c0';
                                        $ctcol = '000000';
                                        $contract = $day['contract'];

                                        if ($day['otgruz_end'] == 2) {
                                            $cbgcol = 'ffff00';
                                            if (Datas::isRekl($contract)) $cbgcol = 'FFD700';
                                        }
                                        elseif ($day['upak_end'] == 2) $cbgcol = '00b050';
                                        elseif ($day['tech_end'] == 2) $cbgcol = '00b0f0';
                                        if (strtotime("today")>strtotime($day['term']) && $day['otgruz_end'] !== '2' && $day['term'] != '0000-00-00') $ctcol = '7030a0; font-weight:800';
                                        if (Datas::isRekl($contract)) $ctcol = 'a60303; font-weight:800';
                                        ?>

                                        <tr>
                                            <td class="cont" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>"><?=$contract;?></td>
                                            <td class="delivmat">
                                                <?php if ($day['photo']!=1):?>
                                                    <div style="background-color: <?=$bcgcolor[$day['photo']]?>">фотопечать</div>
                                                <?php endif;?>
                                                <?php if ($day['pesok']!=1):?>
                                                    <div style="background-color: <?=$bcgcolor[$day['pesok']]?>">пескоструй</div>
                                                <?php endif;?>
                                                <?php if ($day['vitrag']!=1):?>
                                                    <div style="background-color: <?=$bcgcolor[$day['vitrag']]?>">витраж</div>
                                                <?php endif;?>
                                                <?php if ($day['oracal']!=1):?>
                                                    <div style="background-color: <?=$bcgcolor[$day['oracal']]?>">оракал</div>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif;?>
                            </table>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
    </div>
</div>