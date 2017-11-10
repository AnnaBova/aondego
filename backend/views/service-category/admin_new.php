<?php

use kartik\grid\GridView;
use yii\helpers\Html;


$this->params['breadcrumbs'][] = Yii::t('basicfield','Service Categories');
/*$this->breadcrumbs = array(
    Yii::t('basicfield','Service Categories') => array('index'),
    Yii::t('basicfield','Manage'),
);*/

?>


<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?= Yii::t('basicfield','Service Categories')?></h1>
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
            
            'pager' => [
                'options'=>['class'=>'pagination'],   // set clas name used in ui list of pagination
                'prevPageLabel' => '<<',   // Set the label for the "previous" page button
                'nextPageLabel' => '>>',   // Set the label for the "next" page button
                'firstPageLabel'=>'First',   // Set the label for the "first" page button
                'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                'maxButtonCount'=>10,    // Set maximum number of page buttons that can be displayed
                ],
            
            
            
            'summary'=>'Displaying {begin}-{end} of {count} result(s). ' .
            Html::dropDownList(
                'ServiceCategorySearch[pageSize]',
                $pageSize,
                Yii::$app->params['pageSizeOptions'],
                array('class'=>'change-pageSize')) .
            ' rows per page',
            


            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                'id',
                'title',

                array(
                    'attribute' => 'is_active',
                    //'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => function($model){
                            return $model->is_active ? "Yes" : "No" ;
                    }
                ),
                'url',
                [   'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    ],
            ],
        
        ]); ?>
        
        
        <?php /*$this->widget('booster.widgets.TbGridView', array(
            'id' => 'service-category-grid',
            'dataProvider' => $dataProvider,
            'filter' => $model,
            'columns' => array(
                'id',
                'title',

                array(
                    'name' => 'is_active',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->is_active ? "Yes" : "No" ',
                ),
                'url',
               /* array(
                    'name' => 'is_approved',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->is_active ? "Yes" : "No" ',
                ),*/

                /*
                'date_created',
                'date_updated',
                'merchant_id',
                
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        ));*/ ?>
    </div>
</div>

<?php $this->registerJs('
    jQuery(function($) {
jQuery(document).on("change", ".change-pageSize", function(){
console.log("i  mahere");
$.pjax.reload({container:"#w0", data : {pageSize: $(this).val()}});
//$("#w0").yiiGridView("applyFilter");

    
    });
});');
