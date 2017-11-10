<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Admin Users');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?= Yii::t('basicfield','Admin Users')?></h1>
    </div>
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
            'pjax' => true,
            'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,

                    'id'=>'w0',


                ],
            ],
            
                'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            
                'pager' => [
                    'class' => \liyunfang\pager\LinkPager::className(),
                    
                    'prevPageLabel' => '<<',   // Set the label for the "previous" page button
                    'nextPageLabel' => '>>',   // Set the label for the "next" page button
                    'firstPageLabel'=>'First',   // Set the label for the "first" page button
                    'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                    'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                    'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                    'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                    'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                    'maxButtonCount'=>10,
                    'template' => '{pageButtons}  {pageSize}',
                    //'pageSizeList' => [10, 20, 30, 50],
//                    'pageSizeMargin' => 'margin-left:5px;margin-right:5px;',
                    'pageSizeOptions' => ['class' => 'form-control box-alignment','style' => Yii::$app->params['pageSizeStyle']],
//                    'customPageWidth' => 50,
//                    'customPageBefore' => ' Jump to ',
//                    'customPageAfter' => ' Page ',
//                    'customPageMargin' => 'margin-left:5px;margin-right:5px;',
                    //'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;'],
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'admin_id',
            'username',
            'email_address:email',
            'first_name',
            'last_name',
            // 'role',
             'date_created',
            // 'date_modified',
            // 'ip_address',
            // 'user_lang',
            
            // 'lost_password_code',
            // 'session_token',
             'last_login',
            // 'user_access:ntext',
            // 'is_active',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'activation_key',

            [   'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax'=>'w0',
                            ]);
                        }
                    ]
                    ],
        ],
    ]); ?>
</div>
