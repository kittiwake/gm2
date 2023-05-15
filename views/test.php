        <input type='text' value='<?=$cont;?>' id='oid'>
        <div id='cont'></div>
        <script type="text/javascript">
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        if(!!vars['oid']){
            var con = document.getElementById('oid').value,
                div = document.getElementById('cont');
            // $.ajax({
            //     url: 'http://192.168.0.99/ship/excel/getforsnab',
            //     type:'get',
            //     data:'con='+con,
            //     // dataType: 'jsonp',
            //     async:'false',
            //     success: function(data){
            //         div.innerHTML = data;
            //         //   $.each(data.response.docs, function (index, doc){
            //             //   $.each(doc, function (key, val) {
            //                 // console.log(key + 'is' + val);
            //             //   });
            //         //   });
                    
            //               // if(data!=''){
            //         //     console.log('data');
            //         // }else{
            //         //     console.log('error');
            //         // }
            //     },
            //     error: function(XHR, textStatus, errorThrown ){
            //         console.log(textStatus);
            //     }
            // });
            
var ajax = function( opts ) {
  opts = {
    type: opts.type || "POST",
    url: opts.url || "",
    onSuccess: opts.onSuccess || function(){},
    data: opts.data || "xml"
  };
  var xhr = new XMLHttpRequest();
  xhr.open(opts.type, opts.url, true);
  xhr.onreadystatechange = function(){
    if ( xhr.readyState == 4 ) {
      switch (opt.sdata){
        case "json":
          opt.onSuccess(xhr.responseText);
          break;
        case "xml":
          opt.onSuccess(xhr.responseXML);
          break;
        default : 
          opt.onSuccess(xhr.responseText);;
      }          
    }
  };
  xhr.send(null);
}
var jsonSample = function(e){
  var callback = function( data ) {
    //полученные данные на самом деле являются строкой
    //метод JSON.parse используется для превращения строки в объект
    data = JSON.parse(data);
    /*
    после этого можно использовать обычные JS-ссылки для доступа к данным
    */
    div.innerHTML += "<p>"
      + data.sample.txt 
      +"</p>";
  }
  ajax({
    type: "GET",
    url: "http://192.168.0.99/ship/excel/getforsnab",
    onSuccess: callback,
    data : "json"
   })
  e.preventDefault();
}
jsonSample();

        }
        
// console.log(vars['oid']);
        </script>



