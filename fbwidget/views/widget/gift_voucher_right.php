
<div class="box_style_2">

    <h4 class="nomargin_top">Delivery Options <i class="icon_clock_alt pull-right"></i></h4>
    
    <?php if($model->giftVoucherSetting->is_delivery_free == 1){?>
    <p>A shipping and handling fee of <?php echo $model->giftVoucherSetting->delivery_fee;?> will apply if the voucher is delivered by regular mail to the recepient.</p>
    <?php }else if($model->giftVoucherSetting->is_delivery_free == 0){?>
    <p>The delivery of the voucher is free.</p>
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
			Subtotal <span class="pull-right">€ 
			    <span id="voucher-subtotal">
			    <?php echo $session['voucher-subtotal']?>
			    </span>
			</span>
		    </td>
		</tr>

		<tr>
		    <td class="total">
			TOTAL <span class="pull-right">€ 
			    <span id="voucher-total">
			    <?php echo $session['voucher-total']?>
			    </span>
			</span>
		    </td>
		</tr>
	    </tbody>
	</table>
	<form method="post">
		
		<button type="submit" class="btn_full">Proceed to checkout</button>
	</form>
</div><!-- End cart_box -->