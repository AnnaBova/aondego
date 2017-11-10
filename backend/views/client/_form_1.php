<div class="box box-primary"><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="box-body">

	<?php echo $form->textFieldGroup($model,'first_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'last_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'email_address',array('class'=>'span5','maxlength'=>200)); ?>

    <?php echo $form->textFieldGroup($model,'contact_phone',array('class'=>'span5','maxlength'=>20)); ?>


	<?php echo $form->textFieldGroup($model,'street',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'city',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'state',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'zipcode',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->checkBoxGroup($model,'status'); ?>


	<?php echo $form->textFieldGroup($model,'date_created',array('class'=>'span5','widgetOptions' => [
        'htmlOptions' => ['disabled' => true]
    ])); ?>

	<?php echo $form->textFieldGroup($model,'date_modified',array('class'=>'span5','widgetOptions' => [
        'htmlOptions' => ['disabled' => true]
    ])); ?>

	<?php echo $form->textFieldGroup($model,'last_login',array('class'=>'span5','widgetOptions' => [
        'htmlOptions' => ['disabled' => true]
    ])); ?>

	<?php echo $form->textFieldGroup($model,'ip_address',array('class'=>'span5','widgetOptions' => [
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