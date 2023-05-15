window.addEventListener('load',function(){
    var okno = document.getElementById('modal_todo');
    //okno.style.display = 'none';
    var btnaddtodo = document.getElementById('todo_add_btn');

    btnaddtodo.addEventListener('click',function(){
        this.style.display = 'none';
        okno.style.display = 'block';
        var text_area__data = document.getElementById('text_area__data'),
            text_area = document.getElementById('text_area');
        text_area__data.focus();
        text_area.addEventListener('click',function(){
            text_area__data.focus();
        });
        inputCalendarDisplay('new_date','input_calendar');//script.js
        //var poledate = document.getElementById('new_date'),
        //    input_calendar = document.getElementById('input_calendar');
        //input_calendar.style.display = 'none';
        //poledate.addEventListener('change',function(){
        //    if(this.value=='date'){
        //        input_calendar.style.display = '';
        //    }else{
        //        input_calendar.style.display = 'none';
        //    }
        //});

    });
    var customer = document.getElementById('customer'),
        txt = customer.value;
    customer.addEventListener('keyup',function(){
        var text = this.value;
        if(text.length>2){
            $.ajax({
                url:'/todo/findAll',
                type:'post',
                data:'txt='+text,
                dataType:'json',
                success:function(data){
                    var list = document.getElementById('found_variants');
                    if(data.length == 0){
                        list.style.display = 'none';
                    }else{
                        list.style.display = 'block';
                        list.innerHTML = '';
                        for(var i=0; i<data.length; i++){
                            var div = document.createElement('div');
                            if('nomer' in data[i]){
                                //alert(data[i].nomer);
                                div.id = 'sd_' + data[i].id;
                                div.innerText = data[i].nomer;
                            }
                            else if('name' in data[i]){
                                div.id = 'cl_' + data[i].id;
                                if(data[i].name != ''){
                                    div.innerText = data[i].name;
                                }else{
                                    div.innerText = data[i].phone;
                                }
                            }
                            div.addEventListener('click',function(){
                                list.style.display = 'none';
                                customer.value = this.innerText;
                                customer.dataset.custCard = this.id;

                            });
                            div.addEventListener('mouseover',function(){
                                this.style.backgroundColor = '#eeefea';
                            });
                            div.addEventListener('mouseout',function(){
                                this.style.backgroundColor = 'white';
                            });

                            list.appendChild(div);
                        }
                    }
                }
            })
        }
    });

    var btnformok = document.getElementById('btnok'),
        btnformcnc = document.getElementById('btncancel');

    btnformok.addEventListener('click',function(){
        var client='',sdelka='',
            datetodo = document.getElementById('new_date').value,
            timetodo = document.getElementById('new_time').value,
            touser = document.getElementById('to_user').value,
            typetodo = document.getElementById('text_area').firstElementChild.innerText,
            texttodo = document.getElementById('text_area__data').innerText;
        //получить клиента или сделку
        var cust_card = document.getElementById('customer').dataset.custCard;
        if(cust_card!=''){
            var base = cust_card.split('_')[0];
            var id = cust_card.split('_')[1];
            if(base == 'cl'){
                client = id;
            }else{
                sdelka = id;
            }
        }

        if(datetodo == 'date'){
            datetodo = document.getElementById('input_calendar').value;
        }
        if(datetodo == ''){//если дата не указана, окно не закроется
            return;
        }else{
            datetodo = datetodo.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1');
        }
        if(timetodo=='Весь день'){
            timetodo = '00:00:00';
        }
        $.ajax({
            url:'/todo/newTodo',
            type:'post',
            data:'datetodo='+datetodo+'&timetodo='+timetodo+'&touser='+touser+'&typetodo='+typetodo+'&texttodo='+texttodo+'&client='+client+'&sdelka='+sdelka,
            success:function(data){
                if(data){
                    //поместить задачу в воронку
                    location.reload();
                }
            }
        });
        okno.style.display = 'none';
        btnaddtodo.style.display='';
    });
    btnformcnc.addEventListener('click',function(){
        okno.style.display = 'none';
        btnaddtodo.style.display='';
    });

    var itemsobj = document.getElementsByClassName('todo-line__item');
    for(var i=0; i<itemsobj.length; i++){
        itemsobj[i].addEventListener('click',function(){
            var modal_result = document.getElementById('modal_result');
            modal_result.style.display = 'block';
            inputCalendarDisplay('transfer_date','transfer_input_calendar');
            //передать параметры: сделка, клиент, дата, получатель, текст
            var zadachaId = this.id,
                sdelka_client = this.getElementsByClassName('todo-line__item-contacts-contact')[0].innerText,
                datime = this.getElementsByClassName('todo-line__item-data-time')[0].innerText,
                toUser = this.getElementsByClassName('todo-line__item-members')[1].innerText,
                frUser = this.getElementsByClassName('todo-line__item-members')[0].innerText,
                //toUser = this.,
                text = this.getElementsByClassName('todo-line__item-body')[0].innerText;
            //console.log(text);
            //console.log(frUser);
            var arrdatetime = datime.split(' '),
                itdate = arrdatetime[0],
                ittime = arrdatetime[1],
                arritdate = itdate.split('-'),
                arrittime = ittime.split(':'),
                ityear = arritdate[0],
                itmonth = arritdate[1],
                itday = arritdate[2];
            if(ittime=='Весь'){
                var ithour = '09',
                    itmin = '00',
                    itsec = '00';
            }else{
                var ithour = arrittime[0],
                    itmin = arrittime[1],
                    itsec = arrittime[2];
            }
            var now = new Date();//GMT+0 (UTC)
            var itemdate = new Date(ityear, itmonth-1, itday, ithour, itmin, itsec, 0);//GMT+0 (UTC)
            var lostutc = itemdate-now;
            var lost = '';
            var span = document.createElement('span');
            if(lostutc<0){
                span.classList.add('todo-line__item-lost');
                //день = 24*60*60*1000
                var lostutc = -lostutc,
                    lostms = lostutc%1000,
                    lostsec = ((lostutc-lostms)/1000)%60,
                    lostmin = ((((lostutc-lostms)/1000)-lostsec)/60)%60,
                    losthour = ((((((lostutc-lostms)/1000)-lostsec)/60)-lostmin)/60)%24,
                    lostday = (((((((lostutc-lostms)/1000)-lostsec)/60)-lostmin)/60)-losthour)/24;
                //console.log(now);
                //console.log(lost);
                //console.log(lostday);
                if(lostday>0){
                    lost = '(' + lostday + ' дня)'
                }else if(losthour>0){
                    lost = '(' + losthour + ' часа)'
                }else if(lostmin>0){
                    lost = '(' + lostmin + ' минут)'
                }
                //console.log(lost);
            }
            document.getElementById('sdelka_client').innerHTML = sdelka_client;
            span.innerHTML = itday+'.'+itmonth+'.'+ityear+', '+ithour+':'+itmin +' '+lost;
            document.getElementById('date-time-lost').innerHTML='';
            document.getElementById('date-time-lost').appendChild(span);
            document.getElementById('date-time-lost').appendChild(document.createTextNode(toUser));
            document.getElementById('zadacha_result').innerHTML = text;

            var resbtn = document.getElementById('result_btnok');
            resbtn.addEventListener('click',function(){
                //номер задачи zadachaId
                //получить примечание и сохранить в базу, заменив статус на исполнено
                var text_result = document.getElementById('text_result').value;
                //console.log(zadachaId);
                $.ajax({
                    url:'/todo/made',
                    type:'post',
                    data:'id='+zadachaId.split('_')[1]+'&txt='+text_result,
                    success:function(data){
                        document.getElementById(zadachaId).classList.add('invisible');
                        modal_result.style.display = 'none';
                    }
                });
            });
            var transfbtn = document.getElementById('transfer_btn');
            transfbtn.addEventListener('click',function(){
                //номер задачи zadachaId
                //получить новые сроки и сохранить в базу, заменив статус на исполнено
                var datetodo = document.getElementById('transfer_date').value,
                    timetodo = document.getElementById('transfer_time').value,
                    touser = document.getElementById('transfer_to_user').value;
                    //typetodo = document.getElementById('text_area').firstElementChild.innerText,
                    //texttodo = document.getElementById('text_area__data').innerText;
                //получить клиента или сделку

                if(datetodo == 'date'){
                    datetodo = document.getElementById('transfer_input_calendar').value;
                }
                if(datetodo == ''){//если дата не указана, окно не закроется
                    return;
                }else{
                    datetodo = datetodo.replace(/(\d{2})-(\d{2})-(\d{4})/,'$3-$2-$1');
                }
                //if(timetodo=='Весь день'){
                //    timetodo = '00:00:00';
                //}
                var todoid = zadachaId.split('_')[1];
                $.ajax({
                    url:'/todo/transfer',
                    type:'post',
                    data:'datetodo='+datetodo+'&timetodo='+timetodo+'&touser='+touser+'&todoid='+todoid,
                    success:function(data){
                        if(data){
                            document.getElementById(zadachaId).classList.add('invisible');
                            modal_result.style.display = 'none';
                            //новую задачу добавляем в воронку
                        }
                    }
                });
                //okno.style.display = 'none';
                //btnaddtodo.style.display='';
            });

            var delbtn = document.getElementById('delete_btn');
            delbtn.addEventListener('click',function(){
                $.ajax({
                    url:'/todo/delete',
                    type:'post',
                    data:'id='+zadachaId.split('_')[1],
                    success:function(data){
                        if(data){
                            document.getElementById(zadachaId).classList.add('invisible');
                            modal_result.style.display = 'none';
                        }
                    }
                })
            })
        })
    }

    var modalResult = document.getElementById('modal_result');
    modalResult.addEventListener('click', function(event){
        if(event.target==this) {
            this.style.display = 'none';
        }
    })


});
