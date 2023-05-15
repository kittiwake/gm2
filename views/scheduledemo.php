<div class="content">
    <div id="newContent">
        <table class="plan">
            <?php for($W = 0; $W < $nW+2; $W++): ?>
                <tr>
                    <?php for($w=1; $w<7; $w++):
                        $wd = $w-1;
                        $day_date = strtotime('last sunday + 24 hours +'.$W.' week +'.$wd.'day');

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

                                        // определить рекламацию
                                        $lit1 = Datas::substr_function($contract, -1, 1);
                                        $lit2 = Datas::substr_function($contract, -2, -1);

                                        if ($day['otgruz_end'] == 2) {
                                            $cbgcol = 'ffff00';
                                            if (($lit1 == 'Р') || ($lit2 == 'Р')) $cbgcol = 'FFD700';
                                        }
                                        elseif ($day['upak_end'] == 2) $cbgcol = '00b050';
                                        elseif ($day['tech_end'] == 2) $cbgcol = '00b0f0';
                                        if (strtotime("today")>strtotime($day['term']) && $day['otgruz_end'] !== '2' && $day['term'] != '0000-00-00') $ctcol = '7030a0; font-weight:800';
                                        if (($lit1 == 'Р') || ($lit2 == 'Р')) $ctcol = 'a60303; font-weight:800';
                                        if ($lit1 == 'В') $ctcol = '0501c0; font-weight:800';
                                        $sign = '';
                                        if ($day['rassr'] == 1) $sign = '<img class="rad" src="/images/rassr.jpg">';
                                        if ($day['beznal'] == 1) $sign = '<img class="rad" src="/images/bank.jpg">';
                                        if ($day['term']=='0000-00-00'){
                                            $date = '<img src="/images/otkr.png">';
                                        }else{
                                            $date = date ("d.m",strtotime($day['term']));
                                        }

                                        ?>

                                        <tr>
                                            <td rowspan="2" class="cont" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>"><?=$contract;?></td>
                                            <td class="summa rub" bgcolor="<?=$cbgcol;?>"><?php echo $sign.' '.$day['sum']; ?>р.</td>
                                        </tr>
                                        <tr>
                                            <td class="plandate" bgcolor="<?=$cbgcol;?>"><?=$date;?></td>
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