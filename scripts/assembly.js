$('.table').mouseover(function(){
    var id = $(this).children(".date").attr('id');
    id = id.replace("date","free");
    $('#'+id).show();
    var m_date = id.split('-')[1];
    $.ajax({
        type:'post',
        url:'/assembly/getFreemen',
        data:'date='+m_date,
        dataType:'json',
        success:function(data){
            if(data.length != 0){
                for (var key in data){
                    var uid = 'free'+data[key]+'-'+m_date;
                    $('#'+uid).show();
                }
            }
        }
    });


});

$('.table').mouseout(function(){
    var id = $(this).children(".date").attr('id');
    id = id.replace("date","free");
    $('#'+id).hide();
});

function addMount() {
    var oid = $('#oid3').val();
    var date = $('#m_date').val();
    var uid = $('#form3 input[type="radio"]:checked').val();
    $.ajax({
        type:'post',
        url:'/assembly/addMounting',
        data:'oid='+oid+'&uid='+uid+'&datemsec='+date,
        success:function(data){
            location.reload();
        }
    })
}

function showFormAddingMount(oid, target){
    $('#oid3').val(oid);
    $('#target').val(target);
    $('#fon').show();
    $('#form2').show();

}

function delCol(oid, uid, m_date){//дата в миллисекундах
    $.ajax({
        type:'post',
        url: '/assembly/delCollector',
        data:'oid='+oid+'&uid='+uid+'&date='+m_date,
        success:function(data){
            location.reload();
        }
    });
}

function inPlanirovanie(pole){
    $('.plan_ass').hide();
    $('#in_'+pole).show();
    $('.ass_cell').removeClass("active");
    $('.ass_cell').addClass("passive");
    $('#'+pole).removeClass("passive");
    $('#'+pole).addClass("active");
}

function rewritesb(domid){
    var inpname = domid.substring(1);
    var divid = 'div'+ inpname;
    $.ajax({
        url: '/assembly/getName',
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

function rewrite(domid){
    var inpname = domid.substring(1);
    var divid = 'div'+ inpname;
    $('#'+divid).html('<input type="text" name="'+inpname+'" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"/>');
}
