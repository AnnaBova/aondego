<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mt Address Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-address-book-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
		'street',
		'zipcode',
		'city',
		// 'location_name',
		// 'country_code',

		[
		    'label' => Yii::t('basicfield','Address Type'),
		    'value' => function ($model) {    
			    if($model->as_default == 1){
				return 'Billing Address';
			    }else{
				return 'Shipping Address';
			    }
		    },
		],

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn', 
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-edit"></span>', Yii::$app->urlManager->createUrl(['address-book/create', 'id' => $model->id]), [
                                                'title' => Yii::t('yii', 'Update'),
                                                'id' => 'address-update',
                                                'data-pjax'=>'w0',
                                    ]);
                                }
                            ]
                            ],
        ],
    ]); ?>
</div>
