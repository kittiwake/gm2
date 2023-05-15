<div class="content">
    <div class="grafik plan_dis">
        <div class="oneday">
        <?php foreach($samples as $key=>$sample):
            $date = strtotime($key);?>
                    <table>
                        <?php foreach($sample as $one_sample):?>
                            <tr id="<?=$one_sample['id']?>">
                                <td style="width:6%">
                                    <div>
                                        <?=date('d.m.y',$date);?>
                                    </div>
                                </td>
                                <td style="width:6%">
                                    <div>
                                        <?=$one_sample['contract']?>
                                    </div>
                                </td>
                                <td style="width: inherit"><?=$one_sample['dis_name']?></td>
                                <td style="width:30%"><?=$one_sample['address']?></td>
                                <td style="width:30%">
                                    <div  id="notes<?=$one_sample['id']?>">
                                        <?=$one_sample['note']?>
                                    </div>
                                    <input type="button" value="Добавить" onclick="addNoteDis(this)">
                                </td>
                                <td style="width:6%">холостой <div><?=$one_sample['empty']?></div>р.</td>
                                <td style="width:6%">
                                    <input type="button" value="Восстановить" onclick="changeStanMen(this, 'tekuch')">
                                    <button onclick="delSampleManager(this);">Удалить</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
        <?php endforeach;?>
        </div>
    </div>
</div>



