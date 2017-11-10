<?php   Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget'); ?>
<?=CHtml::image($model->imageBehavior->getImageUrl(),'image',['style'=>'width:150px;']) ?>

<?php echo $form->textFieldGroup($model,'service_name',array('class'=>'span5','maxlength'=>255)); ?>



<?php echo $form->textFieldGroup($model,'url',array('class'=>'span5','maxlength'=>255)); ?>

<?php echo $form->label($model,'description') ?>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'description',
)); ?>

	<?php echo $form->textFieldGroup($model,'service_phone',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldGroup($model,'contact_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'contact_phone',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldGroup($model,'contact_email',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'country_code',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->textAreaGroup($model,'street',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldGroup($model,'city',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'state',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'post_code',array('class'=>'span5','maxlength'=>100)); ?>


	<?php echo $form->checkBoxGroup($model,'status'); ?>

