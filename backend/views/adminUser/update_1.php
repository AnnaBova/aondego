<?php
$this->breadcrumbs=array(
    Yii::t('default','Admin Users')=>array('index'),
	Yii::t('default','Update'),
);

	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Admin User')?> <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>