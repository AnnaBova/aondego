<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

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
        
        
        <?php Pjax::begin();?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            
            
            
            'summary'=>'Displaying {start}-{end} of {count} result(s). ' .
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
        
        <?php Pjax::end();?>
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
$(".grid-view").yiiGridView("applyFilter");
    
    });
});');
