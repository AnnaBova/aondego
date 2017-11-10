 <?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;
?>

<?php 

$this->title = 'Email Tpl For Customer';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Email Tpl For Customer')];
?>
    <h1><?= Yii::t('basicfield','Email Templates For Customer')?></h1>
<div class="box box-primary">
    <?php 
     \backend\components\Translatte::getLanguage($model);
    ?>

<?php

$form = ActiveForm::begin([
        'id' => 'tpl-email-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="box-body">

        
        
<h3><?php echo Yii::t('basicfield',"user welcome and activiation email email template")?></h3>

<?php echo $form->field($model, 'values[email_tpl_sub_customer_user_welcome_activation]')->label(Yii::t('basicfield', 'Subject'));?>

<?= $form->field($model, 'values[email_tpl_customer_user_welcome_activation]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{site_link}")?></li>
 <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{last_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{email}")?></li>
 <li><?php echo Yii::t('basicfield',"{activation_key}")?></li>
 <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
 
</ul>

<hr/>

<h3><?php echo Yii::t('basicfield',"registration email from merchant email template")?></h3>

<?php echo $form->field($model, 'values[email_tpl_sub_customer_user_welcome_from_merchant]')->label(Yii::t('basicfield', 'Subject'));?>

<?= $form->field($model, 'values[email_tpl_customer_user_welcome_from_merchant]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{site_link}")?></li>
 <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{last_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{email}")?></li>
 <li><?php echo Yii::t('basicfield',"{password}")?></li>
 <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
 
</ul>

<hr/>




    <h3><?php echo Yii::t('basicfield',"forgot password email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_forgot_password]')->label(Yii::t('basicfield', 'Subject'));?>

    <?= $form->field($model, 'values[email_tpl_customer_forgot_password]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{link}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"appointment email email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_appointment]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
	
	<ul>
		<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	</ul>

    <?= $form->field($model, 'values[email_tpl_customer_appointment]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
    
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
	<li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
	<li><?php echo Yii::t('basicfield',"{addons_list}")?></li>
 
 
</ul>





<hr/>
    <h3><?php echo Yii::t('basicfield',"appointment has been modified email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_appointment_modified]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>

    <?= $form->field($model, 'values[email_tpl_customer_appointment_modified]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	
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
	<li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
	<li><?php echo Yii::t('basicfield',"{addons_list}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"appointment has been canceled email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_appointment_cancelled]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>

    <?= $form->field($model, 'values[email_tpl_customer_appointment_cancelled]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	
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
	<li><?php echo Yii::t('basicfield',"{cancellation_id}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_used}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_amount}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_points_used}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_points_amount}")?></li>
	<li><?php echo Yii::t('basicfield',"{cancel_reason}")?></li>
	<li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
	<li><?php echo Yii::t('basicfield',"{addons_list}")?></li>
 
 
</ul>

<h3><?php echo Yii::t('basicfield',"email templates for customers")?></h3>

<?php echo $form->field($model, 'values[email_tpl_sub_customer_reminder_email]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>
    
     <?= $form->field($model, 'values[email_tpl_customer_reminder_email]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>       


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>

	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_address}")?></li>
	<li><?php echo Yii::t('basicfield',"{booked_service}")?></li>
	<li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
	<li><?php echo Yii::t('basicfield',"{website_title}")?></li>
	<li><?php echo Yii::t('basicfield',"{reminder}")?></li>
 
</ul>


<hr/>

<hr/>
    <h3><?php echo Yii::t('basicfield',"loyalty point notification email template")?></h3>
    
    
<?php echo $form->field($model, 'values[email_tpl_sub_customer_loyality]')->label('Subject');?>
    
    

    <?= $form->field($model, 'values[email_tpl_customer_loyality]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_point}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_expire}")?></li>
 
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"loyalty point expire notification email template")?></h3>
    
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_loyality_exire]')->label('Subject');?>

    <?= $form->field($model, 'values[email_tpl_customer_loyality_exire]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_point}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{loyalty_expire}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"voucher email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_voucher]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
</ul>

    <?= $form->field($model, 'values[email_tpl_customer_voucher]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
	
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
	
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_amount}")?></li>
	<li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
</ul>



<hr/>
    <h3><?php echo Yii::t('basicfield',"birthday coupon email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_customer_birthday_coupon]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
</ul>

    <?= $form->field($model, 'values[email_tpl_customer_birthday_coupon]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{admin_logo}")?></li>
	<li><?php echo Yii::t('basicfield',Yii::$app->getRequest()->getHostInfo()."/{merchant_logo}")?></li>
    
	<li><?php echo Yii::t('basicfield',"{first_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{last_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon}")?></li>
	<li><?php echo Yii::t('basicfield',"{coupon_amount}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
</ul>
<hr/>


<h3><?php echo Yii::t('basicfield',"Voucher order email template")?></h3>

<?php echo $form->field($model, 'values[email_tpl_sub_customer_voucher_order]')->label('Subject');?>

<?= $form->field($model, 'values[email_tpl_customer_voucher_order]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


	<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
	<ul>
	 <li><?php echo Yii::t('basicfield',"{client_name}")?></li>
	 <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	 <li><?php echo Yii::t('basicfield',"{voucher_package}")?></li>
	 <li><?php echo Yii::t('basicfield',"{voucher_receiver}")?></li>
	 <li><?php echo Yii::t('basicfield',"{voucher_message}")?></li>
	 <li><?php echo Yii::t('basicfield',"{delivery_option}")?></li>
	 <li><?php echo Yii::t('basicfield',"{payment}")?></li>
	 <li><?php echo Yii::t('basicfield',"{price}")?></li>
	 <li><?php echo Yii::t('basicfield',"{delivery_fee}")?></li>
	  <li><?php echo Yii::t('basicfield',"{delivery_to_name}")?></li>
	 <li><?php echo Yii::t('basicfield',"{delivery_to_address}")?></li>
	 <li><?php echo Yii::t('basicfield',"{currency_code}")?></li>
	</ul>

</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield','Create') : Yii::t('basicfield','Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
    </div>