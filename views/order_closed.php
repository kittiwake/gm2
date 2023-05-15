<div class="content">
<div id="od">
<div class="imgs_dis">
    <?php
    if(isset($files) && count($files)!=0):
        foreach($files as $file):
            if(stripos($file,'.jpg' ) === false && stripos($file,'.jpeg' ) === false && stripos($file,'.bmp' ) === false && stripos($file,'.gif' ) === false && stripos($file,'.png' ) === false){
                continue;
            }?>
            <a href="<?=$file?>">

                <img src="<?=$file?>">
            </a>
        <?php endforeach;
    else:?>
        Фото отсутствуют
    <?php endif;?>

</div>
</div>
</div>
