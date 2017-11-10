<?php

use yii\helpers\Html;

$this->title = Yii::t('seorule', \frontend\models\MtMerchant::getSeo($model, $model->seo_title));

$imageUrl = $model->behaviors['imageBehavior']->getImageUrl();

$merchantUrl = preg_replace('/\s+/', '', $model->service_name);
$merchantUrl = strtolower($merchantUrl) . '-' . $model->merchant_id;

$currencyCode = common\components\Helper::getCurrencyCode($model);
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" data-parallax="scroll" 
         data-image-src="<?php echo $model->behaviors['imageBehavior2']->getImageUrl(); ?>" 
         data-natural-width="1600" data-natural-height="850"

         >
    <div id="subheader" itemscope itemtype="http://schema.org/LocalBusiness">
        <div id="sub_content">
            <div id="thumb">

		<?php echo Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['itemprop' => 'image']) ?>

            </div>
            <div class="rating">
		<?php
		$ratingSql = 'SELECT ceil(AVG(rating)) as totalrating FROM mt_review where merchant_id=' . $model->merchant_id;
		$queryRating = Yii::$app->db->createCommand($ratingSql)->queryScalar();

		$ratingCountSql = 'SELECT count(*) as totalrating FROM mt_review where merchant_id=' . $model->merchant_id;
		$queryCountRating = Yii::$app->db->createCommand($ratingCountSql)->queryScalar();


		if ($queryRating != 0) {
			for ($i = 1; $i <= $queryRating; $i++) {
				?>
				<i class="icon_star voted"></i>
				<?php
			}
		}
		?>


		<?php
		$j = 5 - $queryRating;
		if ($j != 0 && $j <= 5) {
			for ($k = 1; $k <= $j; $k++) {
				?>
				<i class="icon_star"></i> 
				<?php
			}
		}
		?>
                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    (<small >


                        <span itemprop="reviewCount">
			    <?php echo $queryCountRating; ?> 
                        </span>
                        <span itemprop="ratingValue" style="display :none"><?php echo $queryRating; ?></span>

			<?php echo Yii::t('basicfield', 'reviews') ?>


                    </small>)
                </div> 
            </div>

            <h1 itemprop="name"><?php echo $model->service_name; ?></h1>


            <em>
		<?php
		echo $mservice;
		?>                   
            </em>
            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

                <i class="icon_pin"></i> 

                <span itemprop="streetAddress"><?php echo $model->address ?></span>

                - <i class="icon-phone-squared"></i> 
                <a href="tel:+<?php echo $model->contact_phone ?>" target="_blank">
                    <span itemprop="telephone"><?php echo $model->contact_phone ?></span>
                </a>
            </div>
            <div><i class="icon-website-circled"></i> 
                <a href="<?php echo 'http://' . $model->url; ?>" target="_blank" itemprop="url" > 
		    <?php echo $model->url; ?></a></div>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->
<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
?>
<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl; ?>">

		    <?php echo Yii::t('basicfield', 'Home') ?></a></li>
            <li><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search', 'Merchant[search]' => $keyword]) ?>">Search</a></li>
            <li><?php echo $model->service_name; ?></li>
        </ul>
    </div>
</div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">



	<div class="col-md-8">

	    <div class="box_style_2">
		<h2 class="inner"><?php echo Yii::t('basicfield', 'Gift vouchers')?></h2>
		<div>



		    <div class="panel-body">
			<table class="table table-striped cart-list">
			    <thead>
				<tr>
				    <th>
					<?php echo Yii::t('basicfield', 'Gift vouchers')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Price')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Quantity')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Buy now')?>
				    </th>
				</tr>
			    </thead>
			    <tbody>
				
				<?php foreach ($giftVoucher as $data){?>
				<tr>
				    <td>
					<h5><?php echo $data->name;?></h5>
					<?php if($data->type == 0){
						$totalPrice = $data->amount;
						?>
						<p><?php echo Yii::t('basicfield', 'Value:')?>
							
							<?php echo $currencyCode?> 
							<?php echo $data->amount?> </p>
						<p> <?php echo Yii::t('basicfield', 'you can use this voucher on any service')?></p>
					<?php }else if($data->type == 1){
						$totalPrice = $data->serviceName->price;
						?>
						<p><?php 
						echo $data->serviceName->title;?></p>
					<?php }else if($data->type == 2){
						$categoryHasMerchant = $data->servicesName;
						
						if(!empty($categoryHasMerchant)){?>
							
							<?php 
							$totalPrice = 0;
							foreach ($categoryHasMerchant as $services){
								$totalPrice += $services->price;
								?>
								<p><?php echo $services->title;?></p>
							<?php }
						}
						?> 
						
					<?php }?>

				    </td>
				    <td>
					<strong><?php echo $currencyCode?>  <?php echo $totalPrice;?></strong>
					
				    </td>
				    <td class="options">
					<a href="javascript:void(0)" class="add" data-type="add"> 
					    <i class="icon-plus-squared add" ></i> 
					    </a>
					    <input type="text" id="voucher_order" name="voucher_order" class="form-control1" value="0"> 
					    <a href="javascript:void(0)" class="add" data-type="sub"> 
					    <i class="icon-minus-squared add" data-type="sub"></i>
					    </a>
					
				    </td>
				    <td>

					<i style="display: inline-block;" class="icon-shopping-cart"></i>
					
					<i class="icon-spinner loading" aria-hidden="true" style="display: none"></i>
					<input type="submit" id="add-cart" class="btn_1 add_bottom_20 add-cart" value="<?php echo Yii::t('basicfield', 'Add to cart')?>" 
					       data-voucherid="<?php echo $data->id?>"
					       data-price="<?php echo $totalPrice;?>"
					       data-title="<?php echo $data->name;?>"
					       />

				    </td>
				</tr>
				
				<?php }?>
				
			    </tbody>
			</table>
		    </div>




		</div>






	    </div><!-- End box_style_1 -->
	</div>
	<div class="col-md-4">
	    
	    <?php $appointment = \frontend\models\MtMerchant::hasServices($model);
	    
	    
	    if($appointment){
	    ?>
	    
	    <p>

		    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id' => $merchantUrl]) ?>" class="btn_6 add_bottom_15">
			<?php echo Yii::t('basicfield', 'Back to merchant appointment page'); ?>
		    </a>
	    </p>
	    
	    <?php }?>
	    
	    <?php echo $this->render('gift_voucher_right', [
		'model' =>$model,
		'currencyCode' => $currencyCode
	    ]);?>



	</div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->


	


<?php 

$url = Yii::$app->urlManager->createUrl('order/voucher-cart');
$removeUrl = Yii::$app->urlManager->createUrl('order/voucher-remove');

$js = <<<SCRIPT
	
	$('body').on('click','.remove', function(){
	
		var confirmremove  = confirm('Are you sure you want to delete?');
	
		if(confirmremove == true){
			var voucherid = $(this).data('voucherid');

			$.ajax({
				type : 'post',
				url : '{$removeUrl}',
				data: {voucherid : voucherid},
				dataType : 'json',
				success : function(response){
					if(response.success == true){
						$('#voucher-cart').html(response.message);
						$('#voucher-subtotal').html(response.subtotal);
						$('#voucher-total').html(response.total);

					}

				}
			})
		}
	})
	$(".add").on("click", function(e){
		e.preventDefault();
		
		var obj = $(this);
		var input = obj.parent().find("#voucher_order");
		var output = input.val();
	
		if(obj.data('type') == 'add'){
			output = parseInt(output) + parseInt(1);
		}else if(obj.data('type') == 'sub'){
			if(output > 1){
				output = parseInt(output) - parseInt(1);
			}
		}
	
		input.val(output);
		
	
	})
	
	
	$('.add-cart').on('click', function(){
	
		var voucherid = $(this).data('voucherid');
		var price = $(this).data('price');
		var input = $(this).parent().parent().find("#voucher_order").val();
		var title = $(this).data('title');
		var spinner = $(this).parent().parent().find(".loading");
	
		if(input == 0){
			alert('Quantity cannot be zero.');	
		}else{
				
			spinner.show();		

			$.ajax({
				type : 'post',
				url : "{$url}",
				data : {voucherid: voucherid, price:price, qty:input, title: title},
				dataType : 'json',
				success :function (response){

					spinner.hide();

					if(response.success == true){
						$('#voucher-cart').html(response.message);
						$('#voucher-subtotal').html(response.subtotal);
						$('#voucher-total').html(response.total);

					}


				}
			})
		}
		
	})
	
SCRIPT;

$this->registerJs($js);

?>
