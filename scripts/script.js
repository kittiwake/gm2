var surpage = window.location.pathname;
var dir = surpage.split('/')[1];
//var ri = $.cookie('ri');

function checkDublication (con){
 //   alert('/new/checkDublication/'+con);

    $.ajax({
        url: '/new/checkDublication/'+con,
        dataType: 'json',
        success: function(data){//[{"id":"2966","contract_date":"2016-03-27","date":"2016-03-28","term":"2016-05-02","designer":"43","sum":"122400","prepayment":"40000","rassr":"0","beznal":"0","note":"","technologist":"15","collector":"0"}]
            //alert(data);
            //$contract='';
            //$con_date='';
            //$name = '';
            //$prod = '';
            //$termin = '';
            //$otkr = 0;
            //$sum = '';
            //$rassr = 0;
            //$beznal = 0;
            //$pred = '';
            //$dis ='';
            //$adress = '';
            //$phone = '';

            if(data){
                $('#num').val(data[0]['contract']);
                $('#name').val(data[0]['name']);
                $('#prod').val(data[0]['product']);
                $('#adress').val(data[0]['adress']);
                $('#phone').val(data[0]['phone']);
                $('#email').val(data[0]['email']);
                $('#dis').val(data[0]['designer']);
            }
        }
    })

}

function closeOrder(oid,ri){
 //   alert(oid);
 //   var ri = $.cookie('ri');
    //if(ri!=3){
        $.ajax({
            url: '/collector/close/'+oid,
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
    //}
}

function killCookies(){
    $.cookie('uid', null, { expires: -1});
}

function showCollector(uid){
    $('.tables').hide();
    $('#div'+uid).show();
}


function saveMounting(ri){
    //проверка прав
    //var ri = $.cookie('ri');
    var ri = parseInt($("#uright").val(),10);
    if(ri==4 || ri==3 || ri==1){
        var oid = $('#oid3').val(),
            target = $('#target').val();
        if (!target){
            var target = $('input[type=radio]:checked').val();
        }
        var datemsec = $('#dateofmount').val();
        $.ajax({
            url:'/assembly/addMounting',
            type:'post',
            data: 'oid='+oid+'&date='+datemsec+'&target='+target,
            success: function(data){
                location.reload();
            }
        });
    }
}

function changeTarget(elem){
    $('#fon').show();
    var oid = elem.id.split('td')[0];
    var colldate = elem.id.split('td')[1];
    var x = $(elem).offset().left,
        y = $(elem).offset().top,
        dx = $(elem).width(),
        dy = $(elem).height();
    $('#change_target').html('<label><input type="radio" name="target" value="assembly"> Сборка</label> ' +
    '<br> ' +
    '<label><input type="radio" name="target" value="measure"> Замер</label> ' +
    '<br> ' +
    '<label><input type="radio" name="target" value="previously"> Шаблон</label> '
    );
    $('#change_target').css({
        'backgroundColor' : 'BlanchedAlmond',
        'color':'#000',
        'width': dx+'px',
        'height': dy+'px',
        'position': 'absolute',
        'top': y+'px',
        'left': x+'px',
        'font-size': '0.7em',
        'font-family': 'sans-serif',
        'white-space': 'nowrap',
        'z-index': '3'
    });
    $('#change_target input[type=radio]').change(function(){
        var tar = $(this).val();
        $.ajax({
            type:'post',
            data:'target='+tar+'&oid='+oid+'&colldate='+colldate,
            url:'/assembly/changeTarget',
            success:function(data){
                //alert(data);
                elem.innerHTML=data;
                $('#fon').hide();
                $('#change_target').css({
                    'left': '-300px'
                });

            }
        })
    });
}
function addMountNote(elem, cod){
    if(cod == 'sta'){
        var ta = elem.parentNode.lastElementChild;
        $(ta).show();
        $(elem).hide();
    }
    if(cod == 'add'){
        var id = elem.parentNode.parentNode.parentNode.firstElementChild.firstElementChild.id;
        var oid = id.split('d')[0];
        var divta = elem.parentNode;
        var btn = divta.previousElementSibling;
        var div = btn.previousElementSibling;
        var ta = elem.previousElementSibling;
        var text = $(ta).val();
        var d = new Date();
        var mSec = Date.parse(d);
        var m = d.getMonth()+1;
        var mm = ('0'+m).slice(-2);
        var dd = ('0'+d.getDate()).slice(-2);
        var date_html = dd+'.'+mm;
        if(text != ''){
            $.ajax({
                type:'post',
                data:'oid='+oid+'&note='+text,
                url:'/assembly/addNote',
                success:function(data){
                    if(data){
                        $(divta).hide();
                        $(btn).show();
                        $(div).append('<br><b>'+date_html+'</b> '+text);
                    }else{
                        alert('Не получилось!');
                    }
                }
            });
        }
    }
}
function changeSample(){
    var oid = $('#oid3').val();
    var date = $('#m_date').val();
    var uid = $('#form3 input[type="radio"]:checked').val();
    if(uid!='undefined'){
        $.ajax({
            type:'post',
            url:'/designer/change',
            data:'oid='+oid+'&uid='+uid,
            success:function(){
                location.reload();
            }
        })
    }
}

function showFormAddingCol(oid, m_date, post){
    $('#oid3').val(oid);
    $('#m_date').val(m_date);
    $('#fon').show();
    $('#form3').show();
    //определить, сборщики или дизайнеры, и заполнить форму невыходными на этот день
    if(post == 17) var contr = 'assembly';
    $.ajax({
        type:'post',
        url:'/'+contr+'/getFreemen',
        data:'date='+m_date,
        dataType:'json',
        success:function(data){
            if(data.length == 0){
                $('.list_user').show();
            }else{
                for (var i = 0; i < data.length; i++){
                    $('#us'+data[i]).hide();
                }
            }
        }
    });

}

function showForm(domid){
    //проверка прав
    //if(ri!=3) {
        var oid = domid.split('d')[0];
        var colldate = domid.split('d')[1];
        var con = $('#' + domid).text();
        $('#fon').show();
        $('#duplicate').show();
        //заполнить ее данными
        $('#duplicate label:first').html(con);
        $('#oid').val(oid);
        $('#exdate').val(colldate);
    //}
}

function showList(divid){
    $('.lists').hide();
    $('#'+divid).show();
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
            var datetodb = newdate.split('-')[2]+'-'+newdate.split('-')[1]+'-'+newdate.split('-')[0];
            var datehtml = newdate.split('-')[0]+'.'+newdate.split('-')[1];
            if(datetodb!=olddate) {
                $.ajax({
                 type:'post',
                 url: '/order/transfer',
                 data:'oid='+oid+'&date='+datetodb,
                 success: function(){
                     $('#odplandate').html(datehtml);
                     $('#olddate').val(datetodb);
                 }
                 });
            }
        }
    });
    $('#oldisubmitok').click(function(){
        $('#fon').hide();
        $('#form').hide();
        if($('#newdate').val()!=''){
            var newdate = $('#newdate').val();//dd-mm-YYYY
            var datetodb = newdate.split('-')[2]+'-'+newdate.split('-')[1]+'-'+newdate.split('-')[0];
            var datehtml = newdate.split('-')[0]+'.'+newdate.split('-')[1];
            if(datetodb!=olddate) {
                $.ajax({
                 type:'post',
                 url: '/oldi/transfer',
                 data:'oid='+oid+'&date='+datetodb,
                 success: function(){
                     $('#plan_date').html(datehtml);
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
function showFormEmail(){
    $('#fon').show();
    $('#formEmail').show();
    var clwidth = $(document).width()/2-200;
    $('#formEmail').css({'left':clwidth});
}
function showFormName(uid){
    $('#fon').show();
    $('#formName').show();
    $('#uidtochange').val(uid);
    var clwidth = $(document).width()/2-200;
    $('#formName').css({'left':clwidth});
}
function showFormLogin(uid){
    $('#fon').show();
    $('#formLogin').show();
    $('#uidtochange').val(uid);
    var clwidth = $(document).width()/2-200;
    $('#formLogin').css({'left':clwidth});
}
function showFormPass(uid){
    $('#fon').show();
    $('#formPass').show();
    $('#uidtochange').val(uid);
    var clwidth = $(document).width()/2-200;
    $('#formPass').css({'left':clwidth});
}

function showFormnewsum(pole){
    $('#fon').show();
    $('#formnewsum').show();
    var clwidth = $(document).width()/2-200;
    $('#formnewsum').css({'left':clwidth});
    $('#polesum').val(pole);

}

function changeSumOrder(){
    var pole = $('#polesum').val();
    var oid = $('#orderid').val();
    $('#fon').hide();
        $('#formnewsum').hide();
        if($('#newsum').val()!=''){
            //alert(pole);
            var newsum = $('#newsum').val();
            $.ajax({
                type:'post',
                url: '/order/changeSum',
                data:'oid='+oid+'&sum='+newsum+'&pole='+pole,
                success: function(data){
                    if(data){
                        $('#'+pole).html(data+'р.');
                        $('#newsum').val('');
                    }
                }
            });
        }
}

function inPlanDis(pole){
    $('.plan_dis').hide();
    $('#in_'+pole).show();
    $('.menu').removeClass("active");
    $('.menu').addClass("passive");
    $('#'+pole).removeClass("passive");
    $('#'+pole).addClass("active");
    if(pole!='plan'){
        $('#day').hide();
        $('#plan').show();
    }else{
        $('#plan').hide();
        $('#day').show();
    }
}
function addHolidayDis(){
    var sel = document.getElementById('dis');
    var dis = sel.options[sel.selectedIndex].value,
        name = sel.options[sel.selectedIndex].text,
        date = document.getElementById('hol_date').value;
    $.ajax({
        type:'post',
        data:'date='+date+'&dis='+dis,
        url:'/designer/holiday',
        success: function(data){
            if(data){
                if(/(\d+)/.test(data)){
                    $('#answerholiday').html('Выходной успешно назначен');
                    $('.content_main').append('<div class="ass_row" id="hol-'+data+'">'+
                    '<div class="dis_cell">'+date+'</div>'+
                    '<div class="dis_cell">'+name+'</div>'+
                    '<div class="dis_cell">'+
                    '<button onclick="cancelHolDis(this);">Отменить</button>'+
                    '</div></div>');
                }else {
                    $('#answerholiday').html(data);
                }
            }
        }
    })
}

function cancelHolDis(elem){
    var elid = elem.parentNode.parentNode.id;
    var id = elid.split('-')[1];
    $.ajax({
        type:'post',
        data:'id='+id,
        url:'/designer/cancelHoliday',
        success: function(data){
            if(data){
                $('#'+elid).hide();
            }
        }
    })
}
function getTextMsg(type){
    if(type == 'sms'){
        var idmsg = $('#tema').val();
        var text = $('#smp-'+idmsg).val();
        $('#message').val(text);
    }else{
        var idmsg = $('#tema_e').val();
        var text = $('#smp-'+idmsg).val();
        $('#e-message').val(text);
    }
}

setTimeout('$("#answersms").hide()', 2000);

 window.onload = function(){
     var sched = surpage.split('/')[1];
     var action = surpage.split('/')[2];
//     //открыто ли окошко о звонящем клиенте
     var infocl = document.getElementById('windcl');
     var dom = (sched=='schedule'|| sched=='skedCeh' || (sched=='delivery' && action=='schedule'))&&(infocl==null) ? true : false;
     if(dom){
         setInterval("location.reload()", 5*60000);
     }

//     //получить дочерние в левом меню
//     var ahrs = document.getElementById('leftmenu').children;
//     //получить текущий урл
//     var url = document.location.href;
//     //alert(ahrs.length);
//     //сравнить урл с хрефом каждой ссылки
//     for(var i=0; i<ahrs.length; i++){
//         var reg = ahrs[i].href;

//         //если совпало, заменить картинку
//         if(url.indexOf(reg)==0){
//             var img = ahrs[i].firstElementChild.firstElementChild;
//             var src = img.src;
//             img.src = (src.replace(/(.)(\.gif)/,'$1act$2'));
//         }
//     }
//     checkNewCallMessages();
// //каждые 10 секунд проверяем новые сообщения и выводим их цифру
//     setInterval(checkNewCallMessages, 10000);

 };

//window.onunload = function(){
//    $.ajax({
//        url:'/callmessages/newToRead',
//        cache: false
//    })
//};

$('#fon').click(function(){

    $('#fon').hide();
    $('#form').hide();
    $('.form').hide();
    $('#formSms').hide();
    $('#formnewsum').hide();
    $('#formOperate').hide();
    $('#calendar').hide();
    $('#change_target').css({
        'left': '-300px'
    });
    if($('#fon').hasClass("planceh")){
        saveChangesPosition();
    }
});

function cancelHoliday(domid){
    var uid = domid.split('f')[0];
    var hdate = domid.split('f')[1];
    $.ajax({
        type:'post',
        url:'/assembly/cancelHoliday',
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
        url:'/assembly/collHoliday',
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
/*
$(".cont").click(function(event) {
    var id = event.target.id;
        document.location.href='/order/index/'+id;
});
*/

$(".delivcont").click(function(event) {
    var id = event.target.id,
        otd = event.target.dataset.otd,
        outlay = document.getElementById('actOutlayId'),
        outlayid = 0;
    if(!!outlay) outlayid = outlay.dataset.outlayid;
    document.location.href='/delivery/order/'+id + '?otd=' + otd + '&outlay=' + outlayid;
});

function today(){//формат dd.mm.yyyy
    var d = new Date();
    var YY = d.getFullYear();
    var m = d.getMonth()+1;
    var mm = ('0'+m).slice(-2);
    var dd = ('0'+d.getDate()).slice(-2);
    return dd+'.'+mm+'.'+YY;
}

function strToday(){//формат dd.mm.yyyy
    var fullyear = ['','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря']
    var d = new Date();
    var YY = d.getFullYear();
    var m = d.getMonth()+1;
    var mm = ('0'+m).slice(-2);
    var dd = ('0'+d.getDate()).slice(-2);
    return dd+'.'+fullyear[mm]+'.'+YY;
}

function strMonth(mm){
    var fullyear = ['','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря']
    return fullyear[mm];
}

function addNote(oid){
    var note = $('#notes').val();
    if(note != '') {

        $.ajax({
            type: "POST",
            url: '/order/addnote/',
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
};

function tapOrderTerm(){
    var span = document.getElementById('termin');
    var inp = '<input type="text" id="newterm" value="" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>' +
        '<button onclick="changeContractTerm();">OK</button>';
    span.innerHTML = inp;
};

function changeContractTerm(){
    var span = document.getElementById('termin');
    var newterm = document.getElementById('newterm').value,
        oid = document.getElementById('orderid').value;
    if(newterm != ''){
        $.ajax({
            url:'/order/changeTermin/',
            type:'post',
            data:'oid='+oid+'&date='+newterm,
            success: function(data){
                if(data && data != 0){
                    span.innerHTML = newterm;
                }else{
                    span.innerHTML = '<button onclick="tapOrderTerm();">Установить сроки</button>';
                }
            }
        });
    }else{
        span.innerHTML = '<button onclick="tapOrderTerm();">Установить сроки</button>';
    }
};

$(".stan").click(function(event) {
    //таблица цветов
    var col = ['#CCFFFF', '#666666', '#33bb00']
    var id = event.target.id
    var mod = id.split('-')
    var oid = mod[0]
    var tab = mod[1]
    var val = mod[2]
    var ri = parseInt($("#uright").val(),10);
    if (val=='2') {var nval = 0}
    else {nval = parseInt(val, 10) + 1}
    if((ri == 3 || ri == 4 || ri == 19||ri==1||ri==33)||(ri == 8 && tab == 1)||(ri == 16 && (tab >= 11 && tab <= 14))||(ri == 15 && (tab >= 8 && tab <= 9))){
        $.ajax({
            type: "POST",
            url: '/order/changeStan/',
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
            url: '/schedule/changeSum/',
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
        url: '/plan/changeTech',
        data: "oid=" + oid + "&table=" + domid
    });
};

function closeTech(oid){
    $.ajax({
        type: "POST",
        url: '/technologist/closeTech',
        data: "oid=" + oid,
        success: function(data){
            $('#'+oid).parent().html('В_работе');
        }
    });
};

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
    if($('.span3').hasClass('select-span')&&!$(this).hasClass('select-span')){
        var mas = [];
        $('.select-span').children('.splc_list').children().each(function(){
            mas[$(this).index()] = $(this).attr('id');
        });
        var data=JSON.stringify(mas);
        $.ajax({
            url:'/plan/changeSequence/',
            type:'POST',
            datatype:'json',
            data:'data='+data
        })
    };
    $('.span3').removeClass('select-span');
    $(this).addClass('select-span');
    var url = window.location.href;
    if(url.indexOf('getPlanMdf')!= -1){
        $('#stanbtn').prop({
            disabled: false
        });
    }
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
$(this).children('.splc_list').children().click(function(){
    $(this).parent().append($(this));
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
            url: '/plan/changeDateStan',
            data: "oid=" + oid + "&pole=" + pole + "&date=" + datec + "&perenos=0",
            success: function(data){
                if(data == 1){
                    ($('#'+domid).clone().removeClass().removeAttr('id')).appendTo('#'+pole);
                }else if(/(\d{2}).(\d{2}).(\d{4})/.test(data)){
                    if(confirm ('Уже в планах на '+data+'. Перенести?')) {
                        $.ajax({
                            type: "POST",
                            url: '/plan/changeDateStan',
                            data: "oid=" + oid + "&pole=" + pole + "&date=" + datec + "&perenos=1",
                            success: function (data) {
                                if(data == 1){
                                    location.reload();
                                }
                            }
                        });
                    }
                }else{
                    alert('Где-то ошибка! =(');
                }
            }
        });
    }
});

//тестовые скрипты для плланирования цеха
//выделяем этап и отбираем заказы из списка, еще не бывшие на этом этапе
$('.span33').click(function(){
    var stanid = $(this).attr('id');
    var stanidmdf = $(this).data("key");
    $('.span33').removeClass('select-span');
    $(this).addClass('select-span');
    $('#pole').val(stanid);
    //alert($('#planbtn').attr('disabled'));
    $('#planbtn').prop({
        disabled: false
    });
    $('#stanbtn').prop({
        disabled: false
    });
    // определить график
    ceh = document.location.pathname.slice(-3);
    $('.for_plan2').each(function(){
        var domid = $(this).attr('id');
        var oid = domid.split('-')[0];
        var stan = domid.split('-')[1];
        var partid = domid.split('-')[2];
            var bgc = '#9BC0FF';
        // console.log(partid);
        var red = ceh == 'mdf' ? stan.charAt(stanidmdf) : stan.charAt(stanid);
        if(red == 0){
            if($(this).data('tip') == 1) {bgc = '#6183ff';}
            $(this).css({'background-color':bgc, 'color':'black'});
            $(this).addClass('plan-active');
            $(this).removeClass('plan-passive');
        }
        if(red == 1 && ceh == 'ceh'){
            $(this).css({'background-color':'gainsboro', 'color':'grey'});
            $(this).addClass('plan-passive');
            $(this).removeClass('plan-active');
        }
        if(red == 2 || (red == 1 && ceh == 'mdf')){
            $(this).css({'background-color':'palegreen', 'color':'grey'});
            $(this).addClass('plan-passive');
            $(this).removeClass('plan-active');
        }
    });
});

function progression(){
    var select = document.querySelector('.select-span');
    var numpole = select.id;
    var f = select.querySelector('.plceh_list2');
    var list = f.children;
    var form = document.getElementById('porjadok');
    form.innerHTML = '';
    for(var i=0; i<list.length; i++){
        var div = document.createElement('div');
        div.id = list[i].children[1].id + '-' + i;
        console.log(div.id);
        div.classList.toggle('formlist',true);
        div.addEventListener("click", changePosition);
        form.appendChild(div);
        div.innerHTML = list[i].children[1].innerText;
    }
    $('#fon').show();
    $(form).show();
    var scrw = document.documentElement.clientWidth,
        scrh = document.documentElement.clientHeight,
        divw = form.offsetWidth,
        divh = form.offsetHeight,
        margl = (scrw-divw)/2,
        margt = (scrh-divh)/2;
    form.style.left = margl + 'px';
    form.style.top = margt + 'px';
}
function changePosition(){
    var previos = this.previousElementSibling;
    if(previos!=null){
        this.parentElement.insertBefore(this,previos);
    }
}

function saveChangesPosition(){
//    console.log(window.location.href)
    var gmol = window.location.href.split('/')[4];
    var mas = '';
    var form = document.getElementById('porjadok');
    var list = form.children;
    console.log(list)
    for(var i=0; i<list.length; i++){
        var pos = list[i].id.split('-')[2];
        if(pos!=i){
            var txt = list[i].id+ '-' + i + ';';
            mas += txt;
        }
    }
    if(mas !=''){
//        alert(mas);
        $.ajax({
            type:'post',
            url:'/plan/ChangePosition',
            data:'list='+mas + '&gmol=' + gmol,
            success:function(data){
//                console.log(data);
                location.reload();
            }
        })
    }
}

function planCehStan(){
    var select = document.querySelector('.select-span');
    var numpole = select.id;
    var f = select.querySelector('.plceh_list2');
    var list = f.children;
    var form = document.getElementById('porjadok');
    console.log(numpole);
    form.innerHTML = '';
    for(var i=0; i<list.length; i++){
        var div = document.createElement('div'),
            clonedid = list[i].children[1].id,
            colr = list[i].children[1].style.backgroundColor,
            stan = list[i].children[1].dataset.stan;
        div.id = clonedid + '-' + i;
        div.style.backgroundColor = colr;
        div.dataset.stan = stan;
        // console.log(stan);
        div.classList.toggle('formlist',true);
        div.addEventListener("click", changeStan);
        form.appendChild(div);
        div.innerHTML = list[i].children[1].innerText;
    }
    $('#fon').show();
    $(form).show();
    var scrw = document.documentElement.clientWidth,
        scrh = document.documentElement.clientHeight,
        divw = form.offsetWidth,
        divh = form.offsetHeight,
        margl = (scrw-divw)/2,
        margt = (scrh-divh)/2;
    form.style.left = margl + 'px';
    form.style.top = margt + 'px';
}

function changeMdfCehStan(){
    var select = document.querySelector('.select-span');
    var numpole = select.id;
    var f = select.querySelector('.plceh_list2');
    var list = f.children;
    var form = document.getElementById('gotovnost');
    form.innerHTML = '';
        console.log(list);
    for(var i=0; i<list.length; i++){
        var div = document.createElement('div'),
            clonedid = list[i].id,
            colr = list[i].style.backgroundColor,
            stan = list[i].dataset.stan;
        div.id = clonedid + '-' + i;
        div.style.backgroundColor = colr;
        div.dataset.stan = stan;
        // console.log(stan);
        div.classList.toggle('formlist',true);
        div.addEventListener("click", changeStan);
        form.appendChild(div);
        div.innerHTML = list[i].innerText;
    }
    $('#fon').show();
    $(form).show();
    var scrw = document.documentElement.clientWidth,
        scrh = document.documentElement.clientHeight,
        divw = form.offsetWidth,
        divh = form.offsetHeight,
        margl = (scrw-divw)/2,
        margt = (scrh-divh)/2;
    form.style.left = margl + 'px';
    form.style.top = margt + 'px';
}

function changeStan(){
    var div = this,
        oid = div.id.split('-')[1],
        tab = div.id.split('-')[0],
        ttab = tab,
        val = div.dataset.stan,
        nval = 0,
        bcgcl = "#ff6083";
    if(val == 0) {
        nval = 2;
        bcgcl = "#00b050";
    }
    
 //   console.log(oid+'--'+tab+'--'+nval); //8033--0--2
    console.log(document.location.pathname.indexOf('Mdf') == -1); 
    var url = window.location.href;
    if(document.location.pathname.indexOf('mdf') == -1 && document.location.pathname.indexOf('Mdf') == -1){
        ajaxurl = '/plan/changeStan';
    }else{
        if(tab == 'cpu'){
            if(document.location.pathname.indexOf('get') == -1){
                if(val == 0) {
                    nval = 1;
                    bcgcl = "#00b050";
                }
                ajaxurl = '/plan/changeOldiStan';
            }else{
                ttab = 1;
                ajaxurl = '/plan/changeStan';
            }
        }
        else{
            if(val == 0) {
                nval = 1;
                bcgcl = "#00b050";
            }
            ajaxurl = '/plan/changeOldiStan';
        }
    }
    console.log("oid="+oid+"&pole="+ttab+"&val="+nval); //oid=10127&pole=pvh&val=1

    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: "oid="+oid+"&pole="+ttab+"&val="+nval,
        success: function(data){
            console.log(data);
            if(data == 1){
                console.log(bcgcl);
                div.setAttribute("style","background-color: "+bcgcl);
                div.dataset.stan = nval;
                document.getElementById(tab+'-'+oid).setAttribute("style","background-color: "+bcgcl);
                document.getElementById(tab+'-'+oid).dataset.stan = nval;
                console.log(div);

            }
        }
    })

}

// $('.span3').click(function(){
//     if($('.span3').hasClass('select-span')&&!$(this).hasClass('select-span')){
//         var mas = [];
//         $('.select-span').children('.splc_list').children().each(function(){
//             mas[$(this).index()] = $(this).attr('id');
//         });
//         var data=JSON.stringify(mas);
//         $.ajax({
//             url:'/plan/changeSequence/',
//             type:'POST',
//             datatype:'json',
//             data:'data='+data
//         })
//     };
//     $('.span3').removeClass('select-span');
//     $(this).addClass('select-span');
//     var stanid = $(this).attr('id');
//     $('#pole').val(stanid);
//     $('.for_plan').each(function(){
//         var domid = $(this).attr('id');
//         var oid = domid.split('-')[0];
//         var stan = domid.split('-')[1];
//         var red = stan.charAt(stanid);
//         if(red == 0){
//             $(this).css({'background-color':'#9BC0FF', 'color':'black'});
//             $(this).addClass('plan-active');
//             $(this).removeClass('plan-passive');
//         }
//         if(red == 1){
//             $(this).css({'background-color':'gainsboro', 'color':'grey'});
//             $(this).addClass('plan-passive');
//             $(this).removeClass('plan-active');
//         }
//         if(red == 2){
//             $(this).css({'background-color':'palegreen', 'color':'grey'});
//             $(this).addClass('plan-passive');
//             $(this).removeClass('plan-active');
//         }
//     });
// $(this).children('.splc_list').children().click(function(){
//     $(this).parent().append($(this));
// });
// });

//постановка заказа в план
$('.for_plan2').click(function(){
//    console.log(window.location.href.split('/')[4]);
    var gmol = window.location.href.split('/')[4];
    if($(this).hasClass('plan-active')){
       // alert($(this).attr('id'));
        var pole = $('#pole').val();
        var domid = $(this).attr('id');
        var oid = domid.split('-')[0],
            partid = domid.split('-')[2];
        var datec = $('#date').html();
        var today = new Date();
        var msec = today.getTime();
        if(typeof (partid) == 'undefined'){
            $.ajax({
                type: "POST",
                url: '/plan/changeDateStanTest',
                data: "oid=" + oid + "&pole=" + pole + "&date=" + datec + "&gmol=" + gmol + "&perenos=0",
                success: function(data){
                    console.log(data);
                    if(data == 1){
                        ($('#'+domid).clone().removeClass().removeAttr('id')).appendTo('#'+pole);
                    }else if(/(\d{2}).(\d{2}).(\d{4})/.test(data)){
                        if(confirm ('Уже в планах на '+data+'. Перенести?')) {
                            $.ajax({
                                type: "POST",
                                url: '/plan/changeDateStanTest',
                                data: "oid=" + oid + "&pole=" + pole + "&date=" + datec + "&gmol=" + gmol + "&perenos=1"+ "&msec=" + msec,
                                success: function (data) {

                                    console.log(data);
                                    if(data == 1){
                                        location.reload();
                                    }
                                }
                            });
                        }
                    }else{
                        alert('Где-то ошибка! =(');
                    }
                }
            });
        }
        else{
            $.ajax({
                type: "POST",
                url: '/plan/changeDatePart',
                data: "id=" + partid + "&pole=" + pole + "&date=" + datec + "&perenos=0",
                success: function(data){
                    console.log(data);
                    if(data == 1){
                        ($('#'+domid).clone().removeClass().removeAttr('id')).appendTo('#'+pole);
                    }else if(/(\d{2}).(\d{2}).(\d{4})/.test(data)){
                        if(confirm ('Уже в планах на '+data+'. Перенести?')) {
                            $.ajax({
                                type: "POST",
                                url: '/plan/changeDatePart',
                                data: "id=" + partid + "&pole=" + pole + "&date=" + datec + "&perenos=1"+ "&msec=" + msec,
                                success: function (data) {

                                    console.log(data);
                                    if(data == 1){
                                        location.reload();
                                    }
                                }
                            });
                        }
                    }else{
                        alert('Где-то ошибка! =(');
                    }
                }
            });
        }
        console.log(partid);
        // alert(msec);
    }
});
//конец тестовых скриптов для плланирования цеха

$(".findorder").each(function(indx){
    $(this).val('');
});

// $('.olcon').keyup(function(){
//     var con = $('#con').val();
//     var l = con.length;
//     if(l>3){
//         $.ajax({
// //            dataType: 'json',
//             type: "POST",
//             url: '/new/checkGM',
//             data: "con="+con,    
//             success: function(data){
//                 if(data==1){
//                     alert('Галереевские заказы вносятся через график ГМ');
//                     //блокировать дальнейший ввод
//                 }
//             }
//         });
//     }
// });

var checkAjax = null;
// $('.findorder').keyup(function(){
//     var con = $('#con').val();
//     var name = $('#name').val();
//     var phone = $('#phone').val();
//     var str = $('#str').val();
//     var h = $('#h').val();
//     var f = $('#f').val();
//     checkAjax = $.ajax({
//         dataType: 'json',
//         type: "POST",
//         url: '/find/find',
//         data: "con="+con+"&name="+name+"&phone="+phone+"&str="+str+"&h="+h+"&f="+f,
//         beforeSend: function() {
//             if(checkAjax != null) {
//                 checkAjax.abort();
//             }
//         },
//         success: function(data){
//             $("#list").html("Найдено результатов: "+data.length+" <br>");
//             if(data.length != 0){
//                 for (var i = 0; i < data.length; i++){
//                     $("#list").append("<div class='elem_list'><hr/>" +
//                     "	<p><a href='/order/index/" + data[i][0]+"'><b class='ssylka'>"+data[i][1]+'</b></a> от '+data[i][5]+"</p>" +
//                     "<p>"+data[i][2]+" тел.:"+data[i][3]+" адрес:"+data[i][4]+"</p>" +
//                     "<p>Срок по договору: "+data[i][9]+"</p>" +
//                     "<p>Дата вывоза: "+data[i][6]+"</p>" +
//                     "<p>Дизайнер: "+data[i][8]+"</p>" +
//                     "<p>Технолог: "+data[i][7]+"</p>" +
//                     "<p>Сборки: "+data[i][10]+"</p>" +
//                     "<div class='note'>"+data[i][11]+"</div>" +
//                     "</div>");

//                 }
//             }
//             checkAjax = null;
//         }
//     });
// });

function dellCategory(catid){
    $.ajax({
        type:'post',
        url:'/delivery/delCategory',
        data:'cat='+catid,
        success:function(dada){
            if(dada){
                $('#category option[value="'+catid+'"]').remove();
                $('#fon').hide();
                $('#formnewsum').hide();
            }
        }
    })
}

function addCategory(){
    var cat = $('#newcategory').val();
    $.ajax({
        type:'post',
        url:'/delivery/addCategory',
        data:'cat='+cat,
        success:function(data){
            if(data){
                $('#fon').hide();
                $('#form').hide();
                var html = '<option value="'+data+'">'+cat+'</option>';
                $('#category').append(html);
                var form = '<p>'+cat+'<input type="button" id="'+data+'" onclick="dellCategory(this.id);" value="Удалить"></p>';
                $('#formnewsum').append(form);
            }
        }
    })
}

function addMater(formdiv){
    console.log(formdiv);
    var catid = formdiv.querySelector('select').value,
        cat = formdiv.querySelector('option:checked').text,
        otd = formdiv.dataset.otd,
        mat = formdiv.querySelector('input[type="text"]').value;
    var oid = $('#oid').val();
    console.log(oid);
    if(catid!='' && mat!=''){
        $.ajax({
            type:'post',
            url:'/delivery/addMaterial',
            data:'cat='+catid+'&mat='+mat+'&oid='+oid+'&otd='+otd,
            async: false,
            success:function(data){
                if(data){
                    if(otd == 'o')
                        oid = oid;
                    location.href = '/delivery/order/'+oid+'?otd='+otd;
                    // location.reload();
                }
            }
        })
    }
}

function addMaterMalar(formdiv){
    var catid = formdiv.querySelector('select').value,
        cat = formdiv.querySelector('option:checked').text,
        otd = formdiv.dataset.otd,
        mat = formdiv.querySelector('input[type="text"]').value;
    var oid = $('#orderid').val();
    if(catid!='' && mat!=''){
        $.ajax({
            type:'post',
            url:'/delivery/addMaterial',
            data:'cat='+catid+'&mat='+mat+'&oid='+oid+'&otd='+otd,
            async: false,
            success:function(data){
                if(data){
                    if(otd == 'o')
                        oid = oid;
                    // location.href = '/delivery/order/'+oid+'?otd='+otd;
                    location.reload();
                }
            }
        })
    }
}

function delMaterial(btid){
    var matid = btid.substring(2);
    $.ajax({
        type:'post',
        url:'/delivery/delMaterial',
        data:'mat='+matid,
        success:function(data){
            if(data){
                $('#tr'+matid).remove();
            }
        }
    })
}

$('.deliv_list input[type="radio"]').change(function(){
    var status = $(this).val();
    var mid = ($(this).attr('name'));
    var matid = mid.substring(6);
    var elem = $(this);

    $.ajax({
        type:'post',
        url:'/delivery/changeStatus',
        data:'matid='+matid+'&status='+status,
        success:function(data){
            if(data){
                $(elem).parents('tr').children('.color').css({'background-color':status});
            }
        }
    })
});

function changeDate(aid){
    var matid = aid.substring(1);

    alert(matid);
}

function changePorjadok(){
    $('#fon').show();
    $('.form').show();
    var pole = $('#pole').val();//номер в массиве

}

$('#zakaz').click(function(){
    var ri = parseInt($("#uright").val(),10);
    var url = window.location.href;
    var ajaxurl = '';
    if(url.indexOf('http://grafik-gm.ru/oldi/order') == -1){
        ajaxurl = '/order/changeContract';
    }else{
        ajaxurl = '/oldi/changeContract';
    }
    console.log(ajaxurl);
    if(ri==4||ri==1) {
        var test = prompt("Введите новый номер заказа", '');
        var oid = document.getElementById('orderid').value;
        if (test != null && test != '') {

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: 'con=' + test + '&oid=' + oid,
                success: function (data) {
                    if (data == 1) {
                        $("#zakaz").html(test);
                    }
                    else if (data == 'error') {
                        alert('Такой номер уже есть');
                    }
                    else alert('Не переименовано!');
                }
            });
        }
    }
});

$('.delete').click(function(){
    var ri = parseInt($("#uright").val(),10);
    if(ri==4||ri==1) {
        var con = $('#zakaz').html();
        var isOk = confirm('Дейстрительно удалить заказ '+con+' из базы? При этом будет удалена вся информация по этому заказу.');
        if(isOk == true){
            var oid = $('#orderid').val();
            $.ajax({
                type:'post',
                url: '/order/deleteOrder',
                data: 'oid='+oid,
                success: function(data){
                    if(data == 1){
                        location.href = '/schedule/orders';
                    }
                }
            });
        }
    }
});

$('.archive').click(function(){
    console.log(this.id);
    var ri = parseInt($("#uright").val(),10);
    if(ri==4||ri==1) {
        var con = $('#zakaz').html();
        var oid = $('#orderid').val();
        var arch = 0;
        var recep = document.getElementById('outarch');
        var opon = document.getElementById('inarch');
        var color = 'rgba(248, 218, 110, 0.11)'
        console.log(this.id == "inarch"); 
        if (this.id == "inarch") {
            arch = 1;
            color = 'rgba(248, 218, 110, 0.47)';
            opon = document.getElementById('outarch');
            recep = document.getElementById('inarch');
        }
        if(this.id == "outarch"){
            showFormTransfer();
        }
        console.log(opon.id); 
        $.ajax({
            type:'post',
            url: '/order/saveChanges',
            data: 'oid='+oid+'&archive=' + arch,
            success: function(data){
                if(data == 1){
                    // location.href = '/schedule/orders';
                    $('.content').css({'backgroundColor' : color});
                    recep.style.display = "none";
                    opon.style.display = "block";
                }
            }
        });
    }
});

$('.nav').click(function(){
    if ($(this).hasClass('passive_nav')){
        $('.nav').removeClass('active_nav');
        $('.nav').addClass('passive_nav');
        $(this).removeClass('passive_nav');
        $(this).addClass('active_nav');
        var domid = $(this).attr('id');
        $('.content_orders').hide();
        $('.'+domid+'_table').show();
    }
});

function uvolit(uid){
    $.ajax({
        type:'post',
        url:'/manpower/dismiss',
        data: 'uid='+uid,
        success: function(data){
            if(data == 1){
                $('#'+uid).closest('tr').remove();
           }
        }
    });
}

function showFormOperate(pid){
    $('#fon').show();
    $('#formOperate').show();
    $('#pid').val(pid);
}

$('#operate').click(function(){
    var pid = $('#pid').val();
    var name = $('#newname').val();
    var phone = $('#newphone').val();
    if((/^\w+\s\w+\s\w+\s?$/.test(name))&&(/\S7[0-9]{10}/.test(phone))){
        $.ajax({
            type:'post',
            url:'/manpower/operate',
            data:'pid='+pid+'&name='+name+'&phone='+phone,
            success: function(data){
                if(data){
                    var text = '<tr>'+
                        '<td>Изменить</td>'+
                        '<td>'+
                            '<input type="button" id="'+data+'" value="Уволить" onclick="uvolit(this.id)">'+
                            '</td>'+
                            '<td>'+name+'</td>'+
                            '<td>'+phone+'</td>'+
                        '</tr>';
                    $('#t'+pid+' table').append(text);
                }
                $('#formOperate').hide();
                $('#fon').hide();
            }
        });
    }
});

function showElement(elemid){
    $('#'+elemid).show();
}

function checkArhiv(con){
    $.ajax({
        url: '/new/checkArhiv/'+con,
        dataType: 'json',
        success: function(data){
            if(data){
                alert('На замер '+data[0]['contract']+' '+data[0]['date_dis']+' выезжал дизайнер '+data[0]['designer']+'.\t\nВосстановите из архива (если запись в архивах) и перенесите выезд на новую дату.');
                document.location.replace('/designer/arhiv');
            }
        }
    })
}
$('.contr').click(function(){
    var id = $(this).parent().parent().attr('id');
    document.location.replace('/designer/sample/'+id);
});


$('.formimg').click(function(){
    $(this).hide();
    $('.redactiruemyj').hide();
    $('.hidden').show();
});
$('.formdis').click(function(){
    $(this).hide();
    $('.disredactiruemyj').hide();
    $('#i_dis').show();
    //проверка наличия селекта, если нет, тогда доставать список дизайнеров, а если есть - пользоваться
    var issel = $('#i_dis').html();
    if(issel == ''){
        //достать список дизайнеров и сделать селект
        $.ajax({
            url:'/new/GetDisList',
            dataType:'json',
            success:function(data){
                var newdiv = document.createElement( "select" );
                //var newbtn = document.createElement("button");
                $('#i_dis').append(newdiv);
                for (var i=0; i<data.length; i++){
                    $(newdiv).append("<option value='"+data[i]['uid']+"'>"+data[i]['name']+"</option>")
                }
                $('#i_dis').append('<input type="button" value="Сохранить" onclick="saveDesign();"/>');
            }
        });
    }
});

function saveChanges(){
    var iname = document.getElementById('i_name').children[0].value,
        name = document.getElementById('name').innerHTML,
        iadress = document.getElementById('i_adress').children[0].value,
        adress = document.getElementById('adress').innerHTML,
        iphone = document.getElementById('i-phone').lastElementChild.value,
        phone = document.getElementById('phone').getElementsByTagName('b')[0].innerHTML,
        iemail = document.getElementById('i-email').lastElementChild.value,
        email = document.getElementById('email').getElementsByTagName('b')[0].innerHTML,
        oid = document.getElementById('orderid').value;
    //alert(oid);
    //if(iname = name)
    name = name.replace(/\s+$/,"").replace(/^\s+/,"");
    adress = adress.replace(/\s+$/,"").replace(/^\s+/,"");
    phone = phone.replace(/\s+$/,"").replace(/^\s+\+/,"");
    email = email.replace(/\s+$/,"").replace(/^\s+/,"");
    //name = name.replace(/^\s+/,"");
    var data='';
        if(iname != name) data+='&name='+iname;
        if(iadress != adress) data+='&adress='+iadress;
        if(iphone != phone) data+='&phone='+iphone;
        if(iemail != email) data+='&email='+iemail;
    //alert(data=="");
    if(data != ""){
        data='oid='+oid+data;
        $.ajax({
            url:'/order/SaveChanges',
            data:data,
            type:'post',
            success:function(data){
                if(data == 1){
                    document.getElementById('name').innerHTML=iname;
                    document.getElementById('adress').innerHTML=iadress;
                    document.getElementById('phone').getElementsByTagName('b')[0].innerHTML=iphone;
                    document.getElementById('email').getElementsByTagName('b')[0].innerHTML=iemail;
                }
            }
        });
    }

    $('.redactiruemyj').show();
    $('.formimg').show();
    $('.hidden').hide();
}

function saveDesign(){
    var oid = $('#orderid').val(),
        disid = $('#i_dis select').val(),
        dis = $('#i_dis option:selected').text();
    $.ajax({
        url:'/order/SaveChanges',
        type:'post',
        data:'oid='+oid+'&uid='+disid,
        success:function(data){
            if(data==1){
                $('.disredactiruemyj').show();
                $('.formdis').show();
                $('#i_dis').hide();
                $('.disredactiruemyj').html(dis);
            };
        }
    })
}

function saveCoord(){
    var polell = document.getElementById('latlng_order');
    var latlng = polell.value;
    var re = /^\d{2}\.\d{6}, \d{2}\.\d{6}$/;
    //var twoparts = latlng.split(', ');
    if(re.test(latlng)){
        var oid = document.getElementById('orderid').value;
        $.ajax({
            type:'post',
            url:'/order/changeCoords',
            data:'oid='+oid+'&latlng='+latlng,
            success:function(data){
                if(data){
                    //удалить поле и кнопку
                    document.getElementById('btnll').remove();
                    polell.remove();

                }
            }
        })
    }else{
        alert('Введенная строка не соответствует шаблону: "xx.xxxxxx, yy.yyyyyy"');
    }

}

//каждые 20 секунд проверяем новые сообщения и выводим их цифру
function checkNewCallMessages(){
    // $.ajax({
    //     url:'/callmessages/CheckNewMess',
    //     success:function(data){
    //         if(data==0){
    //             document.getElementById('newmesnum').style.display = 'none';
    //         }
    //         if(data!=0){
    //             document.getElementById('newmesnum').style.display = 'block';
    //             document.getElementById('newmesnum').innerHTML = data;
    //         }
    //     }
    // })
}

function inputCalendarDisplay(selectid,inputid){
    var poledate = document.getElementById(selectid),
        input_calendar = document.getElementById(inputid);
//input_calendar.style.display = 'none';
    poledate.addEventListener('change',function(){
        if(this.value=='date'){
            if(input_calendar.classList.contains('invisible')){
                input_calendar.classList.remove('invisible')
            }
            //input_calendar.style.display = '';
        }else{
            if(!input_calendar.classList.contains('invisible')){
                input_calendar.classList.add('invisible')
            }
            //input_calendar.style.display = 'none';
        }
    });
}

function Snab(event, otdel) {
    var els = document.getElementsByClassName(otdel),
        btn = event.target;
    console.log(event.target);
    // els[0].style.display = "none"
    var vis = "",
        colbtn = "#9fd2d7";
    if(els[0].style.display == ""){
        vis = "none";
        colbtn = "#6c8d92";
    }

    // console.log(vis);
    btn.style.backgroundColor = colbtn;

    for(i=0; i<els.length; i++){
        els[i].style.display = vis;
    }
}

function change_olStan(etap) {
    var oid = document.getElementById('orderid').value;
    var img = document.getElementById(etap);
    var filename = img.src.substr(-5,1);
  //  alert (filename);

    if (filename == 0) filename = 1;
    else if (filename == 1) filename = 0;
    if (filename!= 2) {
        img.src = '/images/' + filename + '.jpg';
        $.ajax({
            type: 'post',
            url: '/oldi/changeStan',
            data: 'etap=' + etap + '&val=' + filename + '&oid=' + oid
        });
    }
}

// $('#strelka').click(function changeDate(){

//     $('#fon').show();
//     $('#calendar').show();

// });

$('.cal').click(function(event){

    var day = ('0' + (this.id.split('-')[0])).slice(-2);
    var mes = ('0' + (this.id.split('-')[1])).slice(-2);
    var yer = this.id.split('-')[2];
    var datadate = day+'-'+mes+'-'+yer;

    $('#fon').hide();
    $('#calendar').hide();
    //не проверяя квадратуру
    $('#plan_date').html(day+'.'+mes);
    $.ajax({
        url:'/oldi/changeDate',
        type: 'post',
        data: 'date='+datadate+'&oid='+$('#orderid').val()
    });
});

$('#but_order').click(function(){
    $('.input').show();
    $('.znach').hide();
});


$('#but_form').click(function(){
    $('.znach').show();
    $('.input').hide();

    var oid = $('#orderid').val();

    var tip;
    var tip_v = $(":radio[name=tip]").filter(":checked").val();
    if (tip_v == 1){
        tip = 'ПВХ';
    }else{
        tip = 'эмаль';
    }

    if ($('#tipe').html() != tip){
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'tip', val:tip_v}),
            success: function(html){
                location.reload();
            }
        });
    }

    var col = $("input[name=color]").val();
    var pokr = $("#pokr option:selected").text();
    var col_pokr = col + ' ' + pokr;
    if($('#color_pokr').html() != col_pokr){
        var pokrdb = $("#pokr option:selected").val();
        if (pokrdb == 0 || pokrdb == 1){
            $('#polir').attr('src', '/images/2.jpg');
        }else{
            $('#polir').attr('src', '/images/0.jpg');
        }
        if (pokrdb >= 0 && pokrdb < 3){
            $('#spef').attr('src', '/images/2.jpg');
        }else{
            $('#spef').attr('src', '/images/0.jpg');
        }
        $('#color_pokr').html(col_pokr);
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'pokr', val:pokrdb})
        });
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'color', val:col})
        });
    }


    var def = $("#defemal option:selected").text();
    var defdb = $("#defemal option:selected").val();
    if($('#dopeff').html() != def){
        $('#dopeff').html(def);
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'dop_ef', val:defdb})
        });
    }

    var mkvdb = $('#mkv').val().replace(",",".");
    var mkv = mkvdb + ' м<sup>2</sup>';
    if($('#kvadr').html() != mkv){
        $('#kvadr').html(mkv);
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'mkv', val:mkvdb})
        });
    }

    var foto;
    var fotodb;
    var file;
    if ($("#fotopech").prop("checked")){
        foto = 'есть';
        fotodb = 1;
        file = 0;
    }else{
        foto = 'нет';
        fotodb = 0;
        file = 2;
    }
    if($('#fotopechat').html() != foto){
        $('#fotopec').attr('src', '/images/'+file+'.jpg');
        $('#fotopechat').html(foto);
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'fotopec', val:fotodb})
        });
    }

    var rad;
    var raddb;
    var file;
    if ($("#rradius").prop("checked")){
        rad = 'есть';
        raddb = 1;
        file = 0;
    }else{
        rad = 'нет';
        raddb = 0;
        file = 2;
    }
    if($('#radiusnye').html() != rad){
        $('#radius').attr('src', '/images/'+file+'.jpg');
        $('#radiusnye').html(rad);
        $.ajax({
            type:'post',
            url:'/oldi/changeAbout',
            data:({oid:oid, pole:'radius', val:raddb})
        });
    }
});

function showAddNote(){
    $('#polenote').show();
    $('#notes_main a').hide();
}

function addOldiNote(){
    var note = $('#note').val(),
        oid = $('#orderid').val(),
        date = $('#date_today').val();
    var add = '<p><b>'+date+'</b> '+note+'</p>';
    $('#notes').append(add);
    var add_to_db = $('#notes').html();
    $.ajax({
        type:'post',
        url:'/oldi/addNote',
        data:'note='+add_to_db+'&oid='+oid
    })
}

function changePass(){
    var uid = document.getElementById('uidtochange').value,
        newpass = document.getElementById('newpass').value;
    if(newpass != ''){
    $.ajax({
        type:'post',
        url:'/staff/changeUserData',
        data:'uid='+uid+'&data=user_password&val='+newpass,
        success: function(data){
            if(data){
                alert('Пароль изменен');
            }
            else{
                alert('Произошла ошибка! Пароль не изменен.');
            }
            $('#fon').hide();
            $('#formPass').hide();

        }
    });
    }
}

function changeLogin(){
    var uid = document.getElementById('uidtochange').value,
        newname = document.getElementById('newlog').value;
    if(newname != ''){
    $.ajax({
        type:'post',
        url:'/staff/changeUserData',
        data:'uid='+uid+'&data=user_login&val='+newname,
        success: function(data){
            console.log(data);
            if(data){
                alert('Пользователь переименован');
                console.log('log'+uid);
                var dom = 'log'+uid;
                document.getElementById(dom).innerHTML = newname;
            }
            else{
                alert('Произошла ошибка! Изменения не сохранены');
            }
            $('#fon').hide();
            $('#formLogin').hide();

        }
    });
    }
}


function changeName(){
    var uid = document.getElementById('uidtochange').value,
        newname = document.getElementById('newname').value;
    if(newname != ''){
    $.ajax({
        type:'post',
        url:'/staff/changeUserData',
        data:'uid='+uid+'&data=name&val='+newname,
        success: function(data){
            console.log(data);
            if(data){
                alert('Пользователь переименован');
                console.log('name'+uid);
                var dom = 'name'+uid;
                document.getElementById(dom).innerHTML = newname;
            }
            else{
                alert('Произошла ошибка! Изменения не сохранены');
            }
            $('#fon').hide();
            $('#formName').hide();

        }
    });
    }
}

$('#attention').click(function(){
    var att = this.dataset.attention,
        oid = $('#orderid').val(),
        btn = this,
        btncol = "#ee0101",
        btntextcol = "#F9E4D8";
        att++;
            console.log(att);

        if(att == 2){
            att = 0;
            btncol = "#f06c6c";
            btntextcol = "#772C00";
        }
        $.ajax({
            type:'post',
            url:'/order/saveChanges',
            data:'oid='+oid+'&attention='+att,
            success:function(data){
                if(data == 1){
                    btn.style.backgroundColor = btncol;
                    btn.style.color = btntextcol;
                    btn.dataset.attention = att;
                }
            }
        });
    
})

