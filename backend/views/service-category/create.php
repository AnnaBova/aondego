<?php /*
$this->breadcrumbs=array(
    Yii::t('basicfield','Service Categories')=>array('index'),
	Yii::t('basicfield','Create'),
);*/
?>

<?php

$this->title = 'Createn Service Category';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Service Categories'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Create';


/*$this->breadcrumbs=array(
    Yii::t('basicfield','Service Categories')=>array('index'),
	Yii::t('basicfield','Update'),
);*/

	?>

<h1><?=Yii::t('basicfield','Create')?> <?= Yii::t('basicfield','Service Category')?></h1>

<?php echo $this->render('_form', array('model'=>$model)); ?>