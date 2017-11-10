<?php $this->breadcrumbs=array(
    Yii::t('default','Email Tpl For Admin'),
);
?>
    <h1><?= Yii::t('default','Email Templates For Admin')?></h1>
<div class="box box-primary">
<?php Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget'); ?>
<?php
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'tpl-email-form',
    'enableAjaxValidation'=>false,
)); ?>

    <div class="box-body">
<?php 
 

$email_tpl_activation=AdminHelper::getOptionAdmin('email_tpl_activation');
if (empty($email_tpl_activation)){	
	$email_tpl_activation=EmailTPL::merchantActivationCodePlain();
}

$email_tpl_forgot=AdminHelper::getOptionAdmin('email_tpl_forgot');
if (empty($email_tpl_forgot)){		
	$email_tpl_forgot=EmailTPL::merchantForgotPassPlain();
}
?>
        
        
<h3><?php echo Yii::t('default',"New Merchant registration email template")?></h3>


<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_new_merchant]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{website_name}")?></li>
 <li><?php echo Yii::t('default',"{client_name}")?></li>
 <li><?php echo Yii::t('default',"{email_address}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('default',"activation request of merchant email template")?></h3>


<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_activation_merchant]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{service_name}")?></li>
 <li><?php echo Yii::t('default',"{activation_key}")?></li>
 <li><?php echo Yii::t('default',"{website_title}")?></li>
 <li><?php echo Yii::t('default',"{website_url}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('default',"membership expires email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_membership_expires]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{service_name}")?></li>
 <li><?php echo Yii::t('default',"{website_title}")?></li>
 <li><?php echo Yii::t('default',"{expire_date}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('default',"new user registration email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_new_customer_register]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{first_name}")?></li>
 <li><?php echo Yii::t('default',"{last_name}")?></li>
 <li><?php echo Yii::t('default',"{email}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('default',"new appointment email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_new_appointment]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{service_name}")?></li>
 <li><?php echo Yii::t('default',"{username}")?></li>
 <li><?php echo Yii::t('default',"{startdate}")?></li>
 <li><?php echo Yii::t('default',"{starttime}")?></li>
 <li><?php echo Yii::t('default',"{enddate}")?></li>
 <li><?php echo Yii::t('default',"{endtime}")?></li>
 <li><?php echo Yii::t('default',"{booking_id}")?></li>
 <li><?php echo Yii::t('default',"{booked_seats}")?></li>
 <li><?php echo Yii::t('default',"{booking_due}")?></li>
 <li><?php echo Yii::t('default',"{booking_deposit}")?></li>
 <li><?php echo Yii::t('default',"{booking_total}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('default',"appointment has been modified email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_appointment_modified]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{service_name}")?></li>
 <li><?php echo Yii::t('default',"{username}")?></li>
 <li><?php echo Yii::t('default',"{startdate}")?></li>
 <li><?php echo Yii::t('default',"{starttime}")?></li>
 <li><?php echo Yii::t('default',"{enddate}")?></li>
 <li><?php echo Yii::t('default',"{endtime}")?></li>
 <li><?php echo Yii::t('default',"{booking_id}")?></li>
 <li><?php echo Yii::t('default',"{booked_seats}")?></li>
 <li><?php echo Yii::t('default',"{booking_due}")?></li>
 <li><?php echo Yii::t('default',"{booking_deposit}")?></li>
 <li><?php echo Yii::t('default',"{booking_total}")?></li>
 
</ul>


<hr/>
    <h3><?php echo Yii::t('default',"appointment has been canceled email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_appointment_cancelled]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{service_name}")?></li>
 <li><?php echo Yii::t('default',"{username}")?></li>
 <li><?php echo Yii::t('default',"{startdate}")?></li>
 <li><?php echo Yii::t('default',"{starttime}")?></li>
 <li><?php echo Yii::t('default',"{enddate}")?></li>
 <li><?php echo Yii::t('default',"{endtime}")?></li>
 <li><?php echo Yii::t('default',"{booking_id}")?></li>
 <li><?php echo Yii::t('default',"{cancellation_id}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('default',"newsletter template email template")?></h3>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'values[email_tpl_admin_newsletter]',
)); ?>

<p style="margin:0;"><?php echo Yii::t('default',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('default',"{email}")?></li>
 
</ul>

</div>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

<?php $this->endWidget(); ?>
    </div>