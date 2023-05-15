function showForm1(date){
    $('#fon').show();
    $('#form1').show();
    //список отгрузок на указ дату
    $.ajax({
        type:'post',
        url:'/logistic/getOrderList',
        dataType:'json',
        data:'date='+date,
        success: function(data){
            var html = '<option value="0"> </option>';
            for(var i=0; i<data.length; i++){
                html += '<option value="'+data[i]['oid']+'">'+data[i]['contract']+'</option>';
            }
            $('#form1 select').html(html);
        }
    });
}

function showForm2(){
    $('#fon').show();
    $('#form2').show();
}

function showForm4(lid,auto){
    if (auto === undefined) {
        auto = '';
    }
    $('#fon').show();
    $('#form4').show();
    $('#logid').val(lid);
    $('#logauto').val(auto);
}

function showForm3(lid){
    $('#fon').show();
    $('#form3').show();
    $('#logid').val(lid);
}

function getInfo(oid){
    $.ajax({
        type:'post',
        url:'/logistic/getOrderInfo',
        dataType:'json',
        data:'oid='+oid,
        success:function(data){
            $('#address').html(data['adress']);
            $('#sum').val(data['sum']);
            $('#predopl').val(data['prepayment']);
            if(data['beznal']==0 && data['rassr']==0 && data['rekl']==0){
                $('#ostatok').val(data['sum']-data['prepayment']);
            }else{
                $('#ostatok').val('');
            }
        }
    })
}

function delLogist(lid){
    $.ajax({
        type:'post',
        url:'/logistic/delete',
        data:'lid='+lid,
        success:function(data){
            if(data==1){
                $('#'+lid).remove();
            }
        }
    })
}

function updateLogist(elem){
    //function updateSample(elem){
        var update = elem.className;//show
        var tr = elem.parentNode.parentNode,//tr id="id"
            oid = tr.id;
        if (update == 'show'){
            var divchildren = tr.getElementsByTagName('td');
            for (var i = 0; i < divchildren.length; i++)
            {
                if (divchildren[i].classList.contains('change')) {
                    var text = divchildren[i].innerHTML;
                    var newstr = text.replace(/\s{2,}/g, "");
                    var r = 2,
                        c = 10;
                    if(divchildren[i].classList.contains('addr') || divchildren[i].classList.contains('note')){
                        r = 3;
                        c = 30;
                    }
                    divchildren[i].innerHTML = '<textarea rows="'+r+'" cols="'+c+'">'+newstr+'</textarea>' +
                    '<input type="hidden" value="'+newstr+'"/>';
                }
            }
            //alert(elem.tagName);
            elem.className = 'update';
            elem.src = '/images/save.png';
            elem.nextElementSibling.style.display = 'none';
            elem.nextElementSibling.nextElementSibling.style.display = 'none';
        }else if(update == 'update'){
            var divchildren = tr.getElementsByTagName('td'),
                data = '',
                rename = false,
                del = false;
            for (var i = 0; i < divchildren.length; i++){
                if (divchildren[i].classList.contains('change')) {
                    var chtextarea = divchildren[i].firstElementChild,
                        chhidden = divchildren[i].lastElementChild;
                    var old_val = chhidden.value,
                        new_val = chtextarea.value;
                //проверить на переименование поставщика
                    if(i==0&&old_val!=new_val){
                        rename = true;
                        //запрос на разрешение переименовывать
                        $.ajax({
                            type:'post',
                            url:'/logistic/checkForRename',
                            data:'point='+new_val,
                            async:false,
                            success:function(data){
                                if(data == 1){
                                    //рисуем окно с предупреждением об удалении
                                    del = confirm("Вы не можете переименовать поставщика! Вся логистика для " + new_val + " вносится через график снабжения. Удалите данный рейс и внесите все данные через интерфейс снабжения!");
                                }
                            }
                        });
                    }
                    if(!rename){
                        divchildren[i].innerHTML = new_val;
                        data = data + '&' + divchildren[i].classList[1] + '=' + new_val;
                    }else if(!del){
                        divchildren[i].innerHTML = old_val;
                    }
                }
            }
            if(!rename){
                    $.ajax({
                        type:'post',
                        data:'oid='+oid+data,
                        url:'/logistic/updateInfo',
                        success: function(data){
                            if (data){
                                elem.className = 'show';
                                elem.src = '/images/proposta.gif';
                                elem.nextElementSibling.style.display = 'inline';
                                elem.nextElementSibling.nextElementSibling.style.display = 'inline';
                            }else{
                                alert("Не все изменения внесены. Таблица обновится автоматически, проверьте данные");
                                location.reload();
                            }
                        }
                    });
                    
            }else{
                if(!del){
                    elem.className = 'show';
                    elem.src = '/images/proposta.gif';
                    elem.nextElementSibling.style.display = 'inline';
                    elem.nextElementSibling.nextElementSibling.style.display = 'inline';
                }else{
                    delLogist(oid);
                }
            }   
            
        }
    //}
}

function transposition(){
    var lid = $('#logid').val(),
        logauto = $('#logauto').val(),
        newdate = $('#term').val();
    $.ajax({
        type:'post',
        url:'/logistic/update',
        data:'lid='+lid+'&date='+newdate+'&logauto='+logauto,
        success:function(data){
            if(data==1){
                $('#'+lid).remove();
            }
            $('#fon').hide();
            $('.form').hide();
            //alert(data)
        }
    })
}

function changeDriver(){
    var lid = $('#logid').val(),
        uid = $('#form3 input[type="radio"]:checked').val(),
        name = $('#form3 input[type="radio"]:checked').parent().text();
    if(uid == 0) name = 'назначить'
    $.ajax({
        type:'post',
        url:'/logistic/updateDriver',
        data:'lid='+lid+'&uid='+uid,
        success:function(data){
            if(data==1){
                $('#'+lid+' td:nth-child(5)').html(name);
                //alert(name);
            }
            $('#fon').hide();
            $('.form').hide();
            //alert(data)
        }
    })
}
function tapChangeSumLog(td, event){
    if(event.target == td) {
        var lid = td.parentNode.id,
            val = $(td).text();
        //alert(this);
        //проверка наличия на странице input id="newlogsum"
        if(document.getElementById('newlogsum') ==  null) {
            td.innerHTML = '<input type="text" id="newlogsum" size="12"><button onclick="changeSumLog(this.parentNode,' + val + ');">OK</button>';
        }
    }
}

function changeSumLog(td,lastval) {
    var lid = td.parentNode.id,
        val = document.getElementById('newlogsum').value;
    if (val != "") {
        $.ajax({
            url: '/logistic/changeSum/',
            type: 'post',
            data: 'lid=' + lid + '&sum=' + val,
            success: function (data) {
                if (data && data != 0) {
                    td.innerHTML = val;
                }
            }
        })
    } else {
        td.innerHTML = lastval;
    }
}
function showinpAddr(btn,id){
    var divtext = btn.parentElement,
        divinp = divtext.nextElementSibling;
        
    //скрыть
    divtext.classList.add("hidden");
    
    //показать
    divinp.classList.remove("hidden");
}
function saveProvAddr(btn,id){
    var inp = btn.previousElementSibling,
        divinp = btn.parentElement,
        divtext = divinp.previousElementSibling;
        $.ajax({
            type:'post',
            url:'/logistic/updateProvidersAddress',
            data:'provid='+id+'&address='+inp.value,
            success: function(){
                divtext.firstElementChild.innerText = inp.value;
        console.log(divtext);
            }
        });
        console.log(id);
        console.log(inp.value);
    //скрыть
    divinp.classList.add("hidden");
    
    //показать
    divtext.classList.remove("hidden");
}

