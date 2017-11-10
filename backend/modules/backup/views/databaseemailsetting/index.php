<?php
/* @var $this DatabaseemailsettingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Database Email Settings',
);

$this->menu=array(
	array('label'=>'Create DatabaseEmailSetting', 'url'=>array('create')),
	array('label'=>'Manage DatabaseEmailSetting', 'url'=>array('admin')),
);
?>

<h1>Database Email Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
