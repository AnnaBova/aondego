<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminUser */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'adminuser-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
<div class="box-body">
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'new_password_repeat')->passwordInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'is_active')->checkBox(); ?>

    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'last_login')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'ip_address')->textInput(['readonly' => true]) ?>
    
    <?php
        $model->user_permit = json_decode($model->user_access);
        echo $form->field($model, 'user_permit')->checkBoxList(backend\components\AdminHelper::allActions()); ?>
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
        'url' => Yii::$app->urlManager->createUrl(['admin-user/update','id'=>$model->id, 'language'=>$_GET['language']]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#adminuser-form")[0])'),
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
