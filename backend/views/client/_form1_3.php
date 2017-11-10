<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
<div class="box-body">
    

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-voucher-expiration required">
            <label class="control-label"><?php echo Yii::t('basicfield', 'Date of Birth')?></label>
        <?= DatePicker::widget([
            'model' => $model,
            'attribute' => 'dob',
            'template' => '{input}{addon}',
                'clientOptions' => [
                    'startDate'=> "today",
                    'autoclose' => true,
                    'defaultDate' =>  'today',
                    'minDate' => 'today',
                    'format' => 'dd-mm-yyyy'
                ]
        ]);?>
        </div>

    <?= $form->field($model, 'status')->checkBox() ?>
    
    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'last_login')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'ip_address')->textInput(['readonly' => true]) ?>

</div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
