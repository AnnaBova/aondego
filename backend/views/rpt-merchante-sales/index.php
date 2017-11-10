<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:32
 */


?>
<h1><?= Yii::t('default','Sales Report')?></h1>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title =  Yii::t('default','Report Sales');
$this->params['breadcrumbs'][] = $this->title;
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
                    'pageSizeOptions' => ['class' => 'form-control box-alignment','style' =>  Yii::$app->params['pageSizeStyle']],
//                    'customPageWidth' => 50,
//                    'customPageBefore' => ' Jump to ',
//                    'customPageAfter' => ' Page ',
//                    'customPageMargin' => 'margin-left:5px;margin-right:5px;',
                    //'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;'],
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => 'Merchant Name',
                'attribute' => 'service_name',
                'format' => 'raw',
                'value' => function ($model){
                    return \yii\helpers\Html::a($model->service_name, ['rpt-merchante-sales/details','merchantId'=> $model->merchant_id],['target' => '_blank']);
                }
            ],
            
            
            [
                'label' => 'Date registered', 
                'attribute' => 'date_created',
                'format' => 'html',
		'filterType' => GridView::FILTER_DATE,
		'filterWidgetOptions' => [
		    'pluginOptions' => [
			//'locale'=>[
                            'format'=>'d-mm-yyyy',
                        //],
			'autoclose' => true,
			'todayHighlight' => true,
		    ]
		],
//                'filter' => \yii\jui\DatePicker::widget([
//                    'model'=>$searchModel,
//                    'attribute'=>'date_created',
//                    'dateFormat' => 'yyyy-MM-dd',
//                ]),
                'value' => function($model){
                    return $model->date_created;
                
                }
            ],
                    
            [
                'label' => 'Package',
                'attribute' => 'package_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\Packages::find()->all(), 'package_id', 'title'),
                'value' => function ($model){
                    return $model->package->title;
                }
            ],
                    
            
                    
            [
                'label' =>'Total Appointments',
                'value' => function($model){
                    return common\models\Merchant::getTotalAppointments($model);
                }
            ],
                    
            [
                'label' =>'Total Commission',
                'value' => function($model){
                    return common\models\Merchant::getCommission($model);
                }
            ],
            
        ],
    ]); ?>
       
</div>
