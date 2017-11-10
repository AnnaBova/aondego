<?php
$this->breadcrumbs=array(
    Yii::t('default','Voucher')=>array('index'),
	Yii::t('default','Update'),
);

	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Voucher')?> <?php echo $model->voucher_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>