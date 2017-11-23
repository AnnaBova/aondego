<?php

use dosamigos\datepicker\DatePicker;
use frontend\components\ImageBehavior;
use frontend\models\Staff;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'add-to-cart']);

?>



<?= $form->field($addToCard, 'serviceid')->hiddenInput(['value' => $model->id])->label(false); ?>

<?= $form->field($addToCard, 'staff_id')->hiddenInput()->label(false);?>

<?= $form->field($addToCard, 'order_date')->hiddenInput()->label(false);?>

<?php echo $form->field($model, 'memcache_key')->hiddenInput(array( 'id' => 'memcache_key'))->label(false); ?>


<?php 
$totalTime = $model->time_in_minutes + $model->additional_time;
        
echo Html::hiddenInput('find-min-val',$totalTime, ['id'=> 'find-min-val']);?>

<div class="booking">
	<div class="box_style_9">
		<h3 class="inner"><?php echo Yii::t('basicfield', 'Treatment')?></h3>
		<div class="row" id="options_2">

			<div class="col-sm-3">

				<?php echo Html::img(ImageBehavior::getImage($model->id, 'service'), ['class' => 'thumb_strip1 img-responsive']) ?>

			</div>

			<div class="col-sm-9">
				<h3 class="inner-1"><?php echo Yii::t('basicfield', $model->title); ?></h3>
				
				
				
					<div class="col-md-12">
						
						<div class="btn-group dropdown">
							<button type="button" class="btn_4  dropdown-toggle btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo Yii::t('basicfield', 'Select Staff Member')?> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								
								<?php 
								$staffs = Staff::find()
								->joinWith('staff_has_category')
								->where(['is_active' => 1,
									'merchant_id' =>  $model->merchant_id,
									'staff_has_category.category_id'=>$model->id])
								->all();
								
								foreach ($staffs as $staff) {
									
									?>

								<li>
									<a  class="staff" data-toggle="collapse" href="#collapseExample2-1" aria-expanded="false" aria-controls="collapseExample2" data-staffid="<?php echo $staff->id; ?>  data-merchCatId="<?php echo $model->id; ?>">
										<?= $staff->name; ?>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								
								<?php }?>
							</ul>
						</div>
					</div>

				
			</div>
		</div>
	</div>


	<div class="box_style_4">
		<div class="collapse" id="collapseExample2-<?php echo $model->id;?>">

			<h3 class="inner"><?php echo Yii::t('basicfield', 'Extras')?></h3>
			<div class="row" id="options_2">
				<span id="SingleOrder_addons_list">
					
					<?php

					if($update == 1 ){
                    
                    $staff = Staff::findOne(['id'=> $updateArray['staff_id']]);

                    echo $this->render('/order/_addons_single', ['addons' => $staff->addons,
                        'selectedaddons' => $updateArray['addons_list']]); 
					
					}
					?>
				</span>


			</div><!-- Edn options 2 -->

			<h3 class="inner"><?php echo Yii::t('basicfield', 'Select Date and Time')?></h3>
			<div class="row" id="options_2">
				<div class="col-md-6">



					<div id='calendar'></div>




				</div>
				<div class="col-md-6">

					<div class="time">      
						<ul>

							<li style="text-align:center">
								<?php echo Yii::t('basicfield', 'Free Time List')?></span>
							</li>
						</ul>
					</div>
					
					<?php 
					if($update == 1){
						echo Html::hiddenInput('key',$key);
						echo Html::hiddenInput('update',$update, ['id'=>'update']);
					}
					?>



					<ul class="timeslot" id="free_time_list-dis">  
						
						<?php 
						$freeTimeListItem = [];
						if($update == 1){


							foreach ($staff->getFreeTime($addToCard->order_date, $model->time_in_minutes, 0, $model) as $name) {
								
								$style = "";
								
								if($addToCard->free_time_list == $name){
									$style = 'background:#167a7b;';
								}
								
								$name = '<a style="'.$style.'" class="btn_4 select-free-time" href="javascript:void(0)" data-name="'.$name.'">'.$name.'</a>';
								echo Html::tag('li',($name));
							}



						}?>
						

					</ul>
					
					<?= $form->field($addToCard, 'free_time_list')->hiddenInput()->label(false)?>
				</div>
<div class="modal-footer">

	<a type="button" class="btn_3" data-toggle="collapse" id="close" href="#service-add-to-cart-<?php echo $model->id; ?>" aria-expanded="false" aria-controls="collapseExample"> Close</a>
<!--    <button type="button" class="btn_3" data-dismiss="modal"><?php echo Yii::t('basicfield', 'Close') ?></button>-->
    <button type="button" class="btn_2 addtocart" style="display:none"><?php echo Yii::t('basicfield', 'Add to Cart') ?></button>
</div>
<hr>

			</div><!-- Edn options 2 -->

		</div>

	</div>

</div>


<?php ActiveForm::end(); ?>

<?php
$mcat = array_column($model->getAddons()->all(),'id');
$this->registerJs("
	
	$('.dropdown-menu li a').click(function(){
		
		$(this).parents('.dropdown').find('.btn').html($(this).text() + ' <span class=\'caret\'></span>');
		$(this).parents('.dropdown').find('.btn').val($(this).data('value'));
		
	});

	var update = ".$update.";
	var mcat = ".json_encode($mcat).";
	var date = new Date();
	date.setDate(date.getDate() - 1);
	
	
	
	if(update == 1){
		var staffid = '$addToCard->staff_id';
		var selectedDate = '".$addToCard->order_date."';
		console.log(new Date(selectedDate));
		var date = new Date(selectedDate);
		date.setDate(date.getDate());
		
		console.log('staff'+staffid);
		
		var staffname = $('.dropdown').find('[data-staffid=' + staffid + ']').text();
		console.log(staffname);
		
		$('.dropdown').find('.btn').html(staffname+ ' <span class=\'caret\'></span>');
	}

	$('body').on( 'click','.select-free-time',function(){
		var time = $(this).data('name');
		console.log(time);
		$('#addtocart-free_time_list').val(time);
		$('body .select-free-time').css('background', '');
		$(this).css('background', '#167a7b');
	
	})
	
	
	$.datepicker.setDefaults($.datepicker.regional['".Yii::$app->language."']);
	
	$('#calendar').datepicker({
		minDate: 1,
		dateFormat: 'yy-mm-dd',
		defaultDate: date,
		onSelect: function (date) {
			$('#addtocart-order_date').val(date);
			
            $.ajax({
				type : 'post',
				url : '" . Yii::$app->urlManager->createUrl('order/get-staff-free-time') . "',
				data : {staff_id:$('#addtocart-staff_id').val(),
				date_val:date,
				min_val:$('#find-min-val').val(), 
				cat:" . $model->id . ",
				}, 
				dataType : 'json',
				success : function(response){
					$('#free_time_list-dis').html(response.dd); 
					//console.log(response);
				}
			});
        }
	});
	
	$('.staff').on('click', function(){
		var staffid = $(this).data('staffid');
	
		$('#addtocart-staff_id').val(staffid);
	
		$.ajax({
			type : 'post',
			url : '" . Yii::$app->urlManager->createUrl('order/get-staff-free-time') . "',
			data : {staff_id:staffid,
			min_val:$('#find-min-val').val(), 
			cat:" . $model->id . ",
			mcat: mcat,
			}, 
			dataType : 'json',
			success : function(response){
			
				$('#collapseExample2-" . $model->id . "').attr('class' , 'collapse in');
				$('#SingleOrder_addons_list').html(response.add_ons); 
				$('#free_time_list-dis').html(response.dd); 
				
				}
		});
	

	})
	
	$('#close').on('click', function(){
		var href = $(this).attr('href');
		console.log(href);
		$(href).empty();
	})
	
    
    $('#addtocart-order_date').on('change', function(ev){
        $('#addtocart-staff_id').html('<option value=\"\">select</option>'); 
        $('#addtocart-free_time_list').html('<option value=\"\">select</option>'); 
        $('#SingleOrder_addons_list').html('');
    
    });
    
    $('.addtocart').on('click', function(){
		
		
		
        $('body .help-block').remove();
                $.ajax({
                    type : 'post',
                    url : '" . Yii::$app->urlManager->createUrl('merchant/service') . "',
                    data : $('#add-to-cart').serialize(),
                    dataType : 'json',
                    success : function(response){
                        if(response.success == true){
							$('#service-add-to-cart-' + response.serviceid).empty();
                            $('#extras').modal('hide');
                            $('#orders').html(response.data);
							$('html,body').animate({scrollTop: $('#orders').offset().top},'slow');
                            $('#subtotal').html(response.subtotal);
                            $('#total').html(response.total);
                            $('#couponper').html(response.couponPer);
                            $('#discount').html(response.discount);
                            $('#appointment-coupone').val('');
                            $('#appointment-apply_coupon').iCheck('uncheck');
                        
                        }else{
                            $.each(response.data, function(key, val) {
                                console.log(key);
                                $('#addtocart-'+key).after('<div class=\"help-block\">'+val+'</div>');
                                $('#addtocart-'+key).closest('.form-group').addClass('has-error');
                            });
                        }
                        
                        
                    
                    }
                })
            })
    
    $('#find-free-time').on('click', function(){
    
    $.ajax({
        type : 'post',
        url : '" . Yii::$app->urlManager->createUrl('order/get-staff-free-time') . "',
        data : {staff_id:$('#addtocart-staff_id').val(),
        date_val:$('#addtocart-order_date').val(),
        min_val:$('#find-min-val').val(), 
        cat:" . $model->id . ",
        }, 
        dataType : 'json',
        success : function(response){
            $('#addtocart-free_time_list').html(response.dd); 
            
        console.log(response);
            }
    });
    
    })
    
    $('#find-staff').on('click', function(event){
		console.log('i mahere');
		event.preventDefault()
		$.ajax('" . Yii::$app->urlManager->createUrl('order/get-free-staff') . "',
		{'data':{time_val:$('#addtocart-time_req').val(),
				date_val:$('#addtocart-order_date').val(),
				min_val:$('#find-min-val').val(),
				cat:" . $model->id . ",
				merchant_id:" . $model->merchant_id . ",
			},
		type:'post'})
		.done(function(data){
			$('#addtocart-staff_id').html(data);
			$('#addtocart-free_time_list').html('<option value=\"\">select</option>'); 
			$('#SingleOrder_addons_list').html('');
		});
    });
        
    



")
?>



