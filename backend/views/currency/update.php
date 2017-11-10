<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Currency */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Currency',
]) . $model->currency_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->currency_code, 'url' => ['view', 'id' => $model->currency_code]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="currency-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
