window.addEventListener('load',function(){
    pererahSumm();
    var dbval,
        prov_inputs = document.getElementsByClassName('provider-item');
    if(prov_inputs){
        for(var i=0; i<prov_inputs.length; i++){
            prov_inputs[i].addEventListener('focus',createInpProvider);
            prov_inputs[i].addEventListener('blur',function(){
                var val = this.value.toUpperCase();//перевели в верхний регистр
                //удалить лишние пробелы
                val = val.replace(/^\s+/,'');
                val = val.replace(/\s+$/,'');
                val = val.replace(/\s{2,}/,' ');
                if(dbval!=val){
                    var catid = this.parentNode.parentNode.dataset.catid,
                        selects = document.getElementsByClassName('prov_'+catid);
//                        var div = this.parentNode;
                    $.ajax({
                        url:'/delivery/AddProvider',
                        type:'post',
                        data:'provname='+val+'&catid='+catid,
                        success:function(data){
                            //добавить в список select
                            if(selects){
                                for(var c=0; c<selects.length; c++)
                                {
                                    var opt = new Option(val, data);
                                    selects[c].appendChild(opt);
                                }
                            }
                        }
                    });
                }
            });
        }
    }

    var delivselects = document.getElementsByClassName('deliv-select'),
        currentval_prov = '';
    console.log(delivselects);
    if(delivselects){
        for(var f=0; f<delivselects.length; f++){
            delivselects[f].addEventListener('focus', function () {
                currentval_prov = this.value;
            });
            delivselects[f].addEventListener('change',function(){
                var inpudat = this;
                setTimeout(function(){
                    var newval = inpudat.value,
                        tr = inpudat.parentNode.parentNode,
                        pole = 'prov_id',
                        oid = document.getElementById('oid').value,
                        materid = tr.dataset.materid,
                        contr = tr.dataset.con,
                        money = tr.querySelector('.input_summ').value,
                        plandate = tr.querySelector('.deliv-input_date').value.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1'),
                        logistid = tr.dataset.logistid;
                    console.log(currentval_prov);
                    console.log(newval);
                    if (currentval_prov!=newval) {
                        $.ajax({
                            url:'/delivery/ChangeSnabPole',
                            type:'post',
                            data:'param='+pole+'&date='+plandate+'&provid='+newval+'&summ='+money+'&idlogist='+logistid+'&con='+contr+'&idmater='+materid+'&oid='+oid,
                            success:function(data){
                                console.log(data);
                                if(!data){
                                    location.reload();
                                }
                                if(data.search( /log/i )!=-1){
                                    var logid = data.replace("log", "");
                                    tr.dataset.logistid = logid;
                                }
                            }
                        });
                    }
                },500);

            });
        }
    }
    var delivinputs = document.getElementsByClassName('deliv-input');
    if(delivinputs){
        var currentval_val = '';
        for(var j=0; j<delivinputs.length; j++){
            delivinputs[j].addEventListener('focus', function(){
                currentval_val = this.value;
            });
            delivinputs[j].addEventListener('change',function(){
                pererahSumm();
                var newval = this.value,
                    idlogist = this.parentNode.parentNode.dataset.logistid,
                    materid = this.parentNode.parentNode.dataset.materid;
                // console.log(materid);
//                        console.log(newval);
                if(this.classList.contains('input_summ')){
                    $.ajax({
                        url:'/delivery/ChangeSumm',
                        type:'post',
                        data:'idmater='+materid+'&idlogist='+idlogist+'&summ='+newval+'&oldval='+currentval_val,
                        success:function(data){
                            console.log(data);
                            if(!data){
                                location.reload();
                            }
                        }
                    })
                }
                else{
                    $.ajax({
                        url:'/delivery/ChangeCount',
                        type:'post',
                        data:'idmater='+materid+'&count='+newval,
                        success:function(data){
                            console.log(data);
                            if(!data){
                                location.reload();
                            }
                        }
                    })
                }
            });
        }
    }
    var inputs_date = document.getElementsByClassName('deliv-input_date'),
        currentval_date = '';
    if(inputs_date){
        for(var d=0; d<inputs_date.length; d++){
            inputs_date[d].addEventListener('focus',function () {
                currentval_date = this.value.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1');
            });
            inputs_date[d].addEventListener('blur',function(){
                var inpudat = this;
                //проверить открытый календарь
                var calend = document.getElementById('fc');
                // if(calend.style.display!='none'){
                //     setTimeout(function (){inpudat.click();}, 0);
                // }
                setTimeout(function(){
                    var newval = inpudat.value.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1'),
                        tr = inpudat.parentNode.parentNode,
                        pole = 'plan_date',
                        oid = document.getElementById('oid').value,
                        materid = tr.dataset.materid,
                        contr = tr.dataset.con,
                        money = tr.querySelector('.input_summ').value,
                        provid = tr.querySelector('.deliv-select').value,
                        logistid = tr.dataset.logistid;
                    // console.log(currentval_date);
                    // console.log(newval);
                    if (currentval_date!=newval) {
                        $.ajax({
                            url:'/delivery/ChangeSnabPole',
                            type:'post',
                            data:'param='+pole+'&date='+newval+'&summ='+money+'&idlogist='+logistid+'&provid='+provid+'&con='+contr+'&idmater='+materid+'&oid='+oid,
                            success:function(data){
                                console.log(data);
                                if(!data){
                                    location.reload();
                                    if(data.search( /log/i )!=-1){
                                        var logid = data.replace("log", "");
                                        tr.dataset.logistid = logid;
                                    }
                                }
                            }
                        });
                    }
                },500);
            })
        }
    }
    var catins = document.getElementsByClassName('catins'),
        currentval_catins = '';
    for(var f=0; f<catins.length; f++){
        catins[f].addEventListener('focus', function () {
            currentval_catins = this.value;
        });
        catins[f].addEventListener('change',function(){
            var inpdat = this;
            setTimeout(function(){
                var newval = inpdat.value,
                    tr = inpdat.parentNode.parentNode,
                    mid = tr.dataset.materid,
                    oid = document.getElementById('oid').value,
                    o = tr.dataset.otd;
                    // materid = tr.dataset.materid,
                    // contr = tr.dataset.con,
                    // money = tr.querySelector('.input_summ').value,
                    // plandate = tr.querySelector('.deliv-input_date').value.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1'),
                    // logistid = tr.dataset.logistid;
                    // console.log(currentval_prov);
                    // console.log(newval);
                    if (currentval_catins!=newval) {
                        $.ajax({
                            url:'/delivery/ChangeCategoryToMater',
                            type:'post',
                            data:'catid='+newval+'&mid='+mid,
                            success:function(data){
                                // console.log(data);
                                if(!data){
                                    location.assign('http://grafik-gm.ru/delivery/order/'+oid+'?otd='+o);
                                }else{
                                    inpdat.parentNode.innerHtml=newval;
                                }
                                if(data.search( /log/i )!=-1){
                                    var logid = data.replace("log", "");
                                    tr.dataset.logistid = logid;
                                }
                            }
                        });
                    }
                },100);
        });
    }
    
// var paramsString = document.location.search; // ?page=4&limit=10&sortby=desc  
// var searchParams = new URLSearchParams(paramsString);
    
// searchParams.get("page"); // 4
// searchParams.get("sortby"); // desc

    var paramsString = document.location.search; // ?otd=undefined?outlay=0
    var searchParams = new URLSearchParams(paramsString);
    
    if(searchParams.has('outlay') && searchParams.get('outlay')!=0){
        // console.log(searchParams.get('outlay'));
        var trtr = document.querySelectorAll("tr[data-logistid]"),
            olid = searchParams.get('outlay');
        for(var t=0; t<trtr.length; t++){
        var status = trtr[t].children[1].bgColor;
        // console.log(status);
            if(trtr[t].dataset.logistid == 0 && trtr[t].dataset.outlay == 0 && status == 'lavender'){
                var btn = document.createElement('button'),
                    mid = trtr[t].dataset.materid;
                btn.innerHTML = 'В смету';
                trtr[t].lastElementChild.append(btn);
                btn.addEventListener('click', addMaterToOutlay);
            }
        }
    }
    
    function addMaterToOutlay(){
        console.log(this.parentElement.parentElement);
        var btn = this,
            tr = btn.parentElement.parentElement,
            matid = tr.dataset.materid;
        $.ajax({
            url:'/delivery/UpdateToOutlay',
            type:'post',
            data:'mid='+matid+'&olid='+olid,
            success: function(data){
                if(data == 1){
                    btn.remove();
                }
            }
        });
    }
    
    function createInpProvider(){
        dbval = this.value;
        var inp = document.createElement('input');
        inp.type = 'text';
//                    <input type="text" placeholder="..." class="provider-item">
        inp.className = 'provider-item';
        inp.placeholder = '...';
        this.parentNode.appendChild(inp);
        inp.addEventListener('focus',createInpProvider);
    }

    function pererahSumm(){
        var summs = document.getElementsByClassName('input_summ');
        if(summs){
            var limit = parseFloat(document.getElementById('limit').innerText),
                polezatr = document.getElementById('zatrat'),
                zatr = 0;
            for(var s=0; s<summs.length; s++){
                var curr = parseFloat(summs[s].value);
                if(isNaN(curr)){curr = 0;}
                zatr += curr;
            }
            if(zatr>limit){
                polezatr.style.color = 'red';
            }
            else{
                polezatr.style.color = 'green';
            }
            polezatr.innerHTML = zatr;
        }
    }

});
