window.addEventListener('load',function() {
    //alert('fdfd');
    var clnamepole = document.getElementById('client_name'),
        clname = clnamepole.value,
        clphonepole = document.getElementById('client_phone'),
        clphone = clphonepole.value,
        clphonepole2 = document.getElementById('client_phone2'),
        clphone2 = clphonepole2.value,
        clphonepole3 = document.getElementById('client_phone3'),
        clphone3 = clphonepole3.value,
        clemailpole = document.getElementById('email'),
        clemail = clemailpole.value,
        clcallmanpole = document.getElementById('callman'),
        clcallman = clcallmanpole.innerText,
        buttons_block = document.getElementById('buttons_block'),
        btnok = document.getElementById('btnok'),
        btncancel = document.getElementById('btncancel'),
        clid = document.getElementById('idclient').value;

    //проверка на ввод телефонных номеров
    clphonepole.addEventListener('blur',checkPhone);
    clphonepole2.addEventListener('blur',checkPhone);
    clphonepole3.addEventListener('blur',checkPhone);

    clnamepole.addEventListener('keyup',checkvisibiliti_buttons);
    clphonepole.addEventListener('keyup',checkvisibiliti_buttons);
    clphonepole2.addEventListener('keyup',checkvisibiliti_buttons);
    clphonepole3.addEventListener('keyup',checkvisibiliti_buttons);
    clemailpole.addEventListener('keyup',checkvisibiliti_buttons);
    //clnamepole.addEventListener('keyup',checkvisibiliti_buttons);

    btncancel.addEventListener('click',function(){
    //    проверить все изменения и вернуть в былой вид
        var newclname = clnamepole.value,
            newclcallman = clcallmanpole.innerText,
            newclemail = clemailpole.value,
            newclphone = clphonepole.value,
            newclphone2 = clphonepole2.value,
            newclphone3 = clphonepole3.value;

        if(newclname != clname){
            clnamepole.value = clname;
        }
        if(newclcallman != clcallman){
            clcallmanpole.innerText = clcallman;
        }
        if(newclemail != clemail){
            clemailpole.value = clemail;
        }
        if(newclphone != clphone){
            clphonepole.value = clphone;
        }
        if(newclphone2 != clphone2){
            clphonepole2.value = clphone2;
        }
        if(newclphone3 != clphone3){
            clphonepole3.value = clphone3;
        }
    //    кнопки спрятать
        buttons_block.classList.add('hidden');
    });

    btnok.addEventListener('click',function(){
        var datasforphp = 'id='+clid,
            newclname = clnamepole.value,
            newclcallman = clcallmanpole.innerText,
            newclemail = clemailpole.value,
            newclphone = clphonepole.value,
            newclphone2 = clphonepole2.value,
            newclphone3 = clphonepole3.value,
            error = '';

        if(newclname != clname){
            datasforphp += '&clname='+newclname;
        }
        if(newclcallman != clcallman){
            datasforphp += '&callman='+newclcallman;
        }
        if(newclemail != clemail){
            datasforphp += '&clemail='+newclemail;
        }
        if(newclphone != clphone){
            //проверка наличия в базе номера
            $.ajax({
                url:'/contacts/CheckDublContact',
                type:'post',
                data:'phone='+newclphone,
                async:false,
                success:function(data){
                    if(data > 0){
                        alert('Номер телефона уже есть в базе');
                        error = 'dubl';
                    }
                    else{
                        datasforphp = datasforphp + '&clphone='+newclphone;
                    }
                }
            });
        }
        if(newclphone2 != clphone2){
            //проверка наличия в базе номера
            $.ajax({
                url:'/contacts/CheckDublContact',
                type:'post',
                data:'phone='+newclphone2,
                async:false,
                success:function(data){
                    if(data > 0){
                        alert('Номер телефона уже есть в базе');
                        error = 'dubl';
                    }
                    else{
                        datasforphp += '&clphone2='+newclphone2;
                    }
                }
            });
        }
        if(newclphone3 != clphone3){
            //проверка наличия в базе номера
            $.ajax({
                url:'/contacts/CheckDublContact',
                type:'post',
                data:'phone='+newclphone3,
                async:false,
                success:function(data){
                    if(data > 0){
                        alert('Номер телефона уже есть в базе');
                        error = 'dubl';
                    }
                    else{
                        datasforphp += '&clphone3='+newclphone3;
                    }
                }
            });
        }
        //без имени и 1 номера телефона контакт не добавлять и не исправлять!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if((clname==''&&newclname=='')||(clphone==''&&newclphone=='')){
            alert('Недостаточно иформации');
            error = 'info';
        }
        if(error == ''){
            //alert(datasforphp);
            $.ajax({
                url:'/contacts/addChange',
                type:'post',
                data:datasforphp,
                success:function(data){
                    if(data){
                        //    кнопки спрятать
                        buttons_block.classList.add('hidden');
                    }
                }
            })
        }
    });

    function checkvisibiliti_buttons(){
        var newclname = clnamepole.value,
            newclcallman = clcallmanpole.innerText,
            newclemail = clemailpole.value,
            newclphone = clphonepole.value,
            newclphone2 = clphonepole2.value,
            newclphone3 = clphonepole3.value;
        if(clname==newclname&&newclcallman==clcallman&&newclemail==clemail&&newclphone==clphone&&newclphone2==clphone2&&newclphone3==clphone3){
            //    скрыть кнопки
            if(!buttons_block.classList.contains('hidden')){
                buttons_block.classList.add('hidden');
            }
        }
        else{
            //    показать кнопки
            if(buttons_block.classList.contains('hidden')){
                buttons_block.classList.remove('hidden');
            }
        }
    }

    function checkPhone(){

        var phone = this.value;
        phone = phone.replace(/\D/g,'');
        //console.log(phone.match(/^8(\d{10})$/));
        phone = phone.replace(/^8(\d{10})$/,'7$1');
        phone = phone.replace(/^(\d{10})$/,'7$1');
        if(phone.search(/^7\d{10}$/)==-1&&phone!=''){
            this.style.color = 'red';
            buttons_block.classList.add('hidden');
            alert('Номер не распознан!')
        }else{
            this.style.color = '';
        }

        this.value = phone;
    }
});