<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Currency */

$this->title = $model->currency_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('basicfield', 'Update'), ['update', 'id' => $model->currency_code], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('basicfield', 'Delete'), ['delete', 'id' => $model->currency_code], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('basicfield', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'currency_code',
            'currency_symbol',
            'date_created',
            'date_modified',
            'ip_address',
        ],
    ]) ?>

</div>
