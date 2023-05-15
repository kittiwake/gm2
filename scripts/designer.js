function showChangeNote(elem){
    var block = document.getElementById('change');
    block.style.left = parseInt(document.documentElement.clientWidth)/2 - 150 + "px";
    block.style.top = parseInt(document.documentElement.clientHeight)/2 - 100 + "px";
    $('#change').show();
    $('#fon').show();
    var oid = elem.parentNode.parentNode.id;
    //заполнить текстом поле
    var el = elem.parentNode;
    var ch_el = el.childNodes[1];
    var str = $(ch_el).html();
    var newstr = str.replace(/\s{2,}/g, "");
    var str_p = newstr.split('<p><b>');
    var str0 = str_p[0];
    document.getElementById('note_change').innerHTML = '<textarea id="new_note" rows="6" cols="30">' + str0 + '</textarea>';
    document.getElementById('full_note').innerHTML = newstr;
    document.getElementById('old_note').innerHTML = str0;
    document.getElementById('oid3').value = oid;
}

function changeSampleNote(){
    var ful_str = document.getElementById('full_note').innerHTML,
        old_note = document.getElementById('old_note').innerHTML,
        oid = document.getElementById('oid3').value,
        str = document.getElementById('new_note').value;
    $('#change').hide();
    $('#fon').hide();
    if(old_note != str){
        var newstr = ful_str.replace(old_note, str);
        alert(newstr);
        $.ajax({
            type:'post',
            url:'/designer/changePole',
            data:'oid='+oid+'&pole=note&val='+newstr,
            success:function(data){
                if(data){
                    location.reload();
                }
            }
        })
    }
}

function delSampleManager(elem){
    var oid = elem.parentNode.parentNode.id;
    var res = delSample(oid);
    console.log(res);
    if(res){
        document.getElementById(oid).style.display='none';
    }
}

function delSampleDis(elem){
    var el = elem.parentNode.parentNode;
    var oid = el.id;
    var res = delSample(oid);
    if(res){
        document.getElementById(oid).style.display='none';
    }
}

function delSample(oid){
    var res;
    $.ajax({
        type:'post',
        url:'/designer/deleteSample',
        data:'oid='+oid,
        async: false,
        success:function(data){
            res = data;
        }
    });
    return res;
}

function changeStanMen(elem){
    var oid = elem.parentNode.parentNode.id;
    $.ajax({
        type:'post',
        url:'/designer/changePole',
        data:'oid='+oid+'&pole=stan&val=tekuch',
        success:function(data){
            if(!data){
                alert('Где-то возникла ошибка');
            }else{
                alert('Запись восстановлена, ищите в таблице замеров.')
                $('#'+oid).hide();
            }
        }
    });
}

function addNoteDis(elem){
    var el = elem.parentNode.parentNode;
    var oid = el.id;
    var note = prompt('Примечание:', '');
    if(note != null && note != ''){
        //дописать в примечания
        $.ajax({
            type:'post',
            url:'/designer/addNote',
            data:'oid='+oid+'&note='+note,
            success:function(data){
                if(data){
                    $('#notes'+oid).append(data+' '+note);
                }
            }
        });
    }
}

function changeStanDisN(elem, stan){
    var el = elem.parentNode.parentNode;
    var oid = el.id;
    var dop = '';
    if(stan == 'otkaz'){
        var note = prompt('Укажите причину отказа', '');
        if (note != null && note != ''){
            dop = '&note='+note;
        }
    }
    if(stan == 'zakluchen'){
        var sum = prompt('Сумма договора', '');
        if(sum != null && sum != ''){
            sum = sum.replace(/\D/g, "");
            var pred = prompt('Предоплата', '');
            if(pred != null && pred != ''){
                pred = pred.replace(/\D/g, "");
                var nal = confirm('Наличными - нажмите ОК (Enter) или безналом - Отмена (ESC)');
                dop = '&sum='+sum+'&pred='+pred+'&nal='+nal;
            }
        }
    }
    if(stan == 'tekuch' || dop != '' || stan == 'arhiv'){
        $.ajax({
            type:'post',
            url:'/designer/changePole',
            data:'oid='+oid+'&pole=stan&val='+stan+dop,
            success:function(data){
                if(data){
                    if(stan == 'tekuch' || stan == 'arhiv'){
                        location.reload();
                    }else if(stan == 'otkaz'){
                        setTimeout(function () {
                            $('#' + oid).parent().hide()
                        }, 1000);
                    }else{
                        //кнопки сдан договор и сданы деньги
                        var cont = '<input type="hidden" value="" id="ren'+oid+'">' +
                                   '<input type="button" value="Договор сдан" onclick="changeRender(this, \'contract\');">' +
                                   '<input type="button" value="Деньги сданы" onclick="changeRender(this, \'money\');">';
                        elem.parentNode.innerHTML = cont;
                    }
                }
            }
        });
    }
}

function changeRender(elem, newrender){
    var el = elem.parentNode.parentNode;
    var oid = el.id,
        render = $('#ren'+oid).val();
    if(render == 'contract' || render == 'money') newrender = 'all';
    $.ajax({
        type:'post',
        url:'/designer/changePole',
        data:'oid='+oid+'&pole=render&val='+newrender,
        success:function(data){
            if(data){
                $('#ren'+oid).val(newrender);
                if(newrender == 'all'){
                    elem.parentNode.parentNode.style.display = "none";
                }else{
                    elem.style.display = "none";
                }
            }
        }
    });
}

function textarea(dom){
    var div = dom.getElementsByTagName('div')[0];
    var text = div.innerHTML;
    var check = div.getElementsByTagName('textarea')[0];
    if(check == 'undefined'){
        var newstr = text.replace(/\s{2,}/g, "");
        div.innerHTML = '<textarea rows="1" cols="10">'+newstr+'</textarea>';
        var val = div.innerHTML;
        var textar = div.getElementsByTagName('textarea')[0];
    }
}

$('.change').dblclick(function(){
        textarea(this);
    }
);

function updateSample(elem){
    var update = elem.className;
    var tr = elem.parentNode.parentNode,
        oid = tr.id;
    if (update == 'show'){
        var divchildren = tr.getElementsByTagName('div');
        for (var i = 0; i < divchildren.length; i++)
        {
            if (divchildren[i].classList.contains('change')) {
                var text = divchildren[i].innerHTML;
                var newstr = text.replace(/\s{2,}/g, "");
                var r = 1,
                    c = 10;
                if(divchildren[i].classList.contains('addr')){
                    r = 3;
                    c = 70;
                }
                divchildren[i].innerHTML = '<textarea rows="'+r+'" cols="'+c+'">'+newstr+'</textarea>' +
                '<input type="hidden" value="'+newstr+'"/>';
            }
        }
        elem.className = 'update';
        elem.innerHTML = 'Сохранить';
        elem.nextElementSibling.disabled = 'disabled';
        elem.previousElementSibling.disabled = 'disabled';
    }else if(update == 'update'){
        var divchildren = tr.getElementsByTagName('div'),
            data = '';
        for (var i = 0; i < divchildren.length; i++){
            if (divchildren[i].classList.contains('change')) {
                var chtextarea = divchildren[i].firstElementChild,
                    chhidden = divchildren[i].lastElementChild;
                var old_val = chhidden.value,
                    new_val = chtextarea.value;
                divchildren[i].innerHTML = new_val;
                data = data + '&' + divchildren[i].classList[1] + '=' + new_val;
            }
        }
        $.ajax({
            type:'post',
            data:'oid='+oid+data,
            url:'/designer/changeAll',
            success: function(data){
                if (data){
                    elem.className = 'show';
                    elem.innerHTML = 'Редактировать';
                    elem.nextElementSibling.disabled = '';
                    elem.previousElementSibling.disabled = '';
                }else{
                    alert("Не все изменения внесены. Таблица обновится автоматически, проверьте данные");
                    location.reload();
                }
            }
        });
    }
}




