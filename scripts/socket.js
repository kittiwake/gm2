var wsi;

window.addEventListener('load', function () {
    function wsInstance() {
        var self = this;
        var ws;


        function init(address, token) {
            ws = new WebSocket(address);
            ws.onopen = function() {
                log("ws connected successfully");
                ws.send(token);
            };
            ws.onclose = onClose;
            ws.onmessage = onMessage;
            ws.onerror = onError;
            log("ws initialized");
        }
        function onClose() {
            log("ws closed");
            if (ws != null)
                ws = null;
        }
        function onMessage(message) {
            log("ws received message: " + message.data);
            //обработка данных в вебсокета
//открыть новое окно и вывести инфу о заказчике
//            var login = ;
            if(/\+\d{11}/.test(message.data)) {
                //проверить номер на NOTIFY_END
                var notify = checkNotifyEnd(message.data);

                //получить результат NOTIFY_END


                openWindow(message.data)
            }
        }
        function onError(err) {
            log("ws error: " + err);
        }

        this.send = function(message) {
            if (ws != null) {
                log("CALLING SEND: " + message);
                ws.send(message);
            } else
                log("CALLING SEND (NO CONNECTION): " + message);
        };
        this.connect = function(address, token) {
            log("CALLING CONNECT");
            init(address, token);
        };
        this.close = function() {
            if (ws != null) {
                log("CALLING CLOSE");
                ws.close();
            } else
                log("CALLING CLOSE (NO CONNECTION)");
        };

        function log(logMessage) {
            console.log(logMessage);
            //document.getElementById("sock-log").innerHTML += (logMessage+"<br />");
        }
    }

    // возвращает cookie с именем name, если есть, если нет, то undefined
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : false;
        //return matches ? decodeURIComponent(matches[1]) : undefined;
    }
//if(сущ кука)
    if(getCookie('token'))var token = getCookie('token');
    wsi = new wsInstance();
    var addr = 'ws://151.248.126.105:2205/calling';

    wsi.connect(addr,token);

    //document.getElementById("button-connect").addEventListener(
    //                                                'click',
    //                                                function() {wsi.connect(
    //                                                    document.getElementById("sock-addr").value,
    //                                                    document.getElementById("sock-msg").value
    //                                                );});
    //document.getElementById("button-disconnect").onclick = wsi.close;
});
window.addEventListener('unload', function () {
    wsi.close();
});

function openWindow(tel){ //запускает сокет
    //var tel = document.getElementById('phone').value;
    var newWin = window.open('/telephone/newCall?callId='+tel, 'call'+tel, 'width=980,height=800');
}
function opWin(){//запуск с кнопки
    var tel = document.getElementById('phone').value;
    var newWin = window.open('/telephone/newCall?callId='+tel, 'call'+tel, 'width=980,height=800');
}
function checkNotifyEnd(tel){
    var res='';
    $.ajax({
        url:'/telephone/checkNotifyEnd',
        type:'post',
        data:'phone='+tel,
        success:function(data){
            res = data;
        }
    });
    return res;
}
