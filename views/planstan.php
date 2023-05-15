<style>
    .tablestan{
        background-color: #222;
        width:96%;
        margin:auto;
        margin-top:20px;
    }
    .tablestan td{
        background-color: #fff;
    }
    .tablestan th{
        background-color: #ddd;
        border: none;
    }
    .cl0{
        background-color: #CCFFFF !important;
    }
    .cl1{
        background-color: #666666 !important;
    }
    .cl2{
        background-color: #33bb00 !important;
    }
    .center_align{
        margin-top: 80px;
    }
    .visible{
        display: table-row;
    }
    .tablenone{
        display: none;
    }
    .form{
        position: fixed;
        width: 300px;
        height: 200px;
        z-index: 2;
        background-color: white;
        display: none;
    }
</style>
<div class="content">
    <div class="center_align">
        <h4 style="display: inline">Сроки отображения c </h4>
        <input type="text" id="begin" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
        <h4 style="display: inline"> по </h4>
        <input type="text" id="end" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)">
        <button onclick="showlist('plan',<?=$ri;?>)">Показать</button>
    </div>
    <div>
        <button id="btnall" class="btndisplay" disabled onclick="displayTable('all')" <?php echo ($ri==4?'style="display:none"':'')?>>Все</button>
        <button id="btnord" class="btndisplay" onclick="displayTable('orders')" <?php echo ($ri==4?'style="display:none"':'')?>>Заказы</button>
        <button id="btnclm" class="btndisplay" onclick="displayTable('claims')">Рекламации</button>
    </div>
    <table id="tablestan" class="tablestan">
    </table>
</div>
<div id="fon"></div>
<div id="form2" class="form"></div>