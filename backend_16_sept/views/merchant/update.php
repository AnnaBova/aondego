<?php
$this->breadcrumbs=array(
    Yii::t('default','Merchants')=>array('index'),
	Yii::t('default','Update'),
);
?>

<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Merchant')?> <?php echo $model->service_name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>