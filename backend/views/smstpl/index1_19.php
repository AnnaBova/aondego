 <?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;
?>

<?php 
$this->title = 'Sms Template';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Sms Template')];
?>
<h1><?= Yii::t('basicfield','Sms Template')?></h1>
<div class="box box-primary">
<?php \backend\components\Translatte::getLanguage($model); ?>
<?php
$form = ActiveForm::begin([
	'id' => 'tpl-sms-form',
	'enableAjaxValidation' => false,
	'options' => ['enctype' => 'multipart/form-data']
	]); ?>

	<div class="box-body">

	<h3><?php echo Yii::t('basicfield',"Appointment sms template")?></h3>
    
	<?php echo $form->field($model, 'values[sms_sub_appointment]')->label('Subject');?>
    
	<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>

	<?= $form->field($model, 'values[sms_appointment]')->textarea(['rows' => 6])->label(false);?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_address}")?></li>
	<li><?php echo Yii::t('basicfield',"{booked_service}")?></li>
	<li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{service_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{username}")?></li>
	<li><?php echo Yii::t('basicfield',"{startdate}")?></li>
	<li><?php echo Yii::t('basicfield',"{starttime}")?></li>
	<li><?php echo Yii::t('basicfield',"{enddate}")?></li>
	<li><?php echo Yii::t('basicfield',"{endtime}")?></li>
	<li><?php echo Yii::t('basicfield',"{booking_id}")?></li>
	<li><?php echo Yii::t('basicfield',"{booked_seats}")?></li>
	<li><?php echo Yii::t('basicfield',"{booking_due}")?></li>
	<li><?php echo Yii::t('basicfield',"{booking_deposit}")?></li>
	<li><?php echo Yii::t('basicfield',"{booking_total}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_used}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_amount}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_points_used}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_points_amount}")?></li>
</ul>
<hr/>
<h3><?php echo Yii::t('basicfield',"Birthday coupon sms template")?></h3>
    
<?php echo $form->field($model, 'values[sms_sub_birthday_coupon]')->label('Subject');?>
    
<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
</ul>

<?= $form->field($model, 'values[sms_birthday_coupon]')->textarea(['rows' => 6])->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
    <li><?php echo Yii::t('basicfield',"{last_name}")?></li>
    <li><?php echo Yii::t('basicfield',"{coupon}")?></li>
    <li><?php echo Yii::t('basicfield',"{coupon_amount}")?></li>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>

</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield','Create') : Yii::t('basicfield','Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
    </div>