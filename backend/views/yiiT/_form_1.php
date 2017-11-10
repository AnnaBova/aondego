<div class="box box-primary">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'yii-t-form',
	'enableAjaxValidation'=>false,
)); ?>
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="box-body">

	<?php echo $form->textFieldGroup($model,'value_en',array('widgetOptions'=>array('htmlOptions'=>array('disabled'=>'disabled')))); ?>

	<?php echo $form->textFieldGroup($model,'translate_de',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

    </div>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
