<?php

$this->title = 'Update Service Category';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Service Categories'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';


/*$this->breadcrumbs=array(
    Yii::t('basicfield','Service Categories')=>array('index'),
	Yii::t('basicfield','Update'),
);*/

	?>

	<h1><?=Yii::t('basicfield','Update')?> <?= Yii::t('basicfield','Service Category')?> <?php echo $model->title; ?></h1>

<?php echo $this->render('_form',array('model'=>$model)); ?>