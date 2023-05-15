<script type="text/javascript">
    window.addEventListener('load',function(){
        var inp = document.getElementById('c1');
        // console.log(contracts);
        inp.addEventListener('focus', function(){newInput(this)}, false);


        function newInput(inp) {
            var inps = document.getElementsByClassName('contract');
                console.log(inps);
            var l = inps.length;
                console.log(!!inps[l-2]);
            if((inp==inps[l-1] && !inp.value && !!inps[l-2]) || l==1){
            console.log(this);
                let inpn = document.createElement("input");
                inpn.type = "text";
                inpn.classList.add("contract");
                inp.after(inpn);
                inpn.addEventListener('focus', function(){newInput(this)}, false);
            }
            
        }
    });
</script>

<div class="content">
    <div class="content_main">
            Введите список всех заказов из списка
            <input type="text" class="contract" id="c1"/>

            <input type='button' value="Ok" />
    </div>
</div>    