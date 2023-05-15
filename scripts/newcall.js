window.addEventListener('load',function(){
    document.getElementById('phone2').addEventListener('change',checkPhone);
    document.getElementById('phone3').addEventListener('change',checkPhone);
});
function clientMeneg(clid) {
    var namepole = document.getElementById('namecl'),
//addrpole = document.getElementById('addrcl'),
        mailpole = document.getElementById('mailcl'),
        istochpole = document.getElementById('istochcl'),
        tp2pole = document.getElementById('phone2'),
        tp3pole = document.getElementById('phone3'),

        name = namepole.value,
//addr = addrpole.value,
        mail = mailpole.value,
        istoch = istochpole.value,
        tp2 = tp2pole.value,
        tp3 = tp3pole.value;

    if(name == ''){
        var err1 = document.createElement('div');
        err1.className = 'errorcl';
        err1.innerHTML = 'Поле обязательное для заполнения';
        namepole.parentNode.previousElementSibling.appendChild(err1);
        var h = namepole.parentNode.previousElementSibling.style.height;
        namepole.parentNode.style.height = h;
    }
    if(istoch == ''){
        var err2 = document.createElement('div');
        err2.className = 'errorcl';
        err2.innerHTML = 'Поле обязательное для заполнения';
        istochpole.parentNode.previousElementSibling.appendChild(err2);
    }
    if(name != '' && istoch != ''){
//проверка номеров телефона
        if(tp2 != ''){
            tp2 = checkPhone(tp2);
            tp2pole.value = tp2;
        }
        if(tp3 != ''){
            tp3 = checkPhone(tp3);
            tp3pole.value = tp3;
        }
//добавить проверку мыла

        var logdiv = document.getElementById('hello');
        var login = logdiv.firstElementChild.innerText;
        document.getElementById('mailcl').value = login;
        $.ajax({
            url:'/telephone/ChangeClientData',
            type:'post',
            data:'idclient=' + clid + '&name=' + name + '&istoch=' + istoch + '&mail=' + mail + '&callmen=' + login + '&tp2=' + tp2 + '&tp3=' + tp3,
            success:function(data){
                if(data){
                    wind.remove();
                }
            }
        })
    }
}//заменить php

function contractErr(clid) {
    $.ajax({
        url: '/telephone/ChangeClientContr',
        type: 'post',
        data: 'idclient=' + clid + '&val=error',
        success: function (data) {
            if (data) {
                window.close();
            }
        }
    })
} //работает
function addContact(clid){
//закрыть окно
//открыть окно "добавить к существующему контакту"
    var head = document.getElementById('head');
    head.innerHTML = 'Добавить к существующему';
//поля по имени, по договору
    var cont = document.getElementById('cont'),
        rowadd = document.createElement('div'),
        cellzag = document.createElement('div'),
        //cellpole = document.createElement('div'),
        cellpole = document.createElement('div');
    cont.innerHTML = '<input type="hidden" id="prevclid" value="'+clid+'">';
    rowadd.className = 'rowcl';
    cont.appendChild(rowadd);
    cellzag.className = 'zagol';
    cellpole.className = 'cellcl';
    rowadd.appendChild(cellzag);
    rowadd.appendChild(cellpole);
    cellzag.innerHTML = '<img src="/images/find.jpg" style="border-radius: 10px; vertical-align: middle; "/>';

//cellpole.innerHTML = '<input type="text" id="namecl" size="60"/>';
    var input = document.createElement('input');
    input.id = 'namecl';
    input.type = 'text';
    input.size = '60';
    cellpole.appendChild(input);
    var findinfo = document.createElement('div');
    findinfo.className = 'infocl';
    findinfo.id = 'info';
    cont.appendChild(findinfo);

    input.addEventListener('keyup',findClient,false);
    input.addEventListener('focus',delbtn,false);

//при заполнении варианты
//при выборе варианта и потере фокуса закрыть это окно и открыть openWindow()
}//работает
function delbtn(){
    var btn = document.getElementById('btnadd');
    if(btn != null){
        btn.remove();
    }
}//работает
function findClient(){
    var name = this.value,
        findinfo = document.getElementById('info');
    if(name.length>1){
        $.ajax({
            url:'/telephone/findClient',
            type:'post',
            data:'name='+name,
            dataType:'json',
            success: function(data){
                if(data){
                    findinfo.innerHTML = '';
                    for(var k in data){
                        var namerow = document.createElement('div');
                        namerow.id = data[k]['id'];
                        namerow.innerHTML = data[k]['name'];
                        findinfo.appendChild(namerow);
                        namerow.addEventListener('click',selectName);
                    }
                }
            }
        });
    }
}//работает
function selectName(){
    var info = document.getElementById('info');
    var input = document.getElementById('namecl');
    var name = this.innerText,
        clid = this.id;
    info.innerHTML = '';
    input.value = name;
    var btn = document.createElement('button');
    btn.id = 'btnadd';
    btn.innerText = 'Добавить';
    input.parentNode.parentNode.appendChild(btn);
    btn.addEventListener('click',function(){addPhoneToName(clid)},false);
}//работает
function addPhoneToName(clid){
    var previd = document.getElementById('prevclid').value,
        tel = document.getElementById('callId').value;
    $.ajax({
        url:'/telephone/addPhoneToName',
        type:'post',
        data:'id=' + clid + '&phone=' + tel + '&previd=' + previd,
        success: function(data){
            if(data){
//wind.innerHTML = data;
//                window.close();
                //openWindow(tel);
                document.location.reload(true);
            }
        }
    })
}//работает

function checkPhone(){
    var phone = this.value;
    var test = /^\+7\d{10}$/.test(phone);
    if(!test){
        phone = '+7' + phone.replace(/\D/g, '').slice(-10);
    }
    //return phone;
    this.value = phone;
}

