<style type="text/css">

    .plceh_graf{
        width: 80%;
        position: fixed;
        right: 0px;

    }
    .plceh_list{
        width: 15%;
        background-color: ghostwhite;
    }

    .plceh_date{
        background: paleturquoise;
        text-align: center;
        font-size: 1.5em;

    }
    .plceh_date a:link, .plceh_date a:visited{
        text-decoration: none;
        font-weight: bold;
        font-family: 'Comic Sans MS', sans-serif;
        color: black;
    }
    .plceh_date a:hover{
        color: rebeccapurple;
    }
    .plceh_oneday{
        background-color: ghostwhite;
        text-align: center;
    }
    .plceh_oneday_label{
        background-color: #c8b9e2;
        line-height: 2;
        font-family: "Comic Sans MS", cursive;
        font-size: 20px;
        margin-top: 5px;
    }
    .plceh_table{
        display: block;
        /*! width: 100%; */
        min-height: 220px;
    }
    .span33{
        display: inline;
        width: 22%;
        min-height: 200px;

    }
    .span_zagol{
        text-align: center;
        background-color: #ffe9f3;
    }
    .btn{
        bottom: 20px;
    }
    .btn button{
        font-size: 1.2em;
        width: 22em;
        height: 2em;
    }
    .form{
        font-size: 1.6em;
        border: outset 7px aquamarine;
        height: auto;
        width: 400px;
    }
    .mater{
        float: right;
        margin-right: 20px;
        background-color: #097246;
        width: 40px;
        color: #d2f5fa;
        text-align: center;
        font-size: 0.8em;
    }
    .one_part img {
        border-radius: 9px;
        height: 18px;
    }
    .part_order{
        border: solid sandybrown 2px;
    }
    .plceh_graf table{

    }
    .plceh_graf td{
        background-color: lavender;
        width: 80px;
    }
</style>
<div class="content">
    <input type="hidden" id="pole">
    <div class="plceh_graf">
<?php //var_dump($part);?>
        <table>
            <tr>
                <th>Номер</th>
                <th>Примечание</th>
                <?php foreach ($arr_stan as $stan):?>
                    <th><?=$stan;?></th>
                <?php endforeach;?>
            </tr>
            <?php foreach ($part as $con => $partorder):?>
                <?php foreach ($partorder as $partone):?>
                    <tr data-contr="<?=$con?>" data-partid="<?=$partone['id']?>">
                        <td>
                            <?=$con;?>_<span class="psuf"><?=$partone['suf']?></span>
                        </td>
                        <td>
                            <span class="pmater"><?=$partone['note']?></span>
                        </td>
                        <?php foreach ($arr_stan as $ki => $stan):?>
                            <td class="stanpart" style="background-color: <?=$bgcol[$partone[$stan]];?>" data-stan-pole="<?=$stan;?>" data-stan="<?=$partone[$stan];?>"><?=$partone[$arr_stan_date[$ki]];?></td>
                        <?php endforeach;?>
                    </tr>

            <?php endforeach;?>
            <?php endforeach;?>
        </table>
<!--    --><?php //foreach ($part as $con => $partorder):?>
<!--    <div class="part_order">-->
<!--        --><?php //foreach ($partorder as $partone):?>
<!--            <div class="part" data-contr="--><?//=$con?><!--" data-partid="--><?//=$partone['id']?><!--">-->
<!--                <div class="partlabel">-->
<!--                    --><?//=$con;?><!--_<span class="psuf">--><?//=$partone['suf']?><!--</span>-->
<!--                    tab-->
<!--                    <span class="pmater">--><?//=$partone['note']?><!--</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php //endforeach;?>
<!--    </div>-->
<!--    --><?php //endforeach;?>
    </div>
    <div class="plceh_graf btn">

    </div>
    <div class="plceh_list" id="list1">
        <?php for($d=0; $d<30; $d++):?>
            <div class="plceh_oneday">
                <div class="plceh_oneday_label"><?echo $week[date('w', strtotime('today')+$d*24*3600)]. ', ' .date('d.m', strtotime('today')+$d*24*3600)?></div>
                <?php if(isset($orders[$d])):?>
                    <?php foreach($orders[$d] as $key=>$arr):?>
                        <div class="contract" data-oid="<?= $arr['oid'];?>" data-con="<?=$arr['con'];?>">
                            <div class="mater"><?=$arr['mater'];?></div>
                            <div class="for_plan2" id="<?=$arr['oid'].'-'.$arr['stan'];?>"><?=$arr['con'];?></div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        <?php endfor;?>
    </div>
    <div id="fon"></div>
    <div class="form" id="porjadok">
        <div class="form_content">
            <h6>После разбиения на части, в планировании цеха исчезает заказ, который является первоначальным</h6>
            <div class="one_part">
                <img src="/images/0.jpg">
                <input type="text" size="6" value="" readonly>
                _
                <input type="text" class="partpre" size="4" maxlength="5" placeholder="5 символов" required>
                -
                <input type="text" size="8" placeholder="материал">
            </div>
            <button onclick="saveParts(this)">Save</button>
        </div>
    </div>
</div>
<script type="text/javascript">

    var contrbtns = document.getElementsByClassName('contract');
    for(var i=0; i<contrbtns.length; i++){
        contrbtns[i].addEventListener('click',showFormPart);
    }
    var stanbtns = document.querySelectorAll('.stanpart');
    for(var t=0; t<stanbtns.length; t++){
        stanbtns[t].addEventListener('click',changeStanPart);
    }

    function showFormPart() {
        document.getElementById('fon').style.display = "block";
        document.getElementById('porjadok').style.display = "block";
        //очищаем форму
        var bloks = document.getElementsByClassName('one_part'),
            content = document.getElementById('porjadok').firstElementChild;
        for (j=0; j<bloks.length; j++) {
            bloks[j].remove();
        }
        //рисуем форму
        var div = document.createElement('div');
        div.className = 'one_part';
        div.innerHTML = '<span class="del"><img src="/images/0.jpg"></span> ' +
            '<input type="text" size="6" value="" readonly>\n' +
            '_\n' +
            '<input type="text" class="partpre" size="4" maxlength="5" placeholder="5 символов" required>\n' +
            '-\n' +
            '<input type="text" size="8" placeholder="материал">\n';

        content.insertBefore(div, content.lastElementChild);
        content.insertBefore(div.cloneNode(true), content.lastElementChild);

        //заполняем форму
        var oid = this.dataset.oid,
            con = this.dataset.con,
        partsold = document.querySelectorAll('tr[data-contr="'+con+'"]');

        if(partsold.length!=0){
            for (var i=0; i<partsold.length; i++){
                var suff = partsold[i].querySelector('.psuf').innerText,
                    note = partsold[i].querySelector('.pmater').innerText,
                    partId = partsold[i].dataset.partid;
                console.log(partId);
                console.log(suff);
                console.log(note);
                var partdiv = div.cloneNode(true),
                    before = content.querySelector('.one_part'),
                    partpre = partdiv.querySelector('.partpre');
                partpre.value = suff;
                partpre.dataset.partid = partId;
                partdiv.lastElementChild.value = note;
                content.insertBefore(partdiv, before);
            }
        }
        // console.log(partsold);
        content.dataset.oid = oid;
        bloks = document.getElementsByClassName('one_part');
        for (j=0; j<bloks.length; j++) {
            bloks[j].firstElementChild.nextElementSibling.value = con;
            // bloks[j].lastElementChild.addEventListener('blur',checkOtherFields);
            bloks[j].querySelector('.partpre').addEventListener('focus',addNewField);
            bloks[j].firstElementChild.addEventListener('click',deletePart);
        }
    }

    function addNewField() {
        // console.log(this);
        //проверить, сколько пустых полей есть, если нету, создать
        var pusto = false;
        var newbl = this.parentNode.cloneNode(true),
            content = this.parentElement.parentElement;
        var fields = content.querySelectorAll('.partpre');
        for (var k=0; k<fields.length; k++){
            if (fields[k].value == '' && fields[k] != this){
                pusto = true;
            }
        }
        if(!pusto){
            // this.id = '111';
            content.insertBefore(newbl, content.lastElementChild);
            newbl.querySelector('.partpre').addEventListener('focus',addNewField);
            // console.log(fields);
        }
    }

    function deletePart() {
        var btn = this,
            div = this.parentElement,
            pole = this.nextElementSibling.nextElementSibling,
            partid = pole.dataset.partid;
        if(typeof partid != "undefined"){
            $.ajax({
                url:'/plan/deletePart',
                type:'post',
                data:'pid='+partid,
                success:function (data) {
                    if(data == 1){
                        div.remove();
                    }
                }
            });
        }else{
            div.remove();
        }
    }

    function saveParts(btn) {
        var content = btn.parentNode,
            fields = content.querySelectorAll('.partpre'),
            con = content.querySelector('input').value,
            count = fields.length;
        if(count == 2){
            alert('Заказ нужно разделить минимум на 2 части');
            return false;
        }else{
            //читаем непустые
            var preful = 0,
                arr = [];
            for (var k=0; k<count; k++){
                if(fields[k].value != ''){
                    // console.log(fields[k].dataset.partid);
                    preful++;
                    arr.push({"pid":fields[k].dataset.partid,"pre":fields[k].value,"mater":fields[k].nextElementSibling.value});
                }
            }

            if(preful > 1){
                // сохраняем в базу
                $.ajax({
                    url:'/plan/changePart',
                    type:'post',
                    data:'oid='+content.dataset.oid+'&arr='+JSON.stringify(arr),
                    success:function (data) {
                        if(data == 1){
                            location.reload();
                        }
                        console.log(data);
                        alert('Что-то не так! Проверьте на дублирование!')
                    }
                })
            }
            console.log(JSON.stringify(arr));
            return true;
        }

    }

    function changeStanPart() {
        var bgcol = ['lavender','#666666','#33bb00'];
        var td = this,
            pole = this.dataset.stanPole,
            stan = this.dataset.stan,
            newstan = (stan + 1) % 3,
            partid = this.parentElement.dataset.partid;
        $.ajax({
            url:'/plan/changeStanPart',
            type:'post',
            data:'partid='+partid+'&pole='+pole+'&val='+newstan,
            success:function (data) {
                td.dataset.stan = newstan;
                td.style.backgroundColor = bgcol[newstan];
                console.log(data);
            }
        });
        // console.log(partid);
    }
</script>