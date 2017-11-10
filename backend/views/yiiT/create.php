<?php
$this->breadcrumbs=array(
    Yii::t('default','Manage Language')=>array('index'),
	Yii::t('default','Create'),
);
?>

<h1><?=Yii::t('default','Create')?> <?= Yii::t('default','Translation')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>