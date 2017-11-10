<?php
$this->breadcrumbs=array(
    Yii::t('default','Payment Providers')=>array('index'),
	Yii::t('default','Create'),
);
?>

<h1><?=Yii::t('default','Create')?> <?= Yii::t('default','Payment Provider')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>