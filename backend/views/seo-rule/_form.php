<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\SeoRule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    
    <?php 
    if(Yii::$app->controller->action->id == 'update'){
     \backend\components\Translatte::getLanguage($model);
    }
    ?>
    
    

    <?php $form = ActiveForm::begin([
        'id' => 'seorule-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textarea(['rows' => 6]) ?>
        
        <?= $form->field($model, 'type')->dropDownList(['1' => 'Merchant']) ?>
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>

    <?= $form->field($model, 'meta_keyword')->textarea(['rows' => 6]) ?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
    <ul>
        <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_description}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_city}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_category}")?></li>
        <li><?php echo Yii::t('basicfield',"{merchant_subcategory}")?></li>
    </ul>

    <?= $form->field($model, 'created_at')->textInput(['readonly'=> true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['readonly'=> true]) ?>
    </div>

    <div class="box-footer">
          <?php
       
        if( Yii::$app->controller->action->id =='create'){?>
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        <?php }else { ?>
            <?php
            
                AjaxSubmitButton::begin([
                    
    'label' => Yii::t('basicfield','Update'),
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => Yii::$app->urlManager->createUrl(['seo-rule/update','id'=>$model->id, 'language'=>$_GET['language']]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#seorule-form")[0])'),
        'cache'=> 'false',
                'contentType'=> false,
                'processData'=> false,
        'success' => new \yii\web\JsExpression('function(html){
            $("#w0").yiiGridView("applyFilter");
            
        }'),
    ],
    'options' => [
        'class' => 'btn btn-primary',
        'type' => 'button',
        'id' => 'addButtonFotThis'.'update' 
    ]
]);

AjaxSubmitButton::end();
            }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
