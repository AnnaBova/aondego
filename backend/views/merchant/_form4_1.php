<?php echo $form->checkBoxGroup($model,'is_purchase'); ?>
<?php echo $form->checkBoxGroup($model,'is_ready'); ?>

<?php echo $form->textFieldGroup($model,'date_created',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>

<?php echo $form->textFieldGroup($model,'membership_purchase_date',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>

<?php echo $form->textFieldGroup($model,'date_modified',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>

<?php echo $form->textFieldGroup($model,'date_activated',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>

<?php echo $form->textFieldGroup($model,'membership_expired',array('class'=>'span5','widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>

<?php echo $form->textFieldGroup($model,'ip_address',array('class'=>'span5','maxlength'=>50,'widgetOptions' => [
    'htmlOptions' => ['disabled' => true]
])); ?>