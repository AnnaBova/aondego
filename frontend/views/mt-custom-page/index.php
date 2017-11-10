<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\mtCustomPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mt Custom Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-custom-page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mt Custom Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'slug_name',
            'page_name',
            'content:ntext',
            'seo_title',
            // 'meta_description',
            // 'meta_keywords',
            // 'icons',
            // 'assign_to',
            // 'sequence',
            // 'status',
            // 'date_created',
            // 'date_modified',
            // 'open_new_tab',
            // 'is_custom_link',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
