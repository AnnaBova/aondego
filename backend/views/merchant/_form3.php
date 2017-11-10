<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= $form->field($model, 'is_manual_seorule')->radioList(['0' => 'Seo Rule', '1'=>'Manual rule'],
    ['id'=>'ismanual'])->label(false) ;?>    
<div id="seorule">
<?php echo $form->field($model, 'seo_rule_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(common\models\SeoRule::find()->where('type=1')->all(), 'id', 'name'),
                ['prompt' => 'Select Seo Rule'])?>
</div>

<?php echo $form->field($model,'seo_title'); ?>
<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>

<?php echo $form->field($model,'seo_description'); ?>

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>

<?php echo $form->field($model,'seo_keywords'); ?>

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>


<?php 
$this->registerJs('
    var isManualSeo = $("input[name=\"Merchant[is_manual_seorule]\"]:checked").val();
    console.log(isManualSeo);
    if(isManualSeo == 1){
        $("#seorule").hide();
    }else{
        $("#seorule").show();
    }
    
    $("#ismanual").change("radio", function(){
        var isManualSeo = $("input[name=\"Merchant[is_manual_seorule]\"]:checked").val();
        console.log(isManualSeo);
        
        if(isManualSeo == 1){
            $("#seorule").hide();
            $("#merchant-seo_title").val("")
            $("#merchant-seo_description").val("")
            $("#merchant-seo_keywords").val("")
        }else{
            $("#seorule").show();
        }
    })
    
    $("#merchant-seo_rule_id").change(function(){
    
       
        $.ajax({
            type : "post",
            url : "'.Yii::$app->urlManager->createUrl('seo-rule/getdata').'",
            data : {id : $(this).val()},
            dataType : "json",
            success : function(response){
                
                if(response.success == true){
                    $("#merchant-seo_title").val(response.msg.meta_title)
                    $("#merchant-seo_description").val(response.msg.meta_description)
                    $("#merchant-seo_keywords").val(response.msg.meta_keyword)
                }else{
                    $("#merchant-seo_title").val("")
                    $("#merchant-seo_description").val("")
                    $("#merchant-seo_keywords").val("")
                }
            
            }
        })
        
        })
        ');

?>


