    <?php

use frontend\components\ImageBehavior;
use kartik\time\TimePicker;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
    
    $form = ActiveForm::begin(['id' => 'add-to-cart']); 
    

    if(empty($model->time_in_minutes)) $model->time_in_minutes = 0;
    ?>



<?=$form->field($addToCard, 'serviceid')->hiddenInput( ['value'=>$model->id])->label(false);?>

<?=$form->field($addToCard, 'staff_id')->hiddenInput( ['value'=>$model->staff_id])->label(false);?>

<?= $form->field($addToCard, 'order_date')->hiddenInput()->label(false);?>
<div class="booking">
    <div class="box_style_9">
        <h3 class="inner"><?php echo Yii::t('basicfield', 'Treatment')?></h3>
        <div class="row">

            <div class="col-sm-3">
                <?php echo Html::img(ImageBehavior::getImage($model->id, 'service'), ['class' => 'thumb_strip1 img-responsive']) ?>


            </div>

            <div class="col-sm-9">
                <h3><?php echo Yii::t('basicfield', $model->title); ?></h3>
                <div class="type">
                    <?php echo Yii::t('basicfield', $model->description); ?>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="box_style_4">
        <h3 class="inner">Dauer</h3>
        <div class="row" id="options_2">
            <div class="col-md-3">
                <label><?php echo $model->time_in_minutes ?> Min</label>
            </div>

        </div> Edn options 2 

    </div>-->

	<div class="box_style_4">
		
			<h3 class="inner">Select Date and Time</h3>
			<div class="row" id="options_2">
				<div class="col-md-6">



					<div id='calendar'></div>



					<hr>
				</div>
				<div class="col-md-6">

					<div class="time">      
						<ul>

							<li style="text-align:center">
								Free Time List</span>
							</li>
						</ul>
					</div>



					<ul class="timeslot" id="free_time_list-dis">  
						
						<?php if($update == 1){
            
							echo Html::hiddenInput('key',$key);
							echo Html::hiddenInput('update',$update);
							$dStart = strtotime($addToCard->order_date);

							$k = 0;
							\frontend\components\GroupScheduleHelper::init(strtotime("+$k day", $dStart), $addToCart->serviceid, $model);
							$dayGroupSchedule = \frontend\components\GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart), $addToCard->serviceid, $model);

							echo  $this->render('/order/group_time', ['model' =>$dayGroupSchedule, 'selected' => $updateArray['time_req'] ]);
						}?>
						

					</ul>
					
					<?=$form->field($addToCard, 'time_req')->hiddenInput()->label(false);?>
				</div>


			</div><!-- Edn options 2 -->

		

	</div>
    

    <div class="box_style_4">
        
        
        
        <div id="time-req"></div>
        
        
        
    </div>




        <div >Time/Price: 
            <span class="time-in-min">
                <?php echo $model->time_in_minutes?> 
            </span> / 
            <span class="single-price">
                <?php echo $model->price;?>
            </span>
        </div>

        <?php echo $form->field($addToCard, 'no_of_seats');?>

    <?php //if ($model->merchCatHasAddons) { ?>
        <div class="box_style_4">
            <h3 class="inner">Extras</h3>
            <div class="row" id="options_2">
                <span id="SingleOrder_addons_list"></span>
                <?php 
				
                
                echo $this->render('/order/_addons_single', ['addons' => $model->addons, 'selectedaddons'=>$updateArray['addons_list']]);
                /*foreach ($model->merchCatHasAddons as $addon) { 
                   
                    ?>
                    <div class="col-md-12">
                        <label>
                            <input type="radio" name="AddToCart[extra]" class="icheck" value="<?php echo $addon->addon->id; ?>">
                            <?php echo $addon->addon->name; ?></label>
                    </div>

                <?php } */?>


            </div><!-- Edn options 2 -->
        </div>

    <?php //} ?>


<div class="modal-footer">
    <a type="button" class="btn_3" id="close" data-toggle="collapse" href="#service-add-to-cart-<?php echo $model->id;?>" aria-expanded="false" aria-controls="collapseExample"> 
		 <?php echo Yii::t('basicfield', 'Close')?>
	</a>
    <button type="button" class="btn_2 addtocart"><?php echo Yii::t('basicfield', 'Add to Cart')?></button>
</div>
<?php ActiveForm::end(); ?>

<?php 


$this->registerJs(" 
	//$( document ).ready(function() {
	var update = ".$update.";
		
	console.log('i mahere' + update);
	
	$('body').on( 'click','.select-free-time',function(){
		var time = $(this).data('name');
		console.log(time);
		$('#addtocart-time_req').val(time);
		$('body .select-free-time').css('background', '');
		$(this).css('background', '#167a7b');
	
	})
	
	if(update == 0){
		$.ajax({
			type : 'post',
			url : '" . Yii::$app->urlManager->createUrl('order/get-group-time') . "',
			data : $('#add-to-cart').serialize(), 
			success : function(response){
				$('#free_time_list-dis').html(response); 
				//console.log(response);
			}
		});
	}
	
	
	var date = new Date();
	date.setDate(date.getDate() - 1);
	
	if(update == 1){
		var selectedDate = '".$addToCard->order_date."';
		console.log(new Date(selectedDate));
		var date = new Date(selectedDate);
		date.setDate(date.getDate());
		
	}
	
	$('#calendar').datepicker({
		minDate: 0,
		dateFormat: 'yy-mm-dd',
		defaultDate: date,
		onSelect: function (date) {
			$('#addtocart-order_date').val(date);
			$('#addtocart-time_req').val('');
			
            $.ajax({
				type : 'post',
				url : '" . Yii::$app->urlManager->createUrl('order/get-group-time') . "',
				data : $('#add-to-cart').serialize(), 
				success : function(response){
					$('#free_time_list-dis').html(response); 
					//console.log(response);
				}
			});
        }
	});
    
    $('#addtocart-order_date').on('change', function(ev){
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createUrl('order/get-group-time')."',
            data :$('#add-to-cart').serialize(),
            success : function(response){
                $('#time-req').html(response);
            }
        })
        
    });
    
    $('.addtocart').on('click', function(){
        $('body .help-block').remove();
                $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('merchant/service')."',
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
        url : '".Yii::$app->urlManager->createUrl('order/get-staff-free-time')."',
        data : {staff_id:$('#addtocart-staff_id').val(),
        date_val:$('#addtocart-order_date').val(),
        min_val:".$model->time_in_minutes."}, 
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
    $.ajax('".Yii::$app->urlManager->createUrl('order/get-free-staff')."',
    {'data':{time_val:$('#addtocart-time_req').val(),
            date_val:$('#addtocart-order_date').val(),
            min_val:".$model->time_in_minutes.",
            cat:".$model->id.",
            merchant_id:".$model->merchant_id.",
        },
    type:'post'})
    .done(function(data){
        $('#addtocart-staff_id').html(data)
    });
        })
        
    $('.single-checkbox-class').on('change',function(){
    console.log('idsfd ')
    if(this.checked) {
        console.log($('.single-price').html());
        console.log(parseFloat($(this).attr('data-price')));
        $('.single-price').html(parseFloat($('.single-price').html())+parseFloat($(this).attr('data-price')))
        $('.find-min-val').val(parseInt($('.find-min-val').val())+parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())+parseInt($(this).attr('data-time')))
    }else{
        $('.single-price').html(parseFloat($('.single-price').html())-parseFloat($(this).attr('data-price')))
        $('.find-min-val').val(parseInt($('.find-min-val').val())-parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())-parseInt($(this).attr('data-time')))
    }
});

//});

")
?>



