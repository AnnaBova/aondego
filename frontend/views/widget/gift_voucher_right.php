<?php
use frontend\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="box_style_2">

    <h4 class="nomargin_top">
	<?php echo Yii::t('basicfield', 'Delivery Options');?>
	 <i class="icon_clock_alt pull-right"></i></h4>
    
    <?php if($model->giftVoucherSetting->is_delivery_free == 1){?>
    <p>
	<?php echo Yii::t('basicfield', 'A shipping and handling fee of {fee} will apply if the voucher is delivered by regular mail to the recepient.', [
	    'fee' => $model->giftVoucherSetting->delivery_fee
	]);?>
	 </p>
    <?php }else if($model->giftVoucherSetting->is_delivery_free == 0){?>
    <p>
	<?php echo Yii::t('basicfield', 'The delivery of the voucher is free.')?>
	</p>
    <?php }?>
</div>	



<div id="cart_box">
    <h3>Your Order <i class="icon_cart pull-right"></i></h3>
    
    
	<div id="voucher-cart">
		<?php echo $this->renderAjax('/order/voucher-cart');
		$session = Yii::$app->session;
		?>
	    
	</div>


	<hr>					
	<table class="table table_summary">
	    <tbody>
		<tr>
		    <td>
			<?php echo Yii::t('basicfield', 'Subtotal')?>
			 <span class="pull-right">
			    <?php echo $currencycode;?>
			     
			    <span id="voucher-subtotal">
			    <?php echo $session['voucher-subtotal']?>
			    </span>
			</span>
		    </td>
		</tr>

		<tr>
		    <td class="total">
			<?php echo Yii::t('basicfield', 'TOTAL')?>
			 <span class="pull-right">
				 <?php echo $currencycode;?> 
			    <span id="voucher-total">
			    <?php echo $session['voucher-total']?>
			    </span>
			</span>
		    </td>
		</tr>
	    </tbody>
	</table>
	<form method="post" name="CheckoutGiftVouchers">
		
		<button type="submit" class="btn_full" id="proceedToCheckout">
		    <?php echo Yii::t('basicfield', 'Proceed to checkout')?>
		    </button>
	</form>
</div><!-- End cart_box -->
<!-- Login modal -->
<div class="modal fade" id="login-ajax" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal-popup">
			<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>

			<?php
			$model = new LoginForm;
			$form = ActiveForm::begin([
				'id' => 'login-ajax',

				'options'=>[
					'class'=>'popup-form',
					'name' => 'login-ajax-form',
				],

			]); ?>

			<div class="login_icon"><i class="icon_lock_alt"></i></div>

			<?= $form->field($model, 'email', ['template'=>'{input}{error}',
				'options' => [
					'tag'=>false
				]])->textInput(['autofocus' => true,'class'=>'form-control form-white','placeholder'=>Yii::t('basicfield','Email')])->label(false) ?>

			<?= $form->field($model, 'password', ['template'=>'{input}{error}',
				'options' => [
					'tag'=>false
				]])->passwordInput(['class'=>'form-control form-white','placeholder'=>Yii::t('basicfield','Password')])->label(false)  ?>



			<div class="text-left">
				<?= Html::a(Yii::t('basicfield','Forgot Password?'), ['site/request-password-reset']) ?>.
				<a href="#0" data-toggle="modal" data-target="#register">
					<?php echo Yii::t('basicfield', 'Register')?>
				</a>
			</div>

			<div class="form-group">
				<?= Html::button(Yii::t('basicfield','Submit'), ['class' => 'btn btn-submit',
					'name' => 'login-ajax-button',
					'id'=>'login-ajax-button',
				]) ?>
			</div>

			<?php ActiveForm::end(); ?>



		</div>
	</div>
</div><!-- End modal -->
<?php
if (Yii::$app->user->isGuest) {
	$auth = 0;
} else {
	$auth = 1;
}
$this->registerJs("
	$('#proceedToCheckout').on('click',function(event) {
	    event.preventDefault();
		if ($auth === 0) {
		$('#login-ajax').modal(\"show\");
		} else {
		$('[name=\"CheckoutGiftVouchers\"]').submit();
		}
	
	});
	
	var user_is_login = $auth
    if ( user_is_login === 0 ) {
       $('.not_logged').css({display: 'inline-block'});            
       $('.logged').css({display: 'none'});            
    } else {
        $('.not_logged').css({display: 'none'});
        $('.logged').css({display: 'inline-block'});
    }
 
	 $('#login-ajax-button').click(function(event){
    event.preventDefault();
    var email = $('#loginform-email').val();
    var pass = $('#loginform-password').val();
    var LoginForm = {};
    LoginForm.email = email;
    LoginForm.password = pass;
console.log(LoginForm);
    $.ajax({
        url: '/login',
        method: 'post',
        data: { LoginForm: LoginForm, socket: 1},
        success: function(data) {
        var data = JSON.parse(data);
        if (data.status === 200) {
                    $('#login-ajax').modal(\"hide\");
                    $('#myReview').modal(\"show\");
                    $('.user_name').text(data.name);
                    $('#login-ajax').find('.help-block').html('');
                    $('[name=\"CheckoutGiftVouchers\"]').submit();
        }
        if (data.status === 403) {
                    $('#login-ajax').find('.help-block').last().html('Incorrect email or password.');
        }
        },
        error: function(err){
        console.log(err);
        }
    });
    });
	");
?>