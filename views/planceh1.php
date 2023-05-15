<style type="text/css">

    .plceh_graf{
        width: 80%;
        position: fixed;
        right: 0px;

    }
    .plceh_list{
        width: 15%;
        background-color: ghostwhite;
    }

    .plceh_date{
        background: paleturquoise;
        text-align: center;
        font-size: 1.5em;

    }
    .plceh_date a:link, .plceh_date a:visited{
        text-decoration: none;
        font-weight: bold;
        font-family: 'Comic Sans MS', sans-serif;
        color: black;
    }
    .plceh_date a:hover{
        color: rebeccapurple;
    }
    .plceh_oneday{
        background-color: ghostwhite;
        text-align: center;
    }
    .plceh_oneday_label{
        background-color: #c8b9e2;
        line-height: 2;
        font-family: "Comic Sans MS", cursive;
        font-size: 20px;
        margin-top: 5px;
    }
    .plceh_table{
        display: block;
        /*! width: 100%; */
        min-height: 220px;
    }
    .span33{
        display: inline;
        width: 22%;
        min-height: 200px;

    }
    .span_zagol{
        text-align: center;
        background-color: #ffe9f3;
    }
    .btn{
        bottom: 20px;
    }
    .btn button{
        font-size: 1.2em;
        width: 22em;
    }
    .btn a button{
        font-size: 0.9em;
        width: 12em;
        padding: 0.15em
    }
    .form{
        font-size: 1.6em;
        border: outset 7px aquamarine;
        height: auto;
    }
    .mater{
        float: right;
        margin-right: 20px;
        background-color: #097246;
        width: 40px;
        color: #d2f5fa;
        text-align: center;
        font-size: 0.8em;
    }
    #today a{
        float: right;
        margin-right: 20px;
        font-size: 1em;
        color: #4f697d;
        font-weight: normal;
    }
</style>
<div class="content">
    <input type="hidden" id="pole">
    <div class="plceh_graf">

        <div class="plceh_date">
            <div id="today"><a href="/plan/ceh">сегодня</a></div>
            <a href="/plan/ceh/<?=$date-60*60*24*7;?>">
                <span><<&nbsp;&nbsp;</span>
            </a>
            <a href="/plan/ceh/<?=$date-60*60*24;?>">
                <span>&nbsp;&nbsp;<&nbsp;&nbsp;</span>
            </a>
            <span id="date"><?=$userdate;?></span>
            <a href="/plan/ceh/<?=$date+60*60*24;?>">
                <span>&nbsp;&nbsp;>&nbsp;&nbsp;</span>
            </a>
            <a href="/plan/ceh/<?=$date+60*60*24*7;?>">
                <span>&nbsp;&nbsp;>></span>
            </a>
        </div>


<!--        <div class="plceh_date">-->
<!--            <a href="/plan/ceh/--><?//=$date-60*60*24;?><!--"><span><< </span></a>-->
<!--            <span id="date">--><?//=$userdate;?><!--</span>-->
<!--            <a href="/plan/ceh/--><?//=$date+60*60*24;?><!--"><span> >></span></a>-->
<!--        </div>-->
        <?php for($i=0; $i<2; $i++):?>
        <div class="plceh_table">
            <?php foreach($shablon[$i] as $key=>$val):?>
                <div class="span33" id="<?=$key;?>">
                    <div class="span_zagol"><?=$val;?></div>
                    <div class="plceh_list2">
                        <?php foreach($list_graf[$arr_stan[$key]] as $arrord):?>
                            <?php
                            $bgc = '#DFFFE4';
                            if(strtotime($arrord[$arr_stan_date[$key]]) < strtotime('today')) $bgc = '#ff6083';
                            if($arrord[$arr_stan[$key]]==2) $bgc = '#00b050';
                            ?>
                        <div>
                            <div class="mater"><?= $arrord['mater'];?></div>
                            <div id="<?=$key.'-'.$arrord['id']?>" style="background-color: <?=$bgc;?>" data-stan="<?=$arrord[$arr_stan[$key]];?>">
                                <?=$arrord['contract']?>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php ?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <?php endfor;?>
    </div>
    <div class="plceh_graf btn">
        <button id="planbtn" onclick="progression();" disabled>Изменить последовательность</button>
        <button id="stanbtn" onclick="planCehStan();" disabled>Отметить готовность</button>
        <a href="/plan/part">
            <button>Разбить на части</button>
        </a>
    </div>
    <div class="plceh_list" id="list1">
        <?php for($d=0; $d<30; $d++):?>
            <div class="plceh_oneday">
                <div class="plceh_oneday_label"><?echo $week[date('w', strtotime('today')+$d*24*3600)]. ', ' .date('d.m', strtotime('today')+$d*24*3600)?></div>
                <?php if(isset($orders[$d])):?>
                    <?php foreach($orders[$d] as $key=>$arr):?>
                    <div>
                        <div class="mater"><?=$arr['mater'];?></div>
                        <div class="for_plan2" id="<?=$arr['oid'].'-'.$arr['stan'];?>"><?=$arr['con'];?></div>
                    </div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        <?php endfor;?>
    </div>
        <div id="fon" class="planceh"></div>
        <div class="form" id="porjadok">
            nen xnj-nj
        </div>
        <div class="form" id="gotovnost">
            nen xnj-nj
        </div>
</div>
<script type="text/javascript">

</script>