<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\mtReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mt Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-review-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mt Review', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'merchant_id',
            'client_id',
            'review:ntext',
            'rating',
            // 'status',
            // 'date_created',
            // 'ip_address',
            // 'order_id',
            // 'name',
            // 'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
