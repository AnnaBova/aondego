<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminUser */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Admin User',
]) . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Admin Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->admin_id, 'url' => ['view', 'id' => $model->admin_id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>



<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

