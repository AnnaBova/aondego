<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Voucher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

    

    <?= $form->field($model, 'voucher_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voucher_type')->dropDownList(common\models\Voucher::getTypes(), [
        'prompt' => 'Select'
    ]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

        <div class="form-group field-voucher-expiration required">
            <label class="control-label">Expiration</label>
        <?= DatePicker::widget([
            'model' => $model,
            'attribute' => 'expiration',
            'template' => '{input}{addon}',
                'clientOptions' => [
                    'startDate'=> "today",
                    'autoclose' => true,
                    'defaultDate' =>  'today',
                    'minDate' => 'today',
                    'format' => 'yyyy-mm-dd'
                ]
        ]);?>
        </div>

    <?= $form->field($model, 'status')->checkBox() ?>
        
    <label for="Voucher_joining_merchant">Joining Merchant</label>

    

    <?php $model->merchant_list = json_decode($model->joining_merchant);?>
    
    
    <?php  echo $form->field($model, 'merchant_list')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Merchant::find()->all(), 'merchant_id', 'service_name'),
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
             ?>
    
    <span> leave empty if you want to apply to all merchants</span>
    
     <?php echo $form->field($model, 'used_once')->checkBox(); ?>
    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>
    </div>
    
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
