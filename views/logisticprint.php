<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <title>Полет водителей</title>
    <style type="text/css">
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
            width: 100%;
            margin-top: 50px;
        }

        th, td {
            padding:           0.2em;
            font-family: "Arial Hebrew", Arial, sans-serif;
            /*font-size: 1.5em;*/
        }

        th {
            font-weight:       bold;
            background-color:  #e5e5e5;
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
                font-family: "Arial Hebrew", Arial, sans-serif;
                font-size: 1.5em;
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
    <div class="content_main">
            <?php foreach ($listprint as $drid => $polet):
                $itog = 0;?>
        <table class="table print_ignore" id="<?=$drivers[$drid];?>">
                <tr>
                    <td><?=$drivers[$drid];?></td>
                    <td>
                        <p class="print_ignore">
                            <input type="button" class="button" value="Печать" onclick="printPage(this)" />
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>адрес</th>
                    <th>название</th>
                    <th>сумма</th>
                    <th>примечание</th>
                </tr>
                <?php foreach($polet as $oneaddress):
                $itog += $oneaddress['summ']?>
                    <tr>
                        <td><?=$oneaddress['address']?></td>
                        <td><?=$oneaddress['point']?></td>
                        <td><?=$oneaddress['summ']?></td>
                        <td><?=$oneaddress['note']?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td></td>
                    <th>Итого</th>
                    <th><?=$itog?></th>
                    <td></td>
                </tr>
        </table>
            <?php endforeach;?>
    </div>
</div>
</body>
</html>




