<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 13-Jan-16
 * Time: 12:06
 */
?>
<div class="merchant-gallery-wrap">
    <?php if (is_array($gallery) && count($gallery)>=1):?>
        <?php foreach ($gallery as $val):?>
            <a href="<?php echo uploadURL()."/".$val?>" title=""><img src="<?php echo uploadURL()."/".$val?>"></a>
        <?php endforeach;?>
    <?php else :?>
        <p class="uk-text-danger"><?php echo t("gallery not available")?></p>
    <?php endif;?>
</div> <!--merchant-gallery-wrap-->
<div class="clear"></div>