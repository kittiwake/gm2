var surpage = window.location.pathname;
var dir = surpage.split('/')[1];

function checkDublication (con){
 //   alert('/'+dir+'/new/checkDublication/'+con);

    $.ajax({
        url: '/'+dir+'/new/checkDublication/'+con,
        success: function(data){
            if(data){
                alert (data);
            }
        }
    })

}

function closeOrder(oid){
 //   alert(oid);
    var ri = $.cookie('ri');
    if(ri!=3){
        $.ajax({
            url: '/'+dir+'/collector/close/'+oid,
            success: function(data){
                if(data){
                    if(data == 1){
                        $('#div'+oid).html('<p>Закрыт</p>');
                    }else{
                        alert('Есть незакрытые рекламации или довозы')
                    }
                }
            }
        });
    }
}

function rewrite(domid){
    var inpname = domid.substring(1);
    var divid = 'div'+ inpname;
    $('#'+divid).html('<input type="text" name="'+inpname+'" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>');
}

function rewritesb(domid){
    var inpname = domid.substring(1);
    var divid = 'div'+ inpname;
    $.ajax({
        url: '/'+dir+'/assembly/getName',
        dataType: 'json',
        success: function(data){
            var div = '<select name="'+inpname+'"><option value="0"> </option>';
            for (var key in data) {
                if (data.hasOwnProperty(key) &&
                    /^0$|^[1-9]\d*$/.test(key) &&
                    key <= 4294967294) {

                    div += '<option value="'+key+'">'+data[key]+'</option>';
                }
            }
            div += '</select>';
            $('#'+divid).html(div);
        }
    });
}

function killCookies(){
    $.cookie('uid', null, { expires: -1});
}

function showCollector(uid){
    $('.tables').hide();
    $('#div'+uid).show();
}

function inPlanirovanie(pole){
    $('.plan_ass').hide();
    $('#in_'+pole).show();
    $('.ass_cell').removeClass("active");
    $('.ass_cell').addClass("passive");
    $('#'+pole).removeClass("passive");
    $('#'+pole).addClass("active");
}

function saveMounting(domid,greed){
    //проверка прав
    var ri = $.cookie('ri');
    if(ri!=3){
        var oid = domid.substring(2);
        var sdate = $('#d'+oid).val();
        var coll, collname;
        if($('#sb'+oid)){
            coll = $('#sb'+oid).val();
            collname = $('#sb'+oid+' option:selected').html();
        }else{
            coll = 'no';
        }
        $.ajax({
            url:'/'+dir+'/assembly/setChanges',
            type:'post',
            data: 'oid='+oid+'&uid='+coll+'&date='+sdate+'&greed='+greed,
            success: function(data){
                $('#namecoll'+oid).html(collname);
                $('#datecoll'+oid).html(sdate);
                if(data){
                    $('#str'+oid).hide();
                }
            }
        });
    }
}

function changeColl(domid){
    var id = domid.substring(2);
    var oid = id.split('d')[0];
    var colldate = id.split('d')[1];

    var coll = $('#sc'+id).val();
    var collname = $('#sc'+id+' option:selected').html();
    var collector = $('#name'+id).html();

    if(coll=='0') {collname = '&nbsp;'};

    $('#name'+id).html(collname);
    $('#name'+id).show();
    $('#sd'+id).hide();

if(collector!=collname){
    $.ajax({
        type: 'post',
        url: '/'+dir+'/assembly/changeColl',
        data: 'oid='+oid+'&uid='+coll+'&date='+colldate
    });
}

}

function showForm(domid){
    //проверка прав
    var ri = $.cookie('ri');
    if(ri!=3) {
        var oid = domid.split('d')[0];
        var colldate = domid.split('d')[1];
        var con = $('#' + domid).text();
        $('#fon').show();
        $('#form').show();
        //заполнить ее данными
        $('#form label:first').html(con);
        $('#oid').val(oid);
        $('#exdate').val(colldate);
    }
}

function showFormTransfer(){
    var oid = $('#orderid').val();
    var olddate = $('#olddate').val();
    var con = $('strong').text();
    $('#fon').show();
    $('#form').show();
    $('#submitok').click(function(){
        $('#fon').hide();
        $('#form').hide();
        if($('#newdate').val()!=''){
            var newdate = $('#newdate').val();//dd-mm-YYYY
            alert(newdate);
            var datetodb = newdate.split('-')[2]+'-'+newdate.split('-')[1]+'-'+newdate.split('-')[0];
            var datehtml = newdate.split('-')[0]+'.'+newdate.split('-')[1];
            if(datetodb!=olddate) {
                $.ajax({
                 type:'post',
                 url: '/'+dir+'/order/transfer',
                 data:'oid='+oid+'&date='+datetodb,
                 success: function(){
                     $('#odplandate').html(datehtml);
                     $('#olddate').val(datetodb);
                 }
                 });
            }
        }
    });
}

function showFormSms(){
    $('#fon').show();
    $('#formSms').show();
    var clwidth = $(document).width()/2-200;
    $('#formSms').css({'left':clwidth});
}

function getTextMsg(){
    var idmsg = $('#tema').val();
    var text = $('#smp-'+idmsg).val();
    $('#message').val(text);
}

setTimeout('$("#answersms").hide()', 2000);

window.onload = function(){
    var sched = surpage.split('/')[2];
    var dom = sched=='schedule' ? true : false;
    if(dom){
        setInterval("location.reload()", 5*60000);
    }
};

$('#fon').click(function(){

    $('#fon').hide();
    $('#form').hide();
    $('#formSms').hide();
});

function cancelHoliday(domid){
    var uid = domid.split('f')[0];
    var hdate = domid.split('f')[1];
    $.ajax({
        type:'post',
        url:'/'+dir+'/assembly/cancelHoliday',
        data:'uid='+uid+'&date='+hdate,
        success:function(){
            $('#'+domid).hide();
        }
    })
}

function addHoliday(hbuid){
    var uid = hbuid.substring(2);
    var hdate = $('#hd'+uid).val();
    $.ajax({
        type:'post',
        url:'/'+dir+'/assembly/collHoliday',
        data:'uid='+uid+'&date='+hdate,
        success:function(data){
            if(data){
                var name = data.split('f')[0];
                var dbdate = data.split('f')[1];
                var div = '<div id="'+uid+'f'+dbdate+'">' + hdate+ ' ' +name+
                       '<input type="button" value="Отменить" onclick="cancelHoliday(this.parentNode.id);"></div>';
                $("#list_holiday").prepend(div);
                $('#hd'+uid).val('');
            }
        }
    })
}

$(".cont").click(function(event) {
    var id = event.target.id;
        document.location.href='/'+dir+'/order/index/'+id;
});

function today(){//формат dd.mm.yyyy
    var d = new Date();
    var YY = d.getFullYear();
    var mm = ('0'+d.getMonth()+1).slice(-2);
    var dd = ('0'+d.getDate()).slice(-2);
    return dd+'.'+mm+'.'+YY;
}

function addNote(oid){
    var note = $('#notes').val();
    if(note != '') {

        $.ajax({
            type: "POST",
            url: '/' + dir + '/order/addnote/',
            data: "oid=" + oid + "&note=" + note,
            success: function () {
                $('#add_note').hide();
                $('#add').show();
                $('#notes').val('');
                var datetoday = today();
                var newnote = '<ins><em>'+datetoday+'</ins></em>  '+note+'</br>';
                    $('#notediv').append(newnote);
             }
        })
    }
}

$(".stan").click(function(event) {
    //таблица цветов
    var col = ['#CCFFFF', '#666666', '#33bb00']
    var id = event.target.id
    var mod = id.split('-')
    var oid = mod[0]
    var tab = mod[1]
    var val = mod[2]
    var ri = $.cookie('ri');
    if (val=='2') {var nval = 0}
    else {nval = parseInt(val, 10) + 1}
    if(ri == 3 || ri == 4 || ri == 1){
        $.ajax({
            type: "POST",
            url: '/' + dir + '/order/changeStan/',
            data: "oid="+oid+"&table="+tab+"&val="+nval,
            success: function(html){
                document.getElementById(oid+'-'+tab+'-'+val).style.backgroundColor = col[nval];
                document.getElementById(oid+'-'+tab+'-'+val).id = oid+'-'+tab+'-'+nval;
            }
        })
    }else {alert('У Вас нет прав вносить изменения в состояние заказа');}
});

$('#plandate').click(function(){

});

function getCoords(elem) { // кроме IE8-
    var box = elem.getBoundingClientRect();

    return {
        top: box.top + pageYOffset,
        left: box.left + pageXOffset
    };

}

function showChangeSum(boid){
    var oid = boid.substring(1);
    var dclass = $('#b'+oid).attr('class');
    if(dclass =='but'){
        var text = $('#sum-'+oid).text();
        $('#sum-'+oid).html('<input type = "text" id="inp-'+oid+'" value="'+text+'"/>');
        $('#b'+oid).text('Сохранить');
        $('#b'+oid).attr('class', 'ok');
    }
    else{
        var sum = $('#inp-'+oid).val();
        $('#sum-'+oid).html(sum);
        $.ajax({
            type: "POST",
            url: '/' + dir + '/schedule/changeSum/',
            data: "oid="+oid+"&sum="+sum
        });
        $('#b'+oid).text('Изменить');
        $('#b'+oid).attr('class', 'but');
    }
}



var domid = '';
$('.oder_drag').click(function(){
    var drag_id = $(this).attr('id');
    ($(this).clone().attr('class','clone').removeAttr('id')).appendTo($('#td'+drag_id).empty());
    $('#korzina').empty().append($(this));
    $(this).attr('class','drg');
});

function changeTech(oid, domid){
    $.ajax({
        type: "POST",
        url: '/' + dir + '/plan/changeTech',
        data: "oid=" + oid + "&table=" + domid
    });
}

function closeTech(oid){
    $.ajax({
        type: "POST",
        url: '/' + dir + '/technologist/closeTech',
        data: "oid=" + oid,
        success: function(data){
            $('#'+oid).parent().html('В_работе');
        }
    });
}

$('.tech_cell').click(function(){
    var newdom = $(this).attr('id');//номер технолога и дата
    if($('#korzina').text()!='') {
        var oid = $('.drg').attr('id');
        $(this).append($('.drg').attr('class', 'oder_drag_gr'));
        changeTech(oid, newdom);
    }else if($('#korzina2').text()!='' && newdom!=domid) {
        var oid = $('.drg2').attr('id');
        $(this).append($('.drg2').attr('class', 'oder_drag_gr'));
        changeTech(oid, newdom);
    }
});


$('.oder_drag_gr').on('click', function(){
    if($('#korzina').text()==''){
        domid = $(this).parent().attr('id');
        $('#korzina2').append($(this));
        $(this).attr('class','drg2');
    }
});

$('.span3').click(function(){
    $('.span3').removeClass('select-span');
    $(this).addClass('select-span');
    var stanid = $(this).attr('id');
    $('#pole').val(stanid);
    $('.for_plan').each(function(){
        var domid = $(this).attr('id');
        var oid = domid.split('-')[0];
        var stan = domid.split('-')[1];
        var red = stan.charAt(stanid);
        if(red == 0){
            $(this).css({'background-color':'#9BC0FF', 'color':'black'});
            $(this).addClass('plan-active');
            $(this).removeClass('plan-passive');
        }
        if(red == 1){
            $(this).css({'background-color':'gainsboro', 'color':'grey'});
            $(this).addClass('plan-passive');
            $(this).removeClass('plan-active');
        }
        if(red == 2){
            $(this).css({'background-color':'palegreen', 'color':'grey'});
            $(this).addClass('plan-passive');
            $(this).removeClass('plan-active');
        }
    });
});



$('.for_plan').click(function(){
    if($(this).hasClass('plan-active')){
       // alert($(this).attr('id'));
        var pole = $('#pole').val();
        var domid = $(this).attr('id');
        var oid = domid.split('-')[0];
        var datec = $('#date').html();
        $.ajax({
            type: "POST",
            url: '/' + dir + '/plan/changeDateStan',
            data: "oid=" + oid + "&pole=" + pole + "&date=" + datec,
            success: function(data){
                if(data == 1){
                    ($('#'+domid).clone().removeClass().removeAttr('id')).appendTo('#'+pole);
                }else if(/(\d{4})-(\d{2})-(\d{2})/.test(data)){
                    alert('Уже в планах на '+data);
                }else{
                    alert('Где-то ошибка! =(');
                }
            }
        });
    }
});

