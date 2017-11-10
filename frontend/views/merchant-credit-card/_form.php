<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchantCc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mt-merchant-cc-form">

    <?php $form = ActiveForm::begin([
        'id'=>'frm-creditcard',
        'fieldConfig' => [
        'template' => "{input}{error}",
        'options' => [
            'tag'=>false
        ]
    ]
    ]); ?>

   

    <?= $form->field($model, 'card_name')->textInput(['maxlength' => true, 'class'=>'grey-fields full-width', 'placeholder'=>'Card Name']) ?>

    <?= $form->field($model, 'credit_card_number')->textInput(['maxlength' => true, 'class'=>'grey-fields full-width', 'placeholder'=>'Credit Card Number']) ?>

    <?= $form->field($model, 'expiration_month')->dropDownList(\frontend\models\MtMerchantCc::getMonth(), ['class'=>'grey-fields full-width']) ?>

    <?= $form->field($model, 'expiration_yr')->dropDownList(frontend\models\MtMerchantCc::getYear(), ['class'=>'grey-fields full-width']) ?>

    <?= $form->field($model, 'cvv')->textInput(['maxlength' => true, 'class'=>'grey-fields full-width', 'placeholder'=>'CVV']) ?>

    <?= $form->field($model, 'billing_address')->textInput(['maxlength' => true, 'class'=>'grey-fields full-width', 'placeholder'=>'Billing Address']) ?>

  

    <div class="form-group">
        <?= Html::submitButton('Add Credit Card', ['class' => 'green-button medium inline block save-credit-card',
            'data-formid' => 'frm-creditcard',
            'data-url' => Yii::$app->urlManager->createUrl('merchant/payment')
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
