document.addEventListener('DOMContentLoaded', function(){
    var seldil = document.getElementById('selectdil'),
        olnum = document.getElementById('olnum'),
        lastolnum = document.getElementById('lastolnum'),
        con = document.getElementById('con'),
        con1 = document.getElementById('con1'),
        numval = olnum.value;
    seldil.addEventListener('change', function(event){
        var dilid = event.target.options[event.target.selectedIndex].value;
        if(dilid == 1){
            con1.removeAttribute('disabled');
            olnum.setAttribute('disabled','disabled');
            document.getElementById('phoneDil').value = '';
            con1.addEventListener('blur', function(event){
                con.value = this.value;
            });
        }else{
            var lastnum = event.target.options[event.target.selectedIndex].dataset.lastnum,
                sign = event.target.options[event.target.selectedIndex].dataset.sign,
                namedil = event.target.options[event.target.selectedIndex].text,
                dilphone = event.target.options[event.target.selectedIndex].dataset.phone;
                ln = parseInt(lastnum)+1;
            if(event.target.options[event.target.selectedIndex].value != 0){
                olnum.disabled = false;
                olnum.value = ln;
                lastolnum.value = lastnum;
                con.value = sign+' '+ln;
                con1.value = sign+' '+ln;
                document.getElementById('idDil').value = dilid;
                document.getElementById('nameDil').value = namedil;
                document.getElementById('phoneDil').value = dilphone;
            }else{
                olnum.disabled = false;
                con.value = '';
                olnum.value = '';
                lastolnum.value = '';
            }
        }
    });
    var oldnum = olnum.value;
    olnum.addEventListener('blur', function(event){
        var newnum = olnum.value,
            lastnum = seldil.options[seldil.selectedIndex].dataset.lastnum,
            sign = seldil.options[seldil.selectedIndex].dataset.sign,
            ln = parseInt(lastnum)+1;
        if(newnum===''){
            newnum=ln;
            lastolnum.value = lastnum;
            con.value = sign+' '+newnum;
            con1.value = sign+' '+newnum;
        }
        if(newnum != oldnum){
            con.value = sign+' '+newnum;
            con1.value = sign+' '+newnum;
        }
        //проверка на дубликат
        $.ajax({
            type: "POST",
            url: '/new/checkDublOldi',
            data: "con="+con.value,    
            success: function(data){
                // console.log(data);
                if(data != con.value){
                console.log('не совпало');
                    con.value = data;
                }
            }
        });
    });
    
    
});

/*
$('#selectdil').change(function() {
   $('#olnum').val($(this.options[this.selectedIndex]).attr('data-lastnum'));
});*/