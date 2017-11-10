<?php
/* @var $this DatabaseemailsettingController */
/* @var $model DatabaseEmailSetting */

$this->breadcrumbs=array(
	'Database Email Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DatabaseEmailSetting', 'url'=>array('index')),
	array('label'=>'Create DatabaseEmailSetting', 'url'=>array('create')),
	array('label'=>'Update DatabaseEmailSetting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DatabaseEmailSetting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DatabaseEmailSetting', 'url'=>array('admin')),
);
?>

<h1>View DatabaseEmailSetting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email_from',
		'email_to',
		'smtp_host',
		'smtp_port',
		'smtp_username',
		'smtp_password',
		'updated_at',
	),
)); ?>
