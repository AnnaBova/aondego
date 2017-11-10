<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CustomPage */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Custom Page',
]) . $model->page_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Custom Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

