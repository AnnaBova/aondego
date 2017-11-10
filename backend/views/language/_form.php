<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'language-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

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
        'url' => Yii::$app->urlManager->createUrl(['language/update','id'=>$model->id]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#language-form")[0])'),
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
