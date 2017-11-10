<?php
/* @var $this DatabaseemailsettingController */
/* @var $data DatabaseEmailSetting */
use yii\helpers\html;
?>

<div class="view">

	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('email_from')); ?>:</b>
	<?php echo Html::encode($data->email_from); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('email_to')); ?>:</b>
	<?php echo Html::encode($data->email_to); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('smtp_host')); ?>:</b>
	<?php echo Html::encode($data->smtp_host); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('smtp_port')); ?>:</b>
	<?php echo Html::encode($data->smtp_port); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('smtp_username')); ?>:</b>
	<?php echo Html::encode($data->smtp_username); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('smtp_password')); ?>:</b>
	<?php echo Html::encode($data->smtp_password); ?>
	<br />

	<?php /*
	<b><?php echo Html::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo Html::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>