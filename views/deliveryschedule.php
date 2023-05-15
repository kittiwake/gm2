<style type="text/css">
    .bttn {
    background-color: aquamarine;
width: 150px;
margin: 20px;
padding: 10px 20px;
text-align: center;
border-radius: 6px;}

.outlayView {
    position: fixed;
    left: 0;
    top: 100px;
    overflow: auto;
    background-color: ghostwhite;
    width: 1200px;
}
</style>
<div class="content">
    

<main>
  
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Материалы</label>
    
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Фурнитура</label>
    
  <input id="tab3" type="radio" name="tabs">
  <label for="tab3">Мдф, малярка</label>
    
  <input id="tab4" type="radio" name="tabs">
  <label for="tab4">Сметы</label>

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
                                            <td bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>" data-otd='m'>
                                                <div class="delivcont" id="<?=$oid;?>"><?=$contract;?></div>
                                            </td>
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
                                            <td bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>" data-otd='f'>
                                                <div class="delivcont" id="<?=$oid;?>"><?=$contract;?></div>
                                            </td>
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
                                        ?>

                                        <tr >
                                            <td bgcolor="<?=$cbgcol;?>" style="color: #<?=$ctcol;?>" data-otd='o'>
                                                <div class="delivcont" id="<?=$oid;?>" style="color: #<?=$day['tip']==1?'846711':'6b0a6f'?>"><?=$contract;?></div>
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
    
    <section id="content4" style="position: relative;">
        <div class='bttn' id='newOutlay'>
            Новая смета
        </div>
        <div class='hidden' id='form'>
            Точка назначения
            <select id='point'>
                <option value=0></option>
                <?php 
                foreach($providers as $k=>$prov):?>
                    <option value = '<?=$k;?>'><?=$prov;?></option>
                <?php endforeach;?>
            </select>
        <div class='bttn' id='addNewOl'>Создать</div>
          
        </div>
        <div>
            <table>
                <tr>
                    <th>
                        номер сметы
                    </th>
                    <th>
                        дата открытия
                    </th>
                    <th>
                        назначение
                    </th>
                    <th width='500px'>кнопки</th>
                </tr>
                <?php foreach($outlays as $outlay):?>
                    <tr>
                        <td><?=$outlay['id'];?></td>
                        <td><?=$outlay['date'];?></td>
                        <td><?=$providers[$outlay['point']];?></td>
                        <td>
                            <button class='activateOutlay'>Активировать</button>
                            <button class='viewOutlay'>Редактировать</button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </section>

</main>


</div>

<script  type="text/javascript">
    var olay = document.getElementById("newOutlay");
    olay.addEventListener("click", function(){
        var form = document.getElementById("form");
        form.classList.toggle("hidden");
        olay.classList.toggle("hidden");
    });
    var addolay = document.getElementById("addNewOl");
    addolay.addEventListener("click", function(){
        var olay = document.getElementById("newOutlay"),
            form = document.getElementById("form"),
            pointind = document.getElementById("point").selectedIndex,
            pointlist = document.getElementById('point').options,
            point = pointlist[pointind].value,
            val = pointlist[pointind].text;

        if (val!=''){
            $.ajax({ 
                url: "/delivery/newOutlay", 
          	    method: "post", 
        	    data: {"point": point},
          	    success: function(data) {
    			    let tab1 = document.getElementById("tab1"),
    			        prel = tab1.previousElementSibling;
    			    //проверить наличие дива и заменить, если есть
    			    if(!!prel){
    			        prel.remove();
    			    }
    			    let div = document.createElement('div');
    			    div.className = "bttn";
    			    div.setAttribute('id', 'actOutlayId');
    			    div.dataset.outlayid = data;
    			 //   div.innerHTML = val;
    			    div.innerHTML = val + " " + data;
    			    document.getElementById("tab1").before(div);

     		 //       console.log(data);
                } 
            });
        }
        form.classList.toggle("hidden");
        olay.classList.toggle("hidden");
        
    });
    var actbtns = document.querySelectorAll('.activateOutlay');
    for(var i=0; i<actbtns.length; i++){
        actbtns[i].addEventListener('click', function(){
            var bt = this,
                val = bt.parentElement.previousElementSibling.innerHTML, 
                data = bt.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.innerHTML;
    			    let prel = document.getElementById("actOutlayId");
    			    //проверить наличие дива и заменить, если есть
			    if(!!prel){
			        prel.remove();
			    }
			    let div = document.createElement('div');
			    div.className = "bttn";
			    div.setAttribute('id', 'actOutlayId');
			 //   div.innerHTML = val;
			    div.dataset.outlayid = data;
			    div.innerHTML = val + " " + data;
			    document.getElementById("tab1").before(div);
			    
    			var tds = document.querySelectorAll('.delivcont');
    			for(var b=0; b<tds.length; b++){
    			    let btndiv = document.createElement('div');
    			    btndiv.className = "bttn addToOutlay";
    			    btndiv.innerHTML = 'Добавить в смету';
    			    tds[b].after(btndiv);
    			    btndiv.addEventListener('click',function(){
    			        addMaterToOutlay();
    			    });
    		    }
        });
    }
    var viewbtns = document.querySelectorAll('.viewOutlay');
    for(var i=0; i<viewbtns.length; i++){
        viewbtns[i].addEventListener('click', function(){
            var bt = this,
                point = bt.parentElement.previousElementSibling.innerHTML, 
                olid = bt.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.innerHTML;
            $.ajax({
                url: "/delivery/getOutlay", 
                dataType: "json",
          	    method: "post", 
        	    data: {"olid": olid},
          	    success: function(data) {
          	        if(!!data){
          	         //   console.log(data);
          	            var pro = document.getElementById('outlayView');
          	            if(!!pro){
          	                pro.remove();
          	            }
          	            var div = document.createElement('div'),
          	                tab = document.getElementById('content4'),
          	                Ysize = document.documentElement.clientHeight-140;
          	            console.log(Ysize);
          	            div.className = "outlayView";
          	            div.setAttribute('id', 'outlayView');
          	            div.style.height = Ysize+'px';
          	            var tbl = document.createElement('table'),
          	                tr0 = document.createElement('tr'),
          	                th00 = document.createElement('th'),
          	                th01 = document.createElement('th'),
          	                th02 = document.createElement('th'),
          	                th03 = document.createElement('th');
          	            tab.append(div);
          	            div.append(tbl);
          	            tbl.append(tr0);
          	            tr0.append(th00);
          	            tr0.append(th01);
          	            tr0.append(th02);
          	            tr0.append(th03);
          	            th00.innerHTML = 'заказ';
          	            th01.innerHTML = 'позиция';
          	            th02.innerHTML = 'количество';
          	            th03.innerHTML = 'изменить';
          	            for(var k=0; k<data.length; k++){
              	            let tr = document.createElement('tr'),
              	                td1 = document.createElement('td'),
              	                td2 = document.createElement('td'),
              	                td3 = document.createElement('td'),
              	                td4 = document.createElement('td');
              	            tbl.append(tr);
              	            tr.append(td1);
              	            tr.append(td2);
              	            tr.append(td3);
              	            tr.append(td4);
              	            td1.innerHTML = data[k].contract;
              	            td2.innerHTML = data[k].designation;
              	            td3.innerHTML = data[k].count;
              	            var btndel = document.createElement('button');
              	            btndel.innerHTML = 'удалить';
              	            btndel.dataset.matid = data[k].id;
              	            td4.append(btndel);
              	            btndel.addEventListener('click', delFromOutlay);
          	            }
          	            var btnprint = document.createElement('button');
          	            btnprint.innerHTML = 'В печать';
          	            div.append(btnprint);
          	            btnprint.addEventListener('click',pdfOutlay);
          	        }
          	    }
            });
        });
    }
    
    document.addEventListener('click', function(e) {
        var target = e.target,
            outlay = document.getElementById('outlayView');
        if(!!outlay && (target != outlay && !outlay.contains(target)))
    		outlay.remove();
    });

    function pdfOutlay(){
        
    }
    
    function delFromOutlay(){
        // console.log(event.target);
        var btn = event.target,
            tr = btn.parentElement.parentElement,
            mid = btn.dataset.matid;
        console.log(mid);
        $.ajax({
            url:'/delivery/updateToOutlay/',
            type:'post',
            data:'mid='+ mid,
            success: function(data){
                if(!!data && data==1){
          	        tr.remove();
                }
            }
        });
    }
    
    function addMaterToOutlay(){
        var btn = event.target,
            ordiv = btn.previousElementSibling,
            oid = ordiv.getAttribute('id'),
            olid = document.getElementById('actOutlayId').dataset.outlayid;
        $.ajax({
            url: '/delivery/setToOutlay/',
            type: 'post',
            data:'oid='+oid+'&olid='+olid,
            success: function(data){
                if(data){
                    
                }
            }
        });

    }
    
</script>