<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Merchant */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Merchant',
]) . $model->merchant_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Merchants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->merchant_id, 'url' => ['view', 'id' => $model->merchant_id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

