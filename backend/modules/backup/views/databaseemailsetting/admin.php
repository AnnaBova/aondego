<?php
/* @var $this DatabaseemailsettingController */
/* @var $model DatabaseEmailSetting */
use yii\helpers\Html;

$this->breadcrumbs=array(
	'Database Email Settings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DatabaseEmailSetting', 'url'=>array('index')),
	array('label'=>'Create DatabaseEmailSetting', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#database-email-setting-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Database Email Settings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo Html::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'database-email-setting-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'email_from',
		'email_to',
		'smtp_host',
		'smtp_port',
		'smtp_username',
		/*
		'smtp_password',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
