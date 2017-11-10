<?php echo $form->checkBoxGroup($model,'is_commission'); ?>

<?php echo $form->dropDownListGroup($model,'commission_type'
    ,array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => [1=>'General settings commission',2=>'Package commission',3=>'Fixed',4=>'Percentage'],
            'htmlOptions' => array('prompt'=>'Select type'),
        )
    )); ?>

<?php echo $form->textFieldGroup($model,'percent_commission',array('class'=>'span5')); ?>

<?php echo $form->textFieldGroup($model,'fixed_commission',array('class'=>'span5')); ?>
