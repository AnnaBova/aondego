<?php
/* @var $this DatabaseemailsettingController */
/* @var $model DatabaseEmailSetting */

$this->breadcrumbs=array(
	'Database Email Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->beginWidget('bootstrap.widgets.TbBox',
		array(
				'title' => 'Update Email Setting For Database Backup',
				'headerIcon' => 'icon-home',
		)
);
$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true,
		'fade'=>true,
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
));
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
 <?php $this->endWidget(); ?>