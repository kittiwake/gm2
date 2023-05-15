window.addEventListener('load',function(){
    var surpage = window.location.pathname;
var dir = surpage.split('/')[1];

$('.one_from_list').click(function(){
    $('#fon').show();
    $('#dialog').show();
    $('#oid').val($(this).attr('id'));
    $('#dialog h3').html($(this).text());
});

$('#fon, #cancel').click(function(){
    $('#fon').hide();
    $('#dialog').hide();
});

$('#ok').click(function(){
    var oid = $('#oid').val();
    var arrUrl = surpage.split('/');
    var last = arrUrl.pop();
    $.ajax({
       type:'post',
        url:'/skedCeh/close',
        data:'oid='+oid+'&etap='+last,
        success: function(data){
            if(data == 0){
                alert("Заказ не закрыт, обратитесь с проблемой к разработчику");
            }else{
                //alert(window.location.pathname);
                document.location.reload();
            }
        }
    });
});
});