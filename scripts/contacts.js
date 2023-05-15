window.addEventListener('load',function(){
    var delarr = document.getElementsByClassName('del_cont');
    for (var i=0; i<delarr.length; i++){
        delarr[i].addEventListener('click',function(){
            var clid = this.parentNode.parentNode.dataset.clid;
            $.ajax({
                url:'/contacts/AddChange',
                type:'post',
                data:'id='+clid+'&stan=delete'
            });
            this.parentNode.parentNode.classList.add('hidden');
        })
    }
    var addtodoarr = document.getElementsByClassName('add_todo');
    var modal = document.getElementById('modal_todo');
    var clid;
    for (var j=0; j<addtodoarr.length; j++){
        addtodoarr[j].addEventListener('click',function(){
            var tr_clid = this.parentNode.parentNode,
                name = tr_clid.firstElementChild.innerText;
            clid = tr_clid.dataset.clid;
            if(name == 'Неизвестный контакт'){
                alert('Невозможно привязать задачу безымянному контакту');
            }
            else{
                modal.style.display = 'block';
                document.getElementById('customer').value = name;
                document.getElementById('clid').value = clid;
                var text_area__data = document.getElementById('text_area__data'),
                    text_area = document.getElementById('text_area');
                text_area__data.focus();
                text_area.addEventListener('click',function(){
                    text_area__data.focus();
                });
                inputCalendarDisplay('new_date','input_calendar');//script.js
            }
        })
    }

    var btnformok = document.getElementById('btnok'),
        btnformcnc = document.getElementById('btncancel');

    btnformok.addEventListener('click',function(){
        var client=document.getElementById('clid').value,
            sdelka=document.getElementById('leadid').value,
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
                }
            }
        });
        modal.style.display = 'none';
    });
    btnformcnc.addEventListener('click',function(){
        modal.style.display = 'none';
    });

})
