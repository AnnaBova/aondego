<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', $model->service_name .' Appointments');
$this->params['breadcrumbs'][] = ['label' => 'Sales Report', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->menu = false;
?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?= Yii::t('basicfield',$this->title)?></h1>
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
            
            [
                'label' => 'Client Name',
                //'attribute' => 'category_id',
                'value' => function($model){
                    return $model->client_name;
                }
            ],
            [
                'label' => 'Service',
                //'attribute' => 'category_id',
                'value' => function($model){
                    return $model->category->title;
                }
            ],
                    
            [
                'label' => 'Extra',
                'format' => 'raw',
                'value' => function($model){
                    $addons = '';
                    foreach ($model->addons as $key=>$value){
                        $addons .= $value['name'];
                        $addons .= '</br>';
                    }
                    
                    return $addons;
                }
            ],
            // 'client_phone',
            // 'client_email:email',
            //'order_time',
            //'create_time',
            [
                'label' => 'Date / Time',
                //'attribute' => 'create_time',
                'value' => function($model){
                
                    return $model->order_time;
                }
            ],
            [
                'label' => 'Total Price',
                //'attribute' => 'price',
                'value' => function($model){
                
                    return $model->price;
                }
            ],
            [
                'label' => 'From - To',
		'attribute' => 'fromTo',
		'filterType' => GridView::FILTER_DATE_RANGE,
		    
		'filterWidgetOptions' => [
		    'pluginOptions' => [
			'locale'=>[
                            'format'=>'DD-MM-Y'
                        ],
			'autoclose' => true,
			'todayHighlight' => true,
		    ]
		],
                /*'filter' => kartik\daterange\DateRangePicker::widget([
                    
                    'model'=>$searchModel,
                    'attribute'=>'fromTo',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>false,
                        'timePickerIncrement'=>30,
                        'locale'=>[
                            'format'=>'Y-m-d'
                        ]
                    ]
                ]),*/
                'value' => function($model){
                    return date('d-m-Y H:i:s', strtotime($model->create_time));
                
                }
                
            ],
            [
                'label' => 'Used Loyalty Points',
                //'attribute' => 'price',
                'value' => function($model){
                
                    return $model->loyalty_points;
                }
            ],
            
            [
                'label' => 'Total Commission',
                //'attribute' => 'price',
                'value' => function($model){
                
                    return $model->total_commission;
                }
            ],
            [
                'label' => 'Commission',
                'attribute' => 'commission',
                'filter' => ['1'=> 'No', '2' => 'Yes'],
                'value' => function($model){
                    if(!empty($model->total_commission)){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                    
                }
            ]

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
