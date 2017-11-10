<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtCustomPage */

$this->title = Yii::t('custompage',$model->seo_title);

?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
    	<div id="sub_content">
    	 <h1>Ihr Erfolg ist unser Ziel</h1>
         <p>aondevous bietet Ihnen eine Vielzahl von Features für Ihren Erfolg.</p>
         <p></p>
        </div><!-- End sub_content -->
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="<?php echo Yii::$app->homeUrl;?>">
                        <?php echo Yii::t('basicfield', 'Home');?>
                    </a></li>
                <li><a href="#0"><?php echo Yii::t('basicfield', $model['page_name']);?></a></li>
                
            </ul>
        </div>
    </div><!-- Position -->

<!-- Content ================================================== -->
<!--<div class="container margin_60_35">-->
  <?php echo Yii::t('custompage',$model['content'])?>
    
<!--</div>	-->



    
