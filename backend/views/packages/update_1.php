<?php
$this->breadcrumbs=array(
    Yii::t('default','Packages')=>array('index'),
	Yii::t('default','Update'),
);
	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Packages')?> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>