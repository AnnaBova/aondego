<?php 


use dosamigos\datepicker\DatePicker;
/*echo $form->dropDownListGroup($model,'package_id'
    ,array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => CHtml::listData(Packages::model()->findAll(),'package_id','title'),
            'htmlOptions' => array('prompt'=>'select package'),
        )
    ));*/
?>
    <h2><?=Yii::t('basicfield','Additional Info')?></h2>
    <p><?=Yii::t('basicfield','Package')?>: <?= $model->package ? $model->package->title : '' ?></p>
<?php //echo $form->textFieldGroup($model,'payment_steps',array('class'=>'span5')); ?>



<?= DatePicker::widget([
        'model' => $model,
        'attribute' => 'sponsored_expiration',
        'template' => '{input}{addon}',
            'clientOptions' => [
                'startDate'=> "today",
                'autoclose' => true,
                'defaultDate' =>  'today',
                'minDate' => 'today',
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>
<?php echo $form->field($model, 'sort_featured'); ?>