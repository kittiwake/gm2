$('.staff').click(function(){
    var dom = this.id,
        action = dom.split('-')[0],
        pid = dom.split('-')[1];
    $('#fon').show();
    if(action == 'del'){
        $('#form_del').show();
        getUsersByPid(pid);
    }else{
        $('#form_add').show();
        $('#post_id').val(pid);
        //массив имен
        var names = [];
        $.ajax({
            url:'/staff/getAllNames',
            dataType:'json',
            success:function(data){
                for (var key in data) {
                    names.push(data[key]['name']);
                }
                $( "#new_worker" ).autocomplete({
                    source: names,
                    minLength: 2,
                    delay: 200
                });
            }
        });
    }
});

function getUsersByPid(pid){
    $.ajax({
        type:'post',
        url:'/staff/getListUsers',
        dataType: 'json',
        data:'pid='+pid,
        success: function(data){
            var div = '';
            for (var key in data) {
                    div += '<label><input type="radio" name="usname" value="'+data[key]['id']+'">'+data[key]['name']+'</label><br>';
            }
            div += '<button onclick="dismiss('+pid+')">Удалить</button>';
            $("#form_del").html(div);
        }
    });
}

function dismiss(pid){
    var uid = $('#form_del input[type="radio"]:checked').val();
    if(uid){
        $.ajax({
            type:'post',
            url:'/staff/dismissUser',
            data:'pid='+pid+'&uid='+uid,
            success: function(){
                $('.form').hide();
                $('#fon').hide();
            }
        })
    }
}

function appoint(){
    var pid = $('#post_id').val(),
        name = $('#new_worker').val();
    $.ajax({
        type:'post',
        url:'/staff/appointUser',
        data:'pid='+pid+'&name='+name,
        success: function(){
            $('.form').hide();
            $('#fon').hide();
        }
    })

}
//var checkAjax = null;
//$('.staffname').keyup(function(){
//    var con = $('#con').val();
//    var name = $('#name').val();
//    var phone = $('#phone').val();
//    var str = $('#str').val();
//    var h = $('#h').val();
//    var f = $('#f').val();
//    checkAjax = $.ajax({
//        dataType: 'json',
//        type: "POST",
//        url: '/find/find',
//        data: "con="+con+"&name="+name+"&phone="+phone+"&str="+str+"&h="+h+"&f="+f,
//        beforeSend: function() {
//            if(checkAjax != null) {
//                checkAjax.abort();
//            }
//        },
//        success: function(data){
//            $("#list").html("Найдено результатов: "+data.length+" <br>");
//            if(data.length != 0){
//                for (var i = 0; i < data.length; i++){
//                    $("#list").append("<div class='elem_list'><hr/>" +
//                    "	<p><a href='/"+dir+"/order/index/" + data[i][0]+"'><b class='ssylka'>"+data[i][1]+'</b></a> от '+data[i][5]+"</p>" +
//                    "<p>"+data[i][2]+" тел.:"+data[i][3]+" адрес:"+data[i][4]+"</p>" +
//                    "<p>Срок по договору: "+data[i][9]+"</p>" +
//                    "<p>Дата вывоза: "+data[i][6]+"</p>" +
//                    "<p>Дизайнер: "+data[i][8]+"</p>" +
//                    "<p>Технолог: "+data[i][7]+"</p>" +
//                    "<p>Сборки: "+data[i][10]+"</p>" +
//                    "<div class='note'>"+data[i][11]+"</div>" +
//                    "</div>");
//
//                }
//            }
//            checkAjax = null;
//        }
//    });
//});
