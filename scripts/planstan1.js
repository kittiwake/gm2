function cleanTable(){
    var table = document.getElementById('tablestan');
    table.innerHTML = '<tr id="trth">' +
    '<th>№ з-за</th>' +
    '<th>вывоз</th> ' +
    '<th>Технолог</th> ' +
    '<th>Просчет</th> ' +
    '<th>Материал</th> ' +
    '<th>Распил</th> ' +
    '<th>ЧПУ</th>' +
    '<th>Кромка</th>' +
    '<th>Криволинейка</th>' +
    '<th>Присадка</th> ' +
    '<th>Гнутье</th> ' +
    '<th>Эмаль</th> ' +
    '<th>ПВХ</th> ' +
    '<th>Фотопечать</th> ' +
    '<th>Пескоструй</th> ' +
    '<th>Витраж</th> ' +
    '<th>oracal</th> ' +
    '<th>Стекло/зеркало</th> ' +
    '<th>Фасады</th> ' +
    '<th>Упакован</th> ' +
    '<th>сроки</th> ' +
    '</tr>';
}
function addlistenerth(){
    var tr = document.getElementById('trth');
    var ths = tr.children;
    //alert(ths[3].innerText);
    for(var i=1; i<19; i++){
        ths[i].addEventListener('click',argumentForFilter);
    }
}
function argumentForFilter(){
    var orderby = arguments[0].currentTarget.cellIndex;
    switch (orderby) {
        case 1:
            showlist('plan');
            break;
        case 2:
            showlist('technologist');
            break;
        case 3:
            showlist('tech_end');
            break;
        case 4:
            showlist('mater');
            break;
        case 5:
            showlist('raspil');
            break;
        case 6:
            showlist('cpu');
            break;
        case 7:
            showlist('kromka');
            break;
        case 8:
            showlist('krivolin');
            break;
        case 9:
            showlist('pris_end');
            break;
        case 10:
            showlist('gnutje');
            break;
        case 11:
            showlist('emal');
            break;
        case 12:
            showlist('pvh');
            break;
        case 13:
            showlist('photo');
            break;
        case 14:
            showlist('pesok');
            break;
        case 15:
            showlist('vitrag');
            break;
        case 16:
            showlist('oracal');
            break;
        case 17:
            showlist('steklo');
            break;
        case 18:
            showlist('fas');
            break;
        case 19:
            showlist('upak_end');
            break;
    }
}

function showlist(oderby){
    cleanTable();
    addlistenerth();
    var end = $('#end').val();
    var begin = $('#begin').val();
    $.ajax({
        url:'/plan/getOrders',
        type:'post',
        data:'end='+end+'&begin='+begin+'&oderby='+oderby,
        dataType:'json',
        success:function(data){
            if(data){
                var itr = 0;
                var regrekl = '/^.*[РрД][1-9]?$/';
                var table = document.getElementById('tablestan');
                for(var key in data){
                    var tr = document.createElement('tr'),
                        td01 = document.createElement('td'),
                        td02 = document.createElement('td'),
                        td03 = document.createElement('td'),
                        td04 = document.createElement('td'),
                        td05 = document.createElement('td'),
                        td06 = document.createElement('td'),
                        td07 = document.createElement('td'),
                        td08 = document.createElement('td'),
                        td09 = document.createElement('td'),
                        td10 = document.createElement('td'),
                        td11 = document.createElement('td'),
                        td12 = document.createElement('td'),
                        td13 = document.createElement('td'),
                        td14 = document.createElement('td'),
                        td15 = document.createElement('td'),
                        td16 = document.createElement('td'),
                        td17 = document.createElement('td'),
                        td18 = document.createElement('td'),
                        td19 = document.createElement('td'),
                        td20 = document.createElement('td'),
                        td21 = document.createElement('td');
                    tr.id = data[key].id;
                    //var contr = data[key].contract;
                    //alert (/^.*[РрД][1-9]?$/.test(data[key].contract));
                    if(/^.*[РрД][1-9]?$/.test(data[key].contract)){
                        tr.className = 'claims';
                    }else{
                        tr.className = 'orders';
                    }
                    tr.className += ' tablerow visible';
                    table.appendChild(tr);
                    tr.appendChild(td01);
                    tr.appendChild(td02);
                    tr.appendChild(td03);
                    tr.appendChild(td04);
                    tr.appendChild(td05);
                    tr.appendChild(td06);
                    tr.appendChild(td07);
                    tr.appendChild(td08);
                    tr.appendChild(td09);
                    tr.appendChild(td10);
                    tr.appendChild(td11);
                    tr.appendChild(td12);
                    tr.appendChild(td13);
                    tr.appendChild(td14);
                    tr.appendChild(td15);
                    tr.appendChild(td16);
                    tr.appendChild(td17);
                    tr.appendChild(td18);
                    tr.appendChild(td19);
                    tr.appendChild(td20);
                    tr.appendChild(td21);
                    td01.innerHTML = data[key].contract;
                    td01.addEventListener("click",chooseRow);
                    var term = new Date(data[key].term);
                    var plan = new Date(data[key].plan);
                    if(plan>term){
                        td01.style.backgroundColor='#ffc8c8';
                    }
                    td21.innerHTML = ('0' + term.getDate()).slice(-2) + '.' + ('0' + (term.getMonth() + 1)).slice(-2);
                    td02.innerHTML = ('0' + plan.getDate()).slice(-2) + '.' + ('0' + (plan.getMonth() + 1)).slice(-2);
                    td02.addEventListener("click",showChangeDate);
                    td03.innerHTML = data[key].tech;
                    contentTD(data[key].tech_end,td04,'tech_end');
                    contentTD(data[key].mater,td05,'mater');
                    contentTD(data[key].raspil,td06,'raspil');
                    contentTD(data[key].cpu,td07,'cpu');
                    contentTD(data[key].kromka,td08,'kromka');
                    contentTD(data[key].krivolin,td09,'krivolin');
                    contentTD(data[key].pris_end,td10,'pris_end');
                    contentTD(data[key].gnutje,td11,'gnutje');
                    contentTD(data[key].emal,td12,'emal');
                    contentTD(data[key].pvh,td13,'pvh');
                    contentTD(data[key].photo,td14,'photo');
                    contentTD(data[key].pesok,td15,'pesok');
                    contentTD(data[key].vitrag,td16,'vitrag');
                    contentTD(data[key].oracal,td17,'oracal');
                    contentTD(data[key].steklo,td18,'steklo');
                    contentTD(data[key].fas,td19,'fas');
                    contentTD(data[key].upak_end,td20,'upak_end');

                    //
                    orderNotes(tr);
                    //alert(notes);
                }
                addLines();
            }
        }
    })
}

var clickFlag = true;
function contentTD(val,td,pole){
    td.classList.add(pole);
    if(val == 0){
        td.classList.add('cl0');
        //td.style.backgroundColor = '#CCFFFF';//rgb(204, 255, 255)
    }
    else if(val == 1){
        td.classList.add('cl1');
        //td.style.backgroundColor = '#666666';//rgb(102, 102, 102)
    }
    else{
        td.classList.add('cl2');
        //td.style.backgroundColor = '#33bb00';//rgb(51, 187, 0)
    }
    if(pole!='tech_end'){
        td.classList.add('cell');
    }
    td.style.fontSize = '0.7em';

    td.innerHTML = '&nbsp';
    //td.onclick = changeStanBoss;
    td.addEventListener("click", changeStanBoss);
    //td.addEventListener('contextmenu', stopDefAction, false);
    td.addEventListener("contextmenu", contextmenuCell);
}

function orderNotes(tr){
    var oid = tr.id;
    $.ajax({
        type:'post',
        url:'/plan/getOrderNotes',
        data:'oid='+oid,
        dataType:'json',
        success:function(data){
            if(data){
                var tds = tr.children;
                for(var i=0; i<data.length; i++){
                    for(var j=0; j<tds.length; j++){
                        if(tds[j].classList.contains(data[i].pole)){
                            tds[j].innerHTML = data[i].noteboss;
                        }
                    }
                }
            }
        }
    })
}

function contextmenuCell(evt){
    evt.preventDefault();
    //<this> : td.mater.cl2
    var pole = this.className.split(' ')[0];
    var oid = this.parentElement.id;
    var note = this.innerText;
    var inp = document.createElement('TEXTAREA');
    inp.value = note;
    this.innerHTML = '';
    this.appendChild(inp);
    //inp.autofocus = true;
    inp.focus();
    listenerOnOff(false);
    inp.addEventListener('blur',formHide);
}

function listenerOnOff(onoff){
    var allCells = document.getElementsByClassName('cell');
    if(onoff){
        for(t=0; t<allCells.length; t++){
            allCells[t].addEventListener("click", changeStanBoss);
        }
    }else{
        for(t=0; t<allCells.length; t++){
            allCells[t].removeEventListener("click", changeStanBoss);
        }
    }
}

function formHide(){
    var txt = this.value;
    var td = this.parentElement;
    var pole = td.className.split(' ')[0];
    var oid = td.parentNode.id;
    //если поле пустое, полностью удалить запись из бд
    var pusto = /^\s*$/;
    if(pusto.test(txt)){
        $.ajax({
            type:'post',
            url:'/plan/delNoteBoss',
            data:'oid='+oid+'&pole='+pole
        });
    }else{
        $.ajax({
            type:'post',
            url:'/plan/addNoteBoss',
            data:'oid='+oid+'&pole='+pole+'&note='+txt
        });
    }
    td.innerHTML = txt;
    listenerOnOff(true);
}

function changeStanBoss(){
    if(!this.classList.contains('tech_end')){
        var oid = this.parentNode.id;
        var cl = 0;
        var classname = this.className;
        var pole = classname.split(' ')[0];
        if(this.classList.contains('cl0')){
            this.classList.remove('cl0');
            this.classList.add('cl1');
            cl = 1;
        }
        else if(this.classList.contains('cl1')){
            this.classList.remove('cl1');
            this.classList.add('cl2');
            cl = 2;
        }
        else{
            this.classList.remove('cl2');
            this.classList.add('cl0');
        }
        $.ajax({
            url:'/plan/changeStan',
            type:'post',
            data:'oid='+oid+'&pole='+pole+'&val='+cl,
            access:function(data){
                if(!data || typeof data == 'undefined'){
                    alert('что-то не получилось');
                    this.className = classname;
                }
            }
        })
    }
}

function ChangeDate(){
    var btn = arguments[0];
    var olddate = arguments[1];
    var td = btn.parentNode;
    var oid = btn.parentNode.parentNode.id;
    var newdate = btn.previousElementSibling.value;
    if(newdate.search(/(\d+)-(\d+)-(\d+)/)==0)
    {
        var datetodb = newdate.replace(/(\d+)-(\d+)-(\d+)/, "$3-$2-$1");
        //alert(datetodb);
        $.ajax({
            type:'post',
            url: '/order/transfer',
            data:'oid='+oid+'&date='+datetodb,
            success:function(data){
                if(data){
                    td.innerHTML = newdate.replace(/(\d+)-(\d+)-(\d+)/, "$1.$2");
                }
            }
        });
    }else{
        //alert(arguments[1]);
        td.innerHTML = '';
        //alert(olddate);
        td.innerHTML =String(olddate);
    }
    clickFlag = false;
    td.addEventListener("click",showChangeDate);
    var p = 1;
}
function showChangeDate(){
    if(clickFlag){
        var txt = this.innerText;
        if(txt.search(/(\d+).(\d+)/)==0){
            this.removeEventListener("click", showChangeDate);
            this.innerHTML = '<input type="text" size=8 value="' + txt + '" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"> ' +
            '<button onclick="ChangeDate(this,\''+txt+'\')">ok</button>';
        }
    }
    else{
        clickFlag = true;
    }
}

function chooseRow(){
    var tds = document.getElementsByTagName('td');
    for(var i=0; i<tds.length; i++){
        tds[i].style.opacity = 1;
    }
    var tr = this.parentNode;
    var chtr = tr.children;
    for(var i=0; i<chtr.length; i++){
        chtr[i].style.opacity = 0.7;
    }
}

function displayTable(what){
    var btnall = document.getElementById('btnall'),
        btnord = document.getElementById('btnord'),
        btnclm = document.getElementById('btnclm');
    var allrows = document.getElementsByClassName('tablerow');
    if(what=='orders'){
        for(var i=0; i<allrows.length; i++){
            if(allrows[i].classList.contains('claims')){
                allrows[i].classList.toggle('visible',false);
                allrows[i].classList.toggle('tablenone',true);
            }else{
                allrows[i].classList.toggle('tablenone',false);
                allrows[i].classList.toggle('visible',true);
            }
        }
        btnall.disabled = false;
        btnord.disabled = true;
        btnclm.disabled = false;
    }
    else if(what=='claims'){
        for(var i=0; i<allrows.length; i++){
            if(allrows[i].classList.contains('orders')){
                allrows[i].classList.toggle('visible',false);
                allrows[i].classList.toggle('tablenone',true);
            }else{
                allrows[i].classList.toggle('tablenone',false);
                allrows[i].classList.toggle('visible',true);
            }
        }
        btnall.disabled = false;
        btnord.disabled = false;
        btnclm.disabled = true;
    }else{
        for(var i=0; i<allrows.length; i++){
            allrows[i].classList.toggle('tablenone',false);
            allrows[i].classList.toggle('visible',true);
        }
        btnall.disabled = true;
        btnord.disabled = false;
        btnclm.disabled = false;
    }
    addLines();
}

function addLines(){
    var table = document.getElementById('tablestan');
    //удалить все предыдущие клоны
    var clones = document.getElementsByClassName('clonetr');
    var numcl = clones.length;
    //for(var k=0; k<numcl; k++){
    //    clones[k].remove();
    //}
    var i
    for (i=clones.length; i>0; i--) {
        clones[i-1].parentNode.removeChild(clones[i-1])
    }
    var allrows = document.getElementsByClassName('visible');
    var previosdate = '00.00';
    var itr = 1;
    for(var i=0; i<allrows.length; i++){
        var tr = allrows[i];
        var date = tr.children[1].innerText;
        if(itr%10==0){
            if(date!=previosdate){
                //клонируем
                var clontr = document.getElementById('trth').cloneNode(true);
                //    //var div2 = div.cloneNode(true);
                clontr.id = 'trth'+itr;
                clontr.classList.add('clonetr');
                //    table.appendChild(clontr); parentElem.insertBefore(elem, nextSibling)
                table.insertBefore(clontr,tr);
                itr++;
            }
        }else{
            itr++;
        }
        previosdate = date;
    }
    return true;
}