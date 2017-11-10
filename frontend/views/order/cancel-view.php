<h4><?php echo Yii::t('basicfield', 'Do you want to cancel appointment?')?></h4>

<?php 

$timeZone = \frontend\models\Option::getValByName('website_time_zone');

if(empty($timeZone)){
	$timeZone = date_default_timezone_get ();
	
}


date_default_timezone_set($timeZone);
$today = date('Y-m-d H:i:s');

$t1 = strtotime ( $today );
$t2 = strtotime ( $model->order_time );
$diff = $t2 - $t1;
$hours = $diff / ( 60 * 60 );



$setup = common\models\MerchantAppointmentCancelSetup::find()
	->where(['merchant_id' => $model->merchant_id])
	->andWhere(['and', "cancel_hour_to>=$hours", "cancel_hour_from<=$hours"])
	->all();
$payment = 0;
$totalPayment = 0;

$haveToPay = false;

if($setup){
	$haveToPay = true;
	foreach ($setup as $data){

		$payment = $data->cancel_percent;
		$totalPayment = ($data->cancel_percent / 100) * $model->price;

		//$totalPayment = $model->price - $totalPayment;

	}

	
}

if($haveToPay){
	echo Yii::t('basicfield', 'You have to pay {total}  to merchant i.e {payment}  % of total.', [
	    'total' => $totalPayment, 
	    'payment' => $payment
	] );
	echo  Yii::t('basicfield', 'Since you have <b> {hours}  </b> hours left for appointment.', [
	    'hours' => floor($hours), 
	    
	] );
	
}?>

<form id="cancel-appointment-form">
    
	
		<p class="text-small"><?php echo Yii::t('basicfield', 'Reason for cancellation')?></p>
		<textarea name="reason" class="form-control"></textarea>
		
		<div id="error" style="color:red;"></div>
	

	<div class="modal-footer">

		<input type="hidden" name="orderid"  value="<?php echo $model->id?>">
		<input type="hidden" name="total"  value="<?php echo $totalPayment?>">
		<button type="button" class="btn btn-default"id="cancel-appointment" ><?php echo Yii::t('basicfield', 'Ok')?></button>
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('basicfield', 'Close')?></button>


	</div>
</form>

<?php 
$this->registerJs("
	$('#cancel-appointment').on('click', function(){
		$.ajax({
			type : 'post',
			url : '".Yii::$app->urlManager->createUrl('order/cancel-appointment')."',
			data : $('#cancel-appointment-form').serialize(),
			dataType : 'json',
			success : function(response){
				if(response.success == true){
					//$('#cancelModalId').modal('hide');
					$('.modal-body').html(response.message);
					
					
				
				}else{
				
					$('#error').html(response.error);
				
				}
				
			
			}
		})
	
	})
	
	$('body').on('click','#final-ok', function(){
		$('#cancelModalId').modal('hide');
		$('#w3').yiiGridView('applyFilter');
	
	})
");?>









