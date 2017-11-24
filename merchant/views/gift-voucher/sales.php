<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Gift Voucher Sales');
$this->params['breadcrumbs'][] = $this->title;
$this->context->menu = false;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
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
            
//                'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            
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

			'id',
			
			[
				'attribute'=>'voucher_type',
				'value'=>function($model){
					 return \common\models\GiftVoucher::$type[$model->voucher->type];
		
				} 
			],
			
			'client_name',
			'client_phone',
			'price',
			'payment_status',
			
			[
				'attribute'=>'delivery_option',
				'value'=>function($model){
					 return frontend\models\Order::$deliveryOption[$model->delivery_option];
		
				} 
			],
			'voucher_note',
			'create_time',
			'commision_ontop',
			[	
				'attribute'=>'reciever',
				'value'=>function($model){
					return $model->reciever;
				},
			],
					
			[
				'label' => 'Is Delivered/Picked Up',
				'attribute' => 'is_delivered_pickup',
				'format' => 'raw',
				'value' => function ($model){
					if($model->is_delivered_pickup == 0){
						return \yii\helpers\Html::a('No', ['order/change-delivery','id'=> $model->id]);
					}else{
						return \yii\helpers\Html::a('Yes', ['order/change-delivery','id'=> $model->id]);
					}
				    //return \yii\helpers\Html::a($model->service_name, ['rpt-merchante-sales/details','merchantId'=> $model->merchant_id],['target' => '_blank']);
				}
			],
	        [
				'label' => 'Status',
				'attribute' => 'status_order',
				'format' => 'raw',
				'value' => function ($model){
					$value = '' ;
					if($model->status == 1){
						$value = 'Pending';
					}elseif($model->status == 2){
						$value ='Canceled';
					}elseif($model->status == 4 || $model->status == 0){
						$value = 'Paid';
					}

					return \yii\helpers\Html::a($value, ['#'], ['class' => 'change_order_status', 'data-id' => $model->status, 'id' => $model->id]);
				}
			],
        ],
    ]); ?>
</div>
<div class="modal fade" id="orderStatus" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
	<div class="modal-dialog" style="margin-top: 25%;">
			<div class="modal-content modal-popup">
				<div class='modal-header'>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class='modal-title'>
						<strong>Order status</strong>
					</h4>
				</div>
				<!-- / modal-header -->
				<div class='modal-body'>
					<?php
					foreach ($ordersStatus as $status) {
						?>
						<div class="radio">
							<label>
								<input type="radio" name="chengeStatus" data-id="<?php echo $status->stats_id ?>">
								<?php echo ucfirst($status->description) ?>
							</label>
						</div>
						<?php
					}
					?>
				</div>
				<div class='modal-footer'>
					<div class="checkbox pull-right">
						<label>
							<button type="button" class="btn btn-default" id="saveOrderStatus">Accept and close</button>
						</label>
					</div>
					<!--/ checkbox -->
				</div>
			</div>
	</div>
</div>
<?php
$this->registerJs('
	var changeOrderStatus = 0;
	$("#w0").on("click", ".change_order_status", function(event){
		event.preventDefault();
		var currentStatusId = $(this).attr("data-id");
		var currentOrderId = $(this).attr("id");
		currentStatusId = currentStatusId?4:currentStatusId;
		var modalChangeOrderStatus = $("#orderStatus");
		modalChangeOrderStatus.find("input").each(function(key,item){
			if ($(item).attr("data-id")*1 === currentStatusId) {
				$(item).attr("checked", "checked");
			}		
		});
		changeOrderStatus ? modalChangeOrderStatus.modal("hide") : modalChangeOrderStatus.modal("show");
		
		$("input[name=chengeStatus]").click(function(event){
			modalChangeOrderStatus.find("input").each(function(key,item){
				$(item).removeAttr("checked");	
			});
			$(this).attr("checked", true);
		});
		
		$("#saveOrderStatus").click(function(event){
				event.preventDefault();
				var newStatusOrder = "";
				modalChangeOrderStatus.find("input").each(function(key,item){
			if ($(item).attr("checked")) {
				newStatusOrder = $(item).attr("data-id");
			}
			});
			  $.ajax({
                    type : "get",
                    url : "' . Yii::$app->urlManager->createUrl('order/change-status') . '",
                    data : {model_id : currentOrderId, status_id: newStatusOrder},
                    success : function(response){
						console.log(response);
						},
                    error: function(err) {
                        console.log(err);
                    }
                });
			console.log("save");
		});
	});
	');
?>