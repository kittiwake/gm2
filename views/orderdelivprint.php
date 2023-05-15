<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Бланк доставки</title>
    <style type="text/css">

        .nowrap {
            white-space: nowrap;
        }

        .hide {
            display: none;
        }
        .shapka img{
           /* width: 250px;*/
            float: left;
        }
        .shapka{
            color: white;
            font-size: 1.8em;
            text-align: center;
            height: 50px;
        }
        body, table, th, td {
            color:             #000;
            background-color:  #fff;
        }

        table, th, td {
            border: .1em solid #000;
        }

        table {
            border-collapse:   collapse;
            border-spacing:    0;
            width: 100%;
            /*margin-top: 50px;*/
        }
        tr:nth-child(3){
            font-size: 1.2em
        }
        tr:nth-child(3) td:first-child{
            text-decoration: underline double;
        }
        textarea{
            width: 70%
        }
        th, td {
            padding:           0.2em;
            /*font-family: "Arial Hebrew", Arial, sans-serif;*/
            /*font-size: 1.5em;*/
        }
        .pusto{
            font-size: 0.7em;
        }
        th {
            font-weight:       bold;
            background-color:  #e5e5e5;
        }
        td{
            min-height: 22px;
        }
        td:last-child{
            width: 70%;
        }
        td:first-child{
            text-align: right;
            vertical-align: top;
            font-style: italic;
        }
        .podpis{
            width: 40%;
            float: left;
            margin-left: 50px;
            margin-top: 20px;
        }
        @media print {
            .print_ignore {
                display: none;
            }

            .nowrap {
                white-space: nowrap;
            }

            .hide {
                display: none;
            }

            body, table, th, td {
                color:             #000;
                background-color:  #fff;
            }

            table, th, td {
                border: .1em solid #000;
            }

            table {
                border-collapse:   collapse;
                border-spacing:    0;
            }

            th, td {
                padding:           0.2em;
                /*font-family: "Arial Hebrew", Arial, sans-serif;*/
                /*font-size: 1.5em;*/
            }

            th {
                font-weight:       bold;
                background-color:  #e5e5e5;
            }
        }

    </style>
    <script type="text/javascript">
        function printPage(btn)
        {
            var tables = document.getElementsByClassName('table');
            for (var i = 0; i < tables.length; i++){
                if(!tables[i].classList.contains('print_ignore')){
                    tables[i].classList.add('print_ignore');
                }
            }
            var tbl = btn.closest('.table');
//            alert(tbl.style.color);
//            tbl.width = "100%";
            tbl.classList.remove('print_ignore');
            // Do print the page
            if (typeof(window.print) != 'undefined') {
                window.print();
            }
        }
    </script>
</head>

<body>
<div class="content">
    <div class="shapka" style="background-color: #999999">
        <?php
        if($order['company']=='mk'){
            ?>
            <img src="/images/logobr-104x50.png" width="100px" >
            <?php
        } else {
            ?>
            <img src="/images/logo-268x50.png" width="250px" >
            <?php
        }
        ?>
        <div>Договор № <span><?=$order['contract'];?></span></div>
    </div>
    <table>
        <tr>
            <td>Дата</td>
            <td id="date"><?=$stan['plan'];?></td>
        </tr>
        <tr>
            <td>Наименование изделия</td>
            <td><?=$order['product'];?></td>
        </tr>
        <tr>
            <td>Адрес доставки</td>
            <td>
                <?=$order['adress'];?>
                <br>
                +<?=$order['phone'];?>
                &nbsp<?=$order['name'];?>
            </td>
        </tr>
        <tr>
            <td>Доп. инфо</td>
            <td id="dopinfo" class="print_ignore">
                <textarea id="inpnote"></textarea>
                <input type="button" value="Ввести" onclick="addNote()">
            </td>
        </tr>
        <tr>
            <td>Количество упаковок</td>
            <td></td>
        </tr>
        <tr>
            <td>Остаток суммы</td>
            <td>
                Оплата за мебель - <span id="ostatok"><?=$order['sum']-$order['prepayment'];?></span>р.
                <?php if($order['sumdeliv']!=0):?>
                <span id="noprint" >
                    Доставка -
                <span id="dost"><?=$order['sumdeliv'];?></span>
<!--                <span id="input">-->
<!--                <input type="text" id="inpdost">-->
<!--                <input type="button" value="Ввести" onclick="addSumm()">-->
<!--                </span>-->
                <br>
                Итого: <span id="itog"><?=$order['sum']-$order['prepayment']+$order['sumdeliv'];?></span>
                </span>
                <?php endif;?>

            </td>
        </tr>
        <tr>
            <td rowspan="7">Замечания (если есть)</td>
            <td class="pusto">&nbsp</td>
        </tr>
        <tr>
            <td class="pusto">&nbsp</td>
        </tr>
        <tr>
            <td class="pusto">&nbsp</td>
        </tr>
        <tr>
            <td class="pusto">&nbsp</td>
        </tr>
        <tr>
            <td class="pusto">&nbsp</td>
        </tr>
    </table>
    <div class="niz">
        <div class="podpis">Заказчик____________________</div>
        <div class="podpis">Экспедитор_____________________</div>
    </div>
</div>
</body>
<script type="text/javascript">
    //дата в формате 26 сентября 2017г.
    var date = document.getElementById('date').textContent;
    var parts = date.split('-'),
        year = parts[0],
        month = +parts[1],
        day = parts[2];
//    alert(month);
    var monthes = [""," января "," февраля "," марта "," апреля "," мая "," июня "," июля "," августа "," сентября "," октября "," ноября "," декабря "];
    var textdate = day + monthes[month] + year + 'г.';
    document.getElementById('date').innerHTML = textdate;

    function addSumm(){
        var sdost = document.getElementById('inpdost').value;
//        alert(sdost);
        if(sdost!=''){
            var ost = document.getElementById('ostatok').textContent,
                itog = parseInt(ost) + parseInt(sdost);
            document.getElementById('dost').innerHTML = sdost + 'р.';
            document.getElementById('itog').innerHTML = itog + 'р.';
            document.getElementById('input').style.display='none';
            document.getElementById('noprint').classList.remove('print_ignore');
        }
    }
    function addNote(){
        var text = document.getElementById('inpnote').value;
//        alert(text);
        if(text!=''){
            text = text.replace('\n','<br>');
//            alert(text.indexOf('\n'));
            document.getElementById('dopinfo').innerHTML = text;
            document.getElementById('dopinfo').classList.remove('print_ignore');
        }
    }


</script>
</html>




