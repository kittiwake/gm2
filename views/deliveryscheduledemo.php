<div class="content">
    

<main>
  
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Материалы</label>
    
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Фурнитура</label>
    
  <input id="tab3" type="radio" name="tabs">
  <label for="tab3">Мдф, малярка</label>
    
  <section id="content1">
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
//                                    var_dump($day);
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

                                        <tr >
                                            <td class="delivcont" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>"><?=$contract;?></td>
                                            <td class="delivmat ">
                                            <?php if (isset($mater[$oid])):?>
                                                <?php foreach($mater[$oid] as $order):?>
                                                    <div style="background-color: <?=$order['status']?>" ><?=$order['designation']?></div>
                                                <?php endforeach;?>
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
  </section>
    
  <section id="content2">
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
//                                    var_dump($day);
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

                                        <tr >
                                            <td class="delivcont" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>" data-otd = 'f'><?=$contract;?></td>
                                            <td class="delivmat ">
                                            <?php if (isset($furn[$oid])):?>
                                                <?php foreach($furn[$oid] as $order):?>
                                                    <div style="background-color: <?=$order['status']?>" ><?=$order['designation']?></div>
                                                <?php endforeach;?>
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
    </section>
    
  <section id="content3">
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
                                if (isset($olorderList[$day_date])):
                                    foreach($olorderList[$day_date] as $oid=>$day):?>
                                        <?php
//                                    var_dump($day);
                                        // определение цвета ячейки
                                        $cbgcol = 'c0e6c0';
                                        $ctcol = '000000';
                                        $contract = $day['contract'];

                                        if ($day['otgruz_end'] == 1) {
                                            $cbgcol = 'ffff00';
                                            if (Datas::isRekl($contract)) $cbgcol = 'FFD700';
                                        }
                                        elseif ($day['upak_end'] == 1) $cbgcol = '00b050';
                                        elseif ($day['tech_end'] == 1) $cbgcol = '00b0f0';
                                        if (strtotime("today")>strtotime($day['plan']) && $day['otgruz_end'] !== '1' && $day['plan'] != '0000-00-00') $ctcol = '7030a0; font-weight:800';
                                        if (Datas::isRekl($contract)) $ctcol = 'a60303; font-weight:800';
                                        ?>

                                        <tr >
                                            <td class="delivcont" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>" data-otd = 'o'>
                                                    <span class='otip'><?=$day['tip']==1?'П':'Э'?></span>
                                                    <?=$contract;?>
                                                    
                                            </td>
                                            <td class="delivmat ">
                                            <?php if (isset($oldi[$oid])):?>
                                                <?php foreach($oldi[$oid] as $order):?>
                                                    <div style="background-color: <?=$order['status']?>" ><?=$order['designation']?></div>
                                                <?php endforeach;?>
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
    </section>
    

</main>


</div>