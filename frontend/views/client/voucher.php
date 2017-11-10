<?php 

use kartik\grid\GridView;
use yii\helpers\Html;


?>



<?=

GridView::widget([

    'dataProvider' => $dataProviderVoucher,
//                                 'filterModel' => $searchModel,
    'export' => false,
    'pjax' => true,
    'pjaxSettings' => [
	'options' => [
	    'enablePushState' => false,
	    'id' => 'order-grid',
	],
    ],
    'columns' => [
	['class' => 'yii\grid\SerialColumn'],
	//'id',
	//'status',
	//'client_id',
	[
	    'label' => Yii::t('basicfield', 'Voucher'),
	    'value' => function ($model) {
		    return $model->voucher->name;
	    },
	],
	[
	    'label' => Yii::t('basicfield', 'Merchant'),
	    'format' => 'html',
	    'value' => function ($model) {

		    $merchantUrl = preg_replace('/\s+/', '', $model->merchant->service_name);
		    $merchantUrl = strtolower($merchantUrl) . '-' . $model->merchant->merchant_id;
		    return Html::a($model->merchant->service_name, ['merchant/view', 'id' => $merchantUrl]);
	    },
		],
	[
	    'label' => Yii::t('basicfield', 'Recepients'),
	    'value' => function ($model) {
			if($model->delivery_option == 0){
			     return $model->client_name;   
			}else{
				return $model->address->first_name.' '.$model->address->last_name;
			}

	    },
	],
		    
	[
		'label' => Yii::t('basicfield', 'Address'),
		'value' => function ($model) {
			if ($model->delivery_option == 0) {
				return 'Pick Up';
			} else {
				return $model->address->location_name;
			}
		},
	],
		'price',
	[
		'label' => Yii::t('basicfield', 'Payment Type'),
		'value' => function ($model) {
			return common\models\GiftVoucherSetting::$payment[$model->payment_type];
		}
	],
		'create_time',
	[
	    'label' => Yii::t('basicfield', 'Delivery Option'),
	    'value' => function ($model){
			return $model::$deliveryOption[$model->delivery_option];
			
	    },
	],
		    
	[
		    'label' => 'Is Delivered/Picked Up',
		    'attribute' => 'is_delivered_pickup',
		    'format' => 'raw',
		    'value' => function ($model){
			    if($model->is_delivered_pickup == 0){
				    return 'No ';
			    }else{
				    return 'Yes';
			    }
			//return \yii\helpers\Html::a($model->service_name, ['rpt-merchante-sales/details','merchantId'=> $model->merchant_id],['target' => '_blank']);
		    }
	    ],
		// 'more_info',
		
		    ],
		]);
?>