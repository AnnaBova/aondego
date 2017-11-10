<?php
$this->breadcrumbs=array(
    Yii::t('default','Rating Meanings')=>array('index'),
	Yii::t('default','Manage'),
);

?>

<h1><?=Yii::t('default','Manage')?> <?= Yii::t('default','Rating Meanings')?></h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'rating-meaning-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'rating_start',
		'rating_end',
		'meaning',
		'date_created',
		'date_modified',
		/*
		'ip_address',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
    'template' =>"{update} {delete}"
),
),
)); ?>
