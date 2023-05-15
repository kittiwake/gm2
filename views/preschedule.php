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
                        <td id="<?=$day_date?>">
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
                                        elseif ($day['technologist'] != 0) $cbgcol = '99ccff';
                                        if (strtotime("today")>strtotime($day['term']) && $day['otgruz_end'] !== '2' && $day['term'] != '0000-00-00') $ctcol = '7030a0; font-weight:800';
                                        if($day['attention'] == 1) $ctcol = 'f30; font-weight:800';
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
                                            <td rowspan="2" class="precont <?=$day['plan']!=$day['pre_plan']?'metka':''?>" id="<?=$oid;?>" bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>"><?=$contract;?></td>
                                            <td class="summa rub" bgcolor="<?=$cbgcol;?>"><?php echo $sign.' '.$day['bossnote']; ?>л. <span style="font-size: 0.8em"> <?php echo $day['sum']; ?>р.</span></td>
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
<div class="form" id="formdate">

    <h3>
        <div id="formorder"></div>
        <input type="hidden" id="formoid">
    </h3>

    <div>
        <div class="column"><br>Перенести заказ на другую дату (без изменений в основном графике)<br><br>
            <input type="text" id="pre_date" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"><br><br>
            <button id="formtransf">Перенести</button>
        </div>
        <div class="column">
            Установить заказ на эту дату в основном графике<br><br>
            <button id="formsave">Закрепить</button>
        </div>
    </div>
</div>
<div id="fon"></div>
<script type="text/javascript">
    window.addEventListener('load',function(){
        var orderstd = document.getElementsByClassName('precont');
        for(var i=0; i<orderstd.length; i++){
            orderstd[i].addEventListener('click', newfunc);
        }
        var save = document.getElementById('formsave'),
            transf = document.getElementById('formtransf');
        save.addEventListener('click',saveMainTable);
        transf.addEventListener('click',saveNewPreDate);

        function newfunc(){
//            console.log(this.id);
//            console.log(this.innerText);
            //показать форму для переноса и примечания
            $('#formdate').show();
            $('#fon').show();
            $('#pre_date').val('');
            //расположить по центру
            console.log(window.innerHeight);
            var w = 350,
                h = 200,
                left = (window.innerWidth - w) / 2, // ширина
                top = (window.innerHeight - h) / 2; // высота
            $('#formdate').css({'width' : w, 'height' : h, 'top' : top, 'left' : left, 'padding':'15px'});
            $('#formorder').text(this.innerText);
            $('#formoid').val(this.id);
//            this.setAttribute("draggable"); --- не получилось
        }
        function saveMainTable(){
            var oid = $('#formoid').val();
            $.ajax({
                url:'/schedule/fixPlan/',
                type:'post',
                data:'oid='+oid,
                success:function(data){
                    console.log(data);
                    $('#formdate').hide();
                    $('#fon').hide();
                    //поставить метку
                    if($('#'+oid).hasClass('metka'))
                        $('#'+oid).removeClass('metka');
                }
            })
        }
        function saveNewPreDate(){
            var oid = $('#formoid').val(),
                predate = $('#pre_date').val();
            if(/(\d{2}).(\d{2}).(\d{4})/.test(predate)){
                $.ajax({
                    url:'/schedule/changePrePlan/',
                    type:'post',
                    data:'oid='+oid+'&preplan='+predate,
                    success:function(data){
                        console.log(data);
                        if(data){

//                            $('#'+oid).parent().clone().appendTo('#'+data+'>table>tbody');
//                            $('#'+oid).parent().next().clone().appendTo('#'+data+'>table>tbody');

//                            что клонируем
                            var td = document.getElementById(oid),
                                tr1 = td.parentNode,
                                tr2 = tr1.nextElementSibling;
                            tr1.remove();
                            tr2.remove();
                            //куда вставляем
                            var tday = document.getElementById(data),
                                table = tday.firstElementChild.firstElementChild;
                            var cl = $(tr1).clone();
                            $(cl).appendTo(table);
                            $(tr2).clone().appendTo(table);
                            var newtd = cl[0].firstElementChild;
                            newtd.addEventListener('click', newfunc);
                            if(!$(newtd).hasClass('metka'))
                            $(newtd).addClass('metka');

                            $('#formdate').hide();
                            $('#fon').hide();
                        }
                    }
                })
            }
        }
    });
</script>
