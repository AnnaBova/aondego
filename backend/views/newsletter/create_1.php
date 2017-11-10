<?php
$this->breadcrumbs=array(
    Yii::t('default','Newsletters')=>array('index'),
	Yii::t('default','Create'),
);
?>

<h1><?=Yii::t('default','Create')?> <?= Yii::t('default','Newsletter')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>