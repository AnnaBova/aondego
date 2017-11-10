<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'client_id',
            'payment_type',
            'client_name',
            // 'client_phone',
            // 'client_email:email',
            // 'order_time',
            // 'category_id',
            // 'staff_id',
            // 'merchant_id',
            // 'create_time',
            // 'is_group',
            // 'source_type',
            // 'order_id',
            // 'price',
            // 'more_info',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
