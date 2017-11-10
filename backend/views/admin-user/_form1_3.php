<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminUser */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
