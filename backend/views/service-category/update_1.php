<?php
$this->breadcrumbs=array(
    Yii::t('default','Service Categories')=>array('index'),
	Yii::t('default','Update'),
);

	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Service Category')?> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>