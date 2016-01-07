var dir = 'gm16';
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
    })


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
    var oid = domid.split('d')[0];
    var colldate = domid.split('d')[1];
    var con = $('#'+domid).text();
    $('#fon').show();
    $('#form').show();
    //заполнить ее данными
    $('#form label:first').html(con);
    $('#oid').val(oid);
    $('#exdate').val(colldate);

}

$('#fon').click(function(){

    $('#fon').hide();
    $('#form').hide();

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

