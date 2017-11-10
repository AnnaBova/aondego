<?php

use frontend\models\CategoryHasMerchant;
use yii\helpers\Html;
?>  



<div class="main_title">
    <h2 class="nomargin_top">
        <?php echo Yii::t('basicfield', "Choose merchant from cities")?></h2>
    <p>
        <?php echo Yii::t('basicfield', 'Just click on the city your are interested in')?>
        
    </p>
</div>

<div class="row">
    <?php foreach ($model as $data){?>
    <div class="col-md-3">
	<a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search', 'Merchant[search]' => $data['city']])?>">    
		<?php echo ucfirst($data['city']);?>
	(<?php echo \frontend\models\MtMerchant::getMerchantCountByCities($data['city']);?>)
	</a>
	    
    </div>
    
    <?php }?>
    
    

    
</div><!-- End row -->  
  
