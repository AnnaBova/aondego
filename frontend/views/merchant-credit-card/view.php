<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchantCc */

$this->title = $model->mt_id;
$this->params['breadcrumbs'][] = ['label' => 'Mt Merchant Ccs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-merchant-cc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->mt_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->mt_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mt_id',
            'merchant_id',
            'card_name',
            'credit_card_number',
            'expiration_month',
            'expiration_yr',
            'cvv',
            'billing_address',
            'date_created',
            'ip_address',
        ],
    ]) ?>

</div>
