<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use demogorgorn\ajax\AjaxSubmitButton;


/* @var $this yii\web\View */
/* @var $model common\models\Packages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'packages-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
<div class="box-body">
    
     <?= Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['style' => 'width:150px;']) ?>
        <?php echo $form->field($model, 'image')->fileInput(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?php  echo $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [

            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'promo_price')->textInput() ?>
    
    <?= $form->field($model, 'expiration_type')->dropDownList(\common\models\Packages::getTypes()) ?>

    <?= $form->field($model, 'expiration')->textInput() ?>

    

    <?= $form->field($model, 'unlimited_post')->dropDownList(\common\models\Packages::getLimits()) ?>

    <?= $form->field($model, 'post_limit')->textInput() ?>

    <?= $form->field($model, 'sequence')->textInput() ?>

    

    

    <?= $form->field($model, 'workers_limit')->textInput() ?>
    
    <?= $form->field($model, 'status')->checkBox() ?>
    
    <?= $form->field($model, 'sell_limit')->textInput() ?>
    
    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'is_commission')->checkBox() ?>

    <?= $form->field($model, 'commission_type')->dropDownList([1 => 'General settings commission', 2 => 'Fixed', 3 => 'Percentage'], ['prompt' => 'Select Type']) ?>

    <?= $form->field($model, 'percent_commission')->textInput() ?>

    <?= $form->field($model, 'fixed_commission')->textInput() ?>
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
        'url' => Yii::$app->urlManager->createUrl(['packages/update','id'=>$model->package_id]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#packages-form")[0])'),
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
