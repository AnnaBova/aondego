<div class="wf-wizard">


	<?php
	if (Yii::$app->controller->action->id == 'widget-index' || Yii::$app->controller->action->id == 'voucher') {
		$yourDetail = 'active';
		$payment = 'disabled';
		$finish = 'disabled';
	} else if (Yii::$app->controller->action->id == 'widget-payment' || Yii::$app->controller->action->id == 'voucher-payment') {
		$yourDetail = 'complete';
		$payment = 'active';
		$finish = 'disabled';
	} else {
		$yourDetail = 'complete';
		$payment = 'complete';
		$finish = 'active';
	}
	?>




	<div class="col-xs-4 wf-wizard-step <?php echo $yourDetail ?>">
		<div class="text-center wf-wizard-stepnum"><strong>1.</strong> 
			<?php echo Yii::t('basicfield', 'Your details') ?></div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="cart.html" class="wf-wizard-dot"></a>

	</div>

	<div class="col-xs-4 wf-wizard-step <?php echo $payment ?>">
		<div class="text-center wf-wizard-stepnum"><strong>2.</strong> <?php echo Yii::t('basicfield', 'Payment') ?></div>
		<div class="progress"><div class="progress-bar"></div></div>

		<a href="#0" class="wf-wizard-dot"></a>

	</div>

	<div class="col-xs-4 wf-wizard-step <?php echo $finish ?>">
		<div class="text-center wf-wizard-stepnum"><strong>3.</strong> <?php echo Yii::t('basicfield', 'Finish') ?>!</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="cart_3.html" class="wf-wizard-dot"></a>
	</div>  

</div>