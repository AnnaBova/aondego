<?php
$this->breadcrumbs=array(
    Yii::t('default','Clients')=>array('index'),
	Yii::t('default','Update'),
);
?>
    <h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Client')?> <?php echo $model->client_id; ?></h1>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>