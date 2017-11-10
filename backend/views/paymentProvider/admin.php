<?php
$this->breadcrumbs=array(
    Yii::t('default','Payment Providers')=>array('index'),
	Yii::t('default','Manage'),
);
?>

<h1><?=Yii::t('default','Manage')?> <?= Yii::t('default','Payment Providers')?></h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'payment-provider-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'payment_name',
		'sequence',
    array(
        'name' => 'status',
        'type' => 'raw',
        'filter' => array('1' => 'Yes', '0' => 'No'),
        'value' => '$data->status ? "Yes" : "No" ',
    ),
		'date_created',
		/*
		'date_modified',
		'ip_address',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
    'template' =>"{update} {delete}"
),
),
)); ?>
