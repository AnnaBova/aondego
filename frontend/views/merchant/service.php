<?php

use dosamigos\datepicker\DatePicker;
use frontend\components\ImageBehavior;
use frontend\models\Staff;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'add-to-cart']);
$count_staffs = count(json_decode($staffs));

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



<!--					<div class="col-md-12">-->
<!--						--><?php
						echo $model->description;
						?>
<!--						<div class="btn-group dropdown">-->
<!--							<button type="button" class="btn_4  dropdown-toggle btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--							</button>-->
<!--							<ul class="dropdown-menu">-->
<!--								-->
<!--								--><?php //
//								$staffs = Staff::find()
//								->joinWith('staff_has_category')
////								->where(['is_active' => 1,
////									'merchant_id' =>  $model->merchant_id,
////									'staff_has_category.category_id'=>$model->id])
//								->all();
//
//								foreach ($staffs as $staff) {
//									?>
<!---->
<!--								<li>-->
<!--									<a  class="staff" data-toggle="collapse" href="#collapseExample2-1" aria-expanded="false" aria-controls="collapseExample2" data-staffid="--><?php //echo $staff->id; ?><!--  data-merchCatId="--><?php //echo $model->id; ?><!--">-->
<!--									<div class="col-md-3">-->
<!--									</div>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li role="separator" class="divider"></li>-->
<!--								-->
<!--								--><?php //}?>
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->

			</div>
		</div>
	</div>

	<div class="box_style_4">


		<div class="collapse" id="collapseExample2-<?php echo $model->id;?>">

			<h3 class="inner"><?php
				if ($count_staffs > 1) {
					echo Yii::t('basicfield', 'Select a specialist');
				}else{
					echo Yii::t('basicfield', 'Specialist');
				}

				?></h3>
			<div class="row" id="options_2">

				<div class="staffCarousel col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
					<div class="imgSlideStaffLeft col-md-4 col-sm-4 col-xs-4">
						<div class="imgInnerSlideStaffLeft">

						</div>
						<div class="otherStaff col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-4">
						</div>
					</div>

					<div class="currentStaffBlock col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
						<?php
						if ($count_staffs > 1) {
							?>
							<div class="arrow arrowLeft glyphicon glyphicon-chevron-left"></div>
							<?php
						}
						?>
						<div class="currentStaff">
							<div class="imgSlideCurrentStaff">
								<div class="imgInnerSlideCurrentStaff">
									<div class="imgCurrentStaff"></div>
								</div>
							</div>
							<p class="staffName"></p>
							<p class="staffRole"></p>
						</div>
						<?php
						if ($count_staffs > 1) {
							?>
							<div class="arrow arrowRight glyphicon glyphicon-chevron-right"></div>
							<?php
						}
						?>
					</div>
					<div class="imgSlideStaffRight col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
						<div class="imgInnerSlideStaffRight">

						</div>
						<div class="otherStaff otherStaff0 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6">
						</div>
					</div>

				</div>


			</div><!-- Edn options 1 -->

			<h3 class="inner"><?php echo Yii::t('basicfield', 'Extras')?></h3>
			<div class="row" id="options_2">
				<div class="carouselAddons col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
					<?php
					if ($count_staffs > 3) {
						?>
						<div class="arrow arrowLeftAddons glyphicon glyphicon-chevron-left"></div>
						<?php
					}
					?>
					<div  class="innerCarouselAddons">
						<div class="carouselAddon0 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4" style="display: none">
							<div class="col-md-12 parentImageCarouselAddon">
								<div class="imageCarouselAddon">
								</div>
							</div>
							<div class="col-md-12 infoCarouselAddon">
								<p class="addon_carousel_name"></p>
							</div>
							<div class="col-md-12 buttonCarouselAddon">
								<div class="[ form-group ]">
									<input type="checkbox" name="fancy-checkbox-info" id="fancy-checkbox-info" autocomplete="off" />
									<div class="[ form-group ]">
										<input type="checkbox" name="fancy-checkbox-success-custom-icons" id="fancy-checkbox-success-custom-icons" autocomplete="off" />
										<div class="[ btn-group ]">
											<label for="fancy-checkbox-success-custom-icons" class="[ btn btn-success ]">
												<span class="[ glyphicon glyphicon-plus ]"></span>
												<span class="[ glyphicon glyphicon-minus ]"></span>
											</label>
											<label for="fancy-checkbox-success-custom-icons" class="[ btn btn-default active ]">
												Select
											</label>
										</div>
									</div>
								</div>
						</div>

					</div>
				</div>
					<?php
					if ($count_staffs > 3) {
						?>
						<div class="arrow arrowRightAddons glyphicon glyphicon-chevron-right"></div>
						<?php
					}
//EB88B9
					?>
				</div>
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
<style>
	.carouselAddons{
		height: 200px;
	}
	.innerCarouselAddons{
		height: 200px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.carouselAddon{
		height: 200px;
		width: 150px;
		display: flex;
		align-items: center;
		margin-right: 5px;
		margin-left: 5px;
	}
	.carouselAddon .imageCarouselAddon{
		background-size: cover;
		height: 70px;
		width: 70px;
		margin-left: calc((100% - 25px) / 2);
		border: 3px solid #eb88b9;
		border-radius: 50%;
	}
	.carouselAddon p{
		text-align: center;
		max-height: 84px;
		width: 130px;
		overflow-y: scroll;
	}
	.carouselAddon button{
		align-self: flex-end;
	}
	.arrowLeftAddons{
		top: 40%;
	}
	.arrowRightAddons{
		top: 40%;
		right: 0;
	}
	.form-group {
		width: 130px;
	}
	.form-group input[type="checkbox"] {
		display: none;
	}

	.form-group input[type="checkbox"] + .btn-group > label span {
		width: 20px;
	}

	.form-group input[type="checkbox"] + .btn-group > label span:first-child {
		display: none;
	}
	.form-group input[type="checkbox"] + .btn-group > label span:last-child {
		display: inline-block;
	}

	.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
		display: inline-block;
	}
	.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
		display: none;
	}
	.buttonCarouselAddon{
		align-self: flex-end;
		position: relative;
		right: 96px;
		top: 23px;
	}
	.buttonCarouselAddon label:nth-child(1){
		width: 30%;
	}
	.buttonCarouselAddon label:nth-child(2){
		width: 70%;

	}
	.parentImageCarouselAddon{
		align-self: flex-start;
	}
	.infoCarouselAddon{
		width: 100%;
		max-height: 84px;
		overflow-wrap: break-word;
		margin-left: -113px;
		margin-top: 39px;
	}
</style>
<?php
$mcat = array_column($model->getAddons()->all(),'id');
$this->registerJs("

	//-------------------------------------------------------- staff carousel ------------------------------------------
	
	var staffs = $staffs
	console.log(staffs);
	var carousel = $('.staffCarousel');
	var otherStaff = $('.otherStaff');
	var createdStaffs = [];
	var createdAddons = [];
 	var innerCarouselAddons = $('.innerCarouselAddons');
 	var currentStaffBlock = $('.currentStaffBlock');
 	var currentStaff = $('.currentStaff');
 	var imgCurrentStaff = $('.imgCurrentStaff');
 	var imgInnerSlideCurrentStaff = $('.imgInnerSlideCurrentStaff');
 	var imgInnerSlideStaffLeft = $('.imgInnerSlideStaffLeft');
 	var imgInnerSlideStaffRight = $('.imgInnerSlideStaffRight');
 	var imgInnerSlideCurrentStaffWidth = $('.imgInnerSlideCurrentStaff').width();
	var time_animate = 400;
 	var middleItem = 0;
 	
	if (staffs.length > 0) {
		createStaffCarousel(staffs);
	}
	
	function createStaffCarousel(staffs) {
			 middleItem = Math.floor(staffs.length/2);
			if ( !isNaN(middleItem) && middleItem !== 'undefined' ) {
				staffs.forEach(function(item, key){
					var newStaff = $('.otherStaff0').clone();
					newStaff.css({'background-image': 'url('+item.img+')'});
					createdStaffs.push(newStaff);
				});
			
				var name = staffs[middleItem].name;
				if (typeof name !== 'undefined') {
					currentStaff.find('.staffName').text(name);
				}
				console.log(staffs[middleItem].img);
				imgCurrentStaff.css({'background-image': 'url('+staffs[middleItem].img+')'});
				if (typeof createdStaffs[middleItem - 2] !== 'undefined') {
					imgInnerSlideStaffLeft.append(createdStaffs[middleItem - 2].css({display: 'block'})[0]);
				}
				if (typeof createdStaffs[middleItem - 1] !== 'undefined') {
					imgInnerSlideStaffLeft.append(createdStaffs[middleItem - 1].css({display: 'block'})[0]);
				}
				if (typeof createdStaffs[middleItem + 1] !== 'undefined') {
					imgInnerSlideStaffRight.append(createdStaffs[middleItem + 1].css({display: 'block'})[0]);
				}
				if (typeof createdStaffs[middleItem + 2] !== 'undefined') {
					imgInnerSlideStaffRight.append(createdStaffs[middleItem + 2].css({display: 'block'})[0]);
				}
				
				getStaffFreeTime(staffs[middleItem].id);
				
				create_addon_carousel(staffs[middleItem]['addons']);
				
			}
	}
	
	function move_staff_carousel(button, left = false, right = false) {
		var newCurrentStaffImg = clone_current_staff(imgCurrentStaff);
		var unique_class_current_staff = add_unique_class(newCurrentStaffImg);
		var new_width = change_the_block_width('imgInnerSlideCurrentStaff', 140);
		var left_block_width = change_the_block_width('imgInnerSlideStaffLeft', 180);
		var right_block_width = change_the_block_width('imgInnerSlideStaffRight', 180);
		var name = staffs[middleItem].name;
		var description = staffs[middleItem].description;
		if (typeof name !== 'undefined') {
				currentStaff.find('.staffName').text(name);
		}
//		if (typeof description !== 'undefined') {
//			currentStaff.find('.staffRole').text(description);
//		}
		getStaffFreeTime(staffs[middleItem].id);
		create_addon_carousel(staffs[middleItem]['addons']);
		if (left) {
			if (typeof createdStaffs[middleItem - 2] !== 'undefined') {
 				var new_left_staff =  createdStaffs[middleItem - 2].clone().css({display: 'block', opacity: 1});
				prepend_staff('imgInnerSlideStaffLeft', new_left_staff[0], 90);
			}
			var new_right_staff =  createdStaffs[middleItem + 1].clone().css({display: 'block', opacity: 0});
			prepend_staff('imgInnerSlideStaffRight', new_right_staff[0], 90);
			
			prepend_staff('imgInnerSlideCurrentStaff', newCurrentStaffImg[0], 140);
			$('.imgInnerSlideCurrentStaff').animate({
			left: '+=140',
			},time_animate);
			$('.imgInnerSlideStaffLeft').animate({
			left: '+=90',
			},time_animate);
			$('.imgInnerSlideStaffRight').animate({
			left: '+=90',
			},time_animate);
			if($('.imgInnerSlideStaffRight').children().length > 2) {
				$('.imgInnerSlideStaffRight').children().last().animate({
				opacity: '0',
				},time_animate);
			}
			new_right_staff.animate({
			opacity: '1',
			},time_animate);
	
			clear_after_move(button, unique_class_current_staff, time_animate, false, true);
		}
		if (right) {
			if (typeof createdStaffs[middleItem + 2] !== 'undefined') {
				var new_right_staff =  createdStaffs[middleItem + 2].clone().css({display: 'block'});
				append_staff('imgInnerSlideStaffRight', new_right_staff[0], false, 90);
			} 
			if (typeof createdStaffs[middleItem - 1] !== 'undefined') {
				var new_left_staff =  createdStaffs[middleItem - 1].clone().css({display: 'block', opacity: 1});
				append_staff('imgInnerSlideStaffLeft', new_left_staff[0], false, 90);
			} 
			
			append_staff('imgInnerSlideCurrentStaff', newCurrentStaffImg[0]);
			$('.imgInnerSlideCurrentStaff').animate({
			left: '-=140',
			},time_animate);
			$('.imgInnerSlideStaffLeft').animate({
			left: '-=90',
			},time_animate);
			$('.imgInnerSlideStaffRight').animate({
			left: '-=90',
			},time_animate);
			$('.imgInnerSlideStaffRight').children().last().animate({
			opacity: '1',
			},time_animate);
			if ($('.imgInnerSlideStaffLeft').children().length > 2) {
				$('.imgInnerSlideStaffLeft').children().first().animate({
				opacity: '0',
				},time_animate);
			}
			if(typeof new_right_staff !== 'undefined') {
				new_right_staff.animate({
					opacity: '1',
				},time_animate);
			}
		
			console.log(middleItem);
			clear_after_move(button, unique_class_current_staff, time_animate, true);
		}
		
	}
	
	function clone_current_staff(target) {
		var newCurrentStaffImg = target.clone()
		newCurrentStaffImg.css({'background-image': 'url('+staffs[middleItem].img+')'});
		return newCurrentStaffImg;
	}
	
	function add_unique_class(target) {
		var unique_class = Math.random().toString(36).substr(2, 5);
		target.addClass(unique_class);
		return unique_class;
	}
	
	function change_the_block_width(block_class, value) {
		var block = $('.'+block_class);
		var current_block_width = block.width();
		if (value > 0) {
			var new_width = parseInt(current_block_width) + parseInt(value) +'px'
		} else {
			var new_width = parseInt(current_block_width) - Math.abs(parseInt(value)) +'px'
		}
		block.css({width: new_width});
		
		return new_width;
	}
	
	function prepend_staff(parent_class, child, left = 0, right = 0) {
		var parent = $('.'+parent_class);
		parent.prepend(child);
		if (left != 0) {
			parent.css({left: '-'+parseInt(left)+'px'});
		}
		if (right != 0) {
			parent.css({left: '+'+parseInt(left)+'px'});
		}
	}
		
	function append_staff(parent_class, child, left = 0, right = 0) {
		var parent = $('.'+parent_class);
		parent.append(child);
			if (left != 0) {
			parent.css({left: '-'+parseInt(left)+'px'});
		}
	}
	
	function clear_after_move(button, unique_class_current_staff, time_animate, clear_right = false, clean_left = false) {
		button.css({'pointerEvents': 'none'});
		setTimeout(function(){
			change_the_block_width('imgInnerSlideCurrentStaff', -140);
			change_the_block_width('imgInnerSlideStaffLeft', -180);
			change_the_block_width('imgInnerSlideStaffRight', -180);
			if (clear_right) {
				$('.imgInnerSlideCurrentStaff').css({left:0});
				$('.imgInnerSlideStaffRight').css({left:0});
				$('.imgInnerSlideStaffLeft').css({left:0});
				if($('.imgInnerSlideStaffLeft').children().length === 1) {
					$('.imgInnerSlideStaffLeft').css({left:90});				
				}
				$('.imgInnerSlideStaffRight').children().first().remove();
				
				console.log($('.imgInnerSlideStaffLeft').children().length);
				if($('.imgInnerSlideStaffLeft').children().length > 2) {
									$('.imgInnerSlideStaffLeft').children().first().remove();
				}				
			}
			
			if (clean_left) {
				if($('.imgInnerSlideStaffRight').children().length > 2) {
					$('.imgInnerSlideStaffRight').children().last().remove();
				}
								$('.imgInnerSlideStaffLeft').children().last().remove();

				
			}
			
	
			$('.imgInnerSlideCurrentStaff').find('*:not(\".'+unique_class_current_staff+'\")').remove();
			button.css({'pointerEvents': 'auto'});
		}, parseInt(time_animate) + 20);
	}
	//--------------------------- arrow to the left -----------------------------------------------
	
	$('.arrowLeft').on('click', function(event){
		if ( middleItem > 0 ) {
			middleItem = middleItem - 1;
			if(middleItem === 0) {
				$(this).hide();
			}
			$('.arrowRight').show()
		}else{	
			$(this).hide();
		} 
		move_staff_carousel($(this),true);
	});
	
	//-------------------------- arrow to the Right -----------------------------------------------
	
	$('.arrowRight').on('click', function(event){
		if ( middleItem < staffs.length ) {
			middleItem = middleItem + 1;
			if(middleItem + 1 === staffs.length) {
				$(this).hide();
			}
			$('.arrowLeft').show()
		}else{	
			$(this).hide();
		} 
		move_staff_carousel($(this),false,true);
	});	
	
	//-------------------------------------------------------- end staff carousel --------------------------------------
	
	//-------------------------------------------------------- addon carousel ------------------------------------------
	
	function create_addon_carousel(addons) {
		innerCarouselAddons.find('.carouselAddon').remove()
		var	middleItem = Math.floor(addons.length/2);
		if ( !isNaN(middleItem) && middleItem !== 'undefined' ) {
				addons.forEach(function(item, key){
					var newAddon = $('.carouselAddon0').clone();
					newAddon.addClass('carouselAddon').addClass(\"key\"+key);
					newAddon.find('.imageCarouselAddon').css({'background-image': 'url('+item.img+')'});
															console.log(newAddon);

					createdAddons.push(newAddon);
				});
				
			if (typeof createdAddons[middleItem - 1] !== 'undefined'  && typeof addons[middleItem - 1] !== 'undefined') {
				var name = addons[middleItem].addon_name;
				if (typeof name !== 'undefined') {
					createdAddons[middleItem - 1].find('.addon_carousel_name').text(name);
				}
				createdAddons[middleItem - 1].css({display: 'flex'});
				innerCarouselAddons.append(createdAddons[middleItem - 1][0]);
			}
			
			if (typeof createdAddons[middleItem] !== 'undefined'  && typeof addons[middleItem] !== 'undefined') {
				var name = addons[middleItem].addon_name;
				if (typeof name !== 'undefined') {
					createdAddons[middleItem].find('.addon_carousel_name').text(name);
				}
				createdAddons[middleItem].css({display: 'flex'});
				innerCarouselAddons.append(createdAddons[middleItem][0]);
			}
			
			if (typeof createdAddons[middleItem + 1] !== 'undefined' && typeof addons[middleItem + 1] !== 'undefined') {
				var name = addons[middleItem + 1].addon_name;
				if (typeof name !== 'undefined') {
					createdAddons[middleItem + 1].find('.addon_carousel_name').text(name);
				}
				createdAddons[middleItem + 1].css({display: 'flex'});
				innerCarouselAddons.append(createdAddons[middleItem + 1][0]);
			}
			
		}
	}
	
	//-------------------------------------------------------- end addon carousel ------------------------------------------


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
	
	function getStaffFreeTime(staff_id) {
		var staffid = staff_id;
	
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
	}
	
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



