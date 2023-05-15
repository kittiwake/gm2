<style>

    section {
        display: none;
        padding: 20px 0 0;
        border-top: 1px solid #abc;
    }
    input[name="tabs"] {
        display: none;
    }
    .tabs {
         display: inline-block;
         margin: 0 0 -1px;
         padding: 15px 25px;
         font-weight: 600;
         text-align: center;
         color: #abc;
         border: 1px solid transparent;
     }
    .tabs:hover {
        color: #789;
        cursor: pointer;
    }

    input[name="tabs"]:checked + label {
        color: darkcyan;
        border: 1px solid #abc;
        border-top: 2px solid darkcyan;
        border-bottom: 1px solid #fff;
    }
    #tabm:checked ~ #mater,
    #tabf:checked ~ #furn {
        display: block;
    }


    .deliv-info{
        display: flex;
    }
    .info-summ{}
    .info-summ_row{
        display: flex;
    }
    .info-summ__label{
        width: 250px;
    }
    .info-summ__val{
        width: 100px;
    }
    .deliv_form{
        width: 80%;
        height: 80%;
        overflow-y: auto;
    }
    .category-table{}
    .category-box:nth-child(2n){
        background-color: gainsboro;
    }
    .category-box{
        display: inline-block;
        width: 30%;
        border: solid 1px gray;
        padding: 2px;
        margin: 4px;
    }
    .category-item{
        display: flex;
    }
    .category-item__label{
        word-wrap: break-word;
        max-width: 121px;
    }
    .category-item__list-provider{}
    .category-item__list-provider input{
        background-color: inherit;
    }
</style>
<div class="content">
    <div class="content_main">
        <input type="hidden" id="oid" value="<?=$oid?>">
        <h2>Договор № <strong><?=$contract;?></strong></h2>
        <div class="deliv-info">
            <div class="info-summ">
                <div class="info-summ_row">
                    <div class="info-summ__label">Сумма договора</div>
                    <div class="info-summ__val"><?=$summ?></div>
                </div>
                <div class="info-summ_row">
                    <div class="info-summ__label">Предоплата</div>
                    <div class="info-summ__val"><?=$prepayment?></div>
                </div>
                <div class="info-summ_row">
                    <div class="info-summ__label">30% на материалы и фурнитуру</div>
                    <div class="info-summ__val" id="limit"><?=$limit?></div>
                    <div class="info-summ__label">из них потрачено</div>
                    <div class="info-summ__val" id="zatrat">0</div>
                </div>
                <div class="info-summ_row">
                    <div class="info-summ__label">10% на расходники</div>
                    <div class="info-summ__val"><?=$limrash?></div>
                </div>
            </div>
            <div class="deliv_about">
                <ins><em>Дизайнер</em></ins> <?=$dis;?><br />
                <br />
                <ins><em>Технолог</em></ins> <?=$tech;?><br />
                <br />
            </div>
        </div>

        <input id="tabm" type="radio" name="tabs" <?=$otd=='m'?'checked':'';?> >
        <label for="tabm" class="tabs">Материалы</label>

        <input id="tabf" type="radio" name="tabs" <?=$otd=='f'?'checked':'';?> >
        <label for="tabf" class="tabs">Фурнитура</label>

        <section id="mater">
            <div class="deliv_mater">
                <div class="deliv_list">
                    <table>
                        <tr>
                            <th>категория</th>
                            <th>материал</th>
                            <th>кол-во</th>
                            <th>поставщик</th>
                            <th>сумма</th>
                            <th>дата привоза</th>
                            <th>Состояние</th>
                        </tr>
                        <?php if(!empty($materList)):?>
                            <?php foreach($materList as $mater):
                                if($mater['otdel']=='m'):?>
                                    <tr id="tr<?=$mater['id']?>" data-otd="m" data-materid="<?=$mater['id']?>" data-outlay="<?=$mater['outlay_id']?>" data-logistid="<?=$mater['logist_id']?>"  data-con="<?=$contract?>">
                                        <td>
                                            <?php
                                            if(isset($categoryList[$mater['catid']]))
                                            echo $categoryList[$mater['catid']];
                                            else{
                                            ?>
                                                <select class="catins" style="width:150px;">
                                                    <option value="0"></option>
                                                    <?php foreach($categoryList as $key=>$category):?>
                                                        <option value="<?=$key?>"><?=$category?></option>;
                                                    <?php endforeach;?>
                                                </select>
                                            <?php
                                            }
                                            ?>
                                        
                                        </td>
                                        <td class="color" bgcolor="<?=$mater['status']?>"><?=$mater['designation']?></td>
                                        <td>
                                            <input type="text" style="width:100px;" class="deliv-input" value="<?=$mater['count']?>" placeholder="не задано" data-pole="count">
                                        </td>
                                        <td class="prov" data-prov="<?=$mater['prov_id']?>">
                                            <select class="deliv-select prov_<?=$mater['catid']?>" style="width:150px;">
                                                <option value="0">&nbsp;</option>
                                                <?php foreach($prov_categ[$mater['catid']] as $provid){?>
                                                    <option value="<?=$provid['prov_id']?>" <?=$provid['prov_id']==$mater['prov_id']?'selected':''?>><?=$provid['provider']?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" size="10" class="deliv-input input_summ" data-pole="summ" value="<?=$mater['summ']?>">
                                        </td>
                                        <td style="position: relative">
                                            <input type="text" size="10" class="deliv-input_date" data-pole="plan_date" value="<?=$mater['plan_date']=='0000-00-00'?'':preg_replace('/(\d{4})-(\d{2})-(\d{2})/','$3-$2-$1',$mater['plan_date'])?>"  onfocus="this.select();lcs(this);console.log('focus');" onclick="event.cancelBubble=true;this.select();lcs(this);console.log('click');">
                                        </td>
                                        <!--                            --><?php //if($ri==8):?>
                                        <td>

                                            <label><input type="radio" value="orangered" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'orangered' ? 'checked':'';?>>заказан</label><br>
                                            <label><input type="radio" value="forestgreen" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'forestgreen' ? 'checked':'';?>>привезен</label><br>
                                            <label><input type="radio" value="lavender" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'lavender' ? 'checked':'';?>>отмена</label><br>
                                            <input type="button" id="bt<?=$mater['id']?>" value="Удалить" onclick="delMaterial(this.id);">
                                        </td>
                                        <!--                                --><?php //endif;?>
                                    </tr>
                                <?php endif;
                            endforeach;?>
                        <?php endif;?>
                    </table>
                </div>
                <div class="deliv_add" data-otd="m">
                    Добавить позицию
                    <select name="category" id="category">
                        <option value="0"></option>
                        <?php foreach($categoryList as $key=>$category):?>
                            <option value="<?=$key?>"><?=$category?></option>;
                        <?php endforeach;?>
                    </select>
                    <input type="text" id="mater">
                    <input type="button" value="Добавить" onclick="addMater(this.parentNode)">
                </div>
            </div>
            <div class="deliv_admin">
                <!--            <a onclick="$('#fon').show();$('#form').show();">Добавить категорию</a> |-->
                <a onclick="$('#fon').show();$('#formnewsum').show();">Удалить категорию</a> |
                <a onclick="$('#fon').show();$('#formnewcut').show();">Поставщики</a>
            </div>
        </section>
        <section id="furn">
            <div class="deliv_mater">
                <div class="deliv_list">
                    <table>
                        <tr>
                            <th>категория</th>
                            <th>материал</th>
                            <th>кол-во</th>
                            <th>поставщик</th>
                            <th>сумма</th>
                            <th>дата привоза</th>
                            <th>Состояние</th>
                        </tr>
                        <?php if(!empty($materList)):?>
                            <?php foreach($materList as $mater):
                                if($mater['otdel']=='f'):?>
                                    <tr id="tr<?=$mater['id']?>" data-otd="f" data-materid="<?=$mater['id']?>" data-outlay="<?=$mater['outlay_id']?>" data-logistid="<?=$mater['logist_id']?>"  data-con="<?=$contract?>">
                                        <td>
                                            <?php
                                            if(isset($categoryFurnList[$mater['catid']]))
                                            echo $categoryFurnList[$mater['catid']];
                                            else{
                                            ?>
                                                <select class="catins" style="width:150px;">
                                                    <option value="0"></option>
                                                    <?php foreach($categoryFurnList as $key=>$category):?>
                                                        <option value="<?=$key?>"><?=$category?></option>;
                                                    <?php endforeach;?>
                                                </select>
                                            <?php
                                            }
                                            ?>
                                        
                                        </td>
                                        
                                        <td class="color" bgcolor="<?=$mater['status']?>"><?=$mater['designation']?></td>
                                        <td>
                                            <input type="text" style="width:100px;" class="deliv-input" value="<?=$mater['count']?>" placeholder="не задано" data-pole="count">
                                        </td>
                                        <td class="prov" data-prov="<?=$mater['prov_id']?>">
                                            <select class="deliv-select prov_<?=$mater['catid']?>" style="width:150px;">
                                                <option value="0">&nbsp;</option>
                                                <?php foreach($prov_categ[$mater['catid']] as $provid){?>
                                                    <option value="<?=$provid['prov_id']?>" <?=$provid['prov_id']==$mater['prov_id']?'selected':''?>><?=$provid['provider']?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" size="10" class="deliv-input input_summ" data-pole="summ" value="<?=$mater['summ']?>">
                                        </td>
                                        <td style="position: relative">
                                            <input type="text" size="10" class="deliv-input_date" data-pole="plan_date" value="<?=$mater['plan_date']=='0000-00-00'?'':preg_replace('/(\d{4})-(\d{2})-(\d{2})/','$3-$2-$1',$mater['plan_date'])?>"  onfocus="this.select();lcs(this);console.log('focus');" onclick="event.cancelBubble=true;this.select();lcs(this);console.log('click');">
                                        </td>
                                        <!--                            --><?php //if($ri==8):?>
                                        <td>

                                            <label><input type="radio" value="orangered" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'orangered' ? 'checked':'';?>>заказан</label><br>
                                            <label><input type="radio" value="forestgreen" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'forestgreen' ? 'checked':'';?>>привезен</label><br>
                                            <label><input type="radio" value="lavender" name="status<?=$mater['id']?>" <?php echo $mater['status'] == 'lavender' ? 'checked':'';?>>отмена</label><br>
                                            <input type="button" id="bt<?=$mater['id']?>" value="Удалить" onclick="delMaterial(this.id);">
                                        </td>
                                        <!--                                --><?php //endif;?>
                                    </tr>
                                <?php endif;
                            endforeach;?>
                        <?php endif;?>
                    </table>
                </div>
                <div class="deliv_add" data-otd="f">
                    Добавить позицию
                    <select name="category" id="category">
                        <option value="0"></option>
                        <?php foreach($categoryFurnList as $key=>$category):?>
                            <option value="<?=$key?>"><?=$category?></option>
                        <?php endforeach;?>
                    </select>
                    <input type="text" id="mater">
                    <input type="button" value="Добавить" onclick="addMater(this.parentNode)">
                </div>
            </div>
            <div class="deliv_admin">
                <!--            <a onclick="$('#fon').show();$('#form').show();">Добавить категорию</a> |-->
<!--                <a onclick="$('#fon').show();$('#formnewsum').show();">Удалить категорию</a> |-->
                <a onclick="$('#fon').show();$('#formnewcutf').show();">Поставщики</a>
            </div>
        </section>

        <div id="fon"></div>
        <div id="form" class="form">
            <br>
            <br>
            Введите название категории
            <input type="text" id="newcategory">
            <input type="button" id="deliv_ok" value="Ok" onclick="addCategory();">
        </div>
        <div id="formnewsum" class="form deliv_form">
            <?php foreach($categoryList as $key=>$category):?>
                <p><?=$category?><input type="button" id="<?=$key?>" onclick="dellCategory(this.id);" value="Удалить"></p>
            <?php endforeach;?>
        </div>
        <div id="formnewcut" class="form deliv_form">
            <div class="category-table">
                <?php foreach($categoryList as $k=>$item):?>
                    <div class="category-box">
                        <div class="category-item" data-catid="<?=$k?>">
                            <div class="category-item__label"><?=$item?></div>
                            <div class="category-item__list-provider">
                                <?php if(isset($prov_categ[$k])):
                                    foreach($prov_categ[$k] as $provider):?>
                                    <input type="text" value="<?=$provider['provider']?>" readonly>
                                <?php endforeach; endif;?>
                                <input type="text" placeholder="..." class="provider-item">
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div id="formnewcutf" class="form deliv_form">
            <div class="category-table">
                <?php foreach($categoryFurnList as $k=>$item):?>
                    <div class="category-box">
                        <div class="category-item" data-catid="<?=$k?>">
                            <div class="category-item__label"><?=$item?></div>
                            <div class="category-item__list-provider">
                                <?php if(isset($prov_categ[$k])):
                                    foreach($prov_categ[$k] as $provider):?>
                                    <input type="text" value="<?=$provider['provider']?>" readonly>
                                <?php endforeach; endif;?>
                                <input type="text" placeholder="..." class="provider-item">
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>