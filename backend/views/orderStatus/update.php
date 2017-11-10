<?php
$this->breadcrumbs=array(
    Yii::t('default','Order Statuses')=>array('index'),

	Yii::t('default','Update'),
);


	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Order Status')?> <?php echo $model->description; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>