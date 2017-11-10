<div class="box box-primary">
<?php
Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget');
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'custom-page-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
	<?php echo $form->textFieldGroup($model,'page_name',array('class'=>'span5','maxlength'=>255)); ?>

    <?php echo $form->textFieldGroup($model,'icons',array('class'=>'span5','maxlength'=>255,'placeholder'=>'eg. fa fa-info-circle')); ?>


    <?php $this->widget('ImperaviRedactorWidget', array(
        // You can either use it for model attribute
        'model' => $model,
        'attribute' => 'content',
        'options' => array(
            'replaceDivs' => false
            )
    )); ?>

    <?php echo $form->textFieldGroup($model,'sequence',array('class'=>'span5')); ?>

    <?php echo $form->checkBoxGroup($model,'open_new_tab'); ?>


    <?php echo $form->checkBoxGroup($model,'is_custom_link'); ?>

	<?php echo $form->textFieldGroup($model,'slug_name',array('class'=>'span5','maxlength'=>255)); ?>

<h2>Seo</h2>

    <?php echo $form->textFieldGroup($model,'seo_title',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'meta_description',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'meta_keywords',array('class'=>'span5','maxlength'=>255)); ?>





<br><br>
<?php
echo $form->label($model,'assign_to');
$this->widget(
    'booster.widgets.TbSelect2',
    array(
        'model' => $model,
        'attribute'=> 'assign_to',
        'form'=> $form,
        'data' => [1=>'Menu1',2=>'Menu2'],
        'htmlOptions' => array(
            'multiple' => 'multiple',
        ),
    )
);
?>



	<?php echo $form->checkBoxGroup($model,'status'); ?>

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
    <div class="box box-primary">
