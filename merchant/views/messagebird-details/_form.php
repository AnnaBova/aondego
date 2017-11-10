<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MessagebirdDetails */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="messagebird-details-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'enable')->checkBox(['label' => 'Enable SMS?', 'checked' => true]); ?>
    
    <h1>SMS Gateway to use when sending SMS</h1>
    
    <?= $form->field($model, 'sms_type')->radio(['label' => 'MessageBird']); ?>
                
    <?= $form->field($model, 'merchant_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>
    <img src="<?=Yii::$app->urlManager->baseUrl?>/images/MessageBird.png" alt="MessageBird Image"/>
    
    <?= $form->field($model, 'access_key')->textInput(['maxlength' => true]) ?>
    get your account for: <a href="https://www.messagebird.com/app/en/sign-up" target="_blank">MessageBird</a>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
