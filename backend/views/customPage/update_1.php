<?php
$this->breadcrumbs=array(
    Yii::t('default','Custom Pages')=>array('index'),
	Yii::t('default','Update'),
);

	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Custom Page')?> <?php echo $model->page_name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>