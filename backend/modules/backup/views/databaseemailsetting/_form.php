<?php
/* @var $this DatabaseemailsettingController */
/* @var $model DatabaseEmailSetting */
/* @var $form CActiveForm */
use yii\helpers\Html;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'database-email-setting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email_from'); ?>
		<?php echo $form->textField($model,'email_from',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_to'); ?>
		<?php echo $form->textField($model,'email_to',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'smtp_host'); ?>
		<?php echo $form->textField($model,'smtp_host',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'smtp_host'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'smtp_port'); ?>
		<?php echo $form->textField($model,'smtp_port',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'smtp_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'smtp_username'); ?>
		<?php echo $form->textField($model,'smtp_username',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'smtp_username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'smtp_password'); ?>
		<?php echo $form->passwordField($model,'smtp_password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'smtp_password'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->