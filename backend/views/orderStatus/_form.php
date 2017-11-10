<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box box-primary"><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'order-status-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

<?php echo $form->textFieldGroup($model,'description',array('class'=>'span5','maxlength'=>200)); ?>
<?php echo $form->textFieldGroup($model,'date_created',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>
<?php echo $form->textFieldGroup($model,'date_modified',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>
</div>
<div class="box-footer">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
    </div>
