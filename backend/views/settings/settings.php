<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php 

$this->title = 'Setting';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Settings')];
?>
<h1><?= Yii::t('basicfield','Settings')?></h1>
<div class="box box-primary">
<?php 

$form = ActiveForm::begin([
        'id' => 'settings-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); 
?>
<div class="box-body">
    <?php //echo CHtml::hiddenField('action', 'adminSettings') ?>

    <h2><?php echo Yii::t("basicfield", "Website") ?></h2>

    <?php
    
    echo $form->field($model, 'values[website_title]')->textInput(
            ['placeholder' => "Title of the website"
             ])->label("Website Title");

    
    ?>


    <?php
    
    echo $form->field($model, 'values[website_loyalty_points]')->textInput(
            ['placeholder' => "Per 1 eur"
             ])->label("Loyalty Points per 1 eur");

    
    ?>
    
    <?php
    
    echo $form->field($model, 'values[minimum_loyalty_points]')->textInput(
            ['placeholder' => ""
             ])->label("Minimum Loyalty Points");

    
    ?>
    
    <?php $tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
	if (is_array($tzlist) && count($tzlist)>=1){
		foreach ($tzlist as $val) {
			$list[$val]=$val;
		}
	}
	
		
		echo $form->field($model, 'values[website_time_zone]')->dropDownList(
			$list,
            ['placeholder' => ""
             ])->label("Time Zone");
		?>


<!--    <h2><?php echo Yii::t("basicfield", "Customer popup address options") ?></h2>-->

    <?php
    //echo $form->field($model, 'values[customer_ask_address]')->checkBox(['label'=> 'Disabled popup asking customer address']);
    ?>

    <hr/>

    <h2><?php echo Yii::t("basicfield", "Merchant change order options") ?></h2>

    <?php
    echo $form->field($model, 'values[merchant_changeorder_sms]')->checkBox(['label'=> 'Disabled send sms/email after change order']);
    ?>

    <hr/>


    <h3><?php echo Yii::t("basicfield", "Block email address list") ?></h3>
    <?php 
    
    echo $form->field($model, 'values[blocked_email_add]')->textInput(
            ['placeholder' => Yii::t("basicfield", "Block email address list")
             ])->label(false);
    ?>
    <p><?php echo Yii::t("basicfield", "Multiple email separated by comma") ?></p>

    <h3><?php echo Yii::t("basicfield", "Block mobile number list") ?></h3>

    <?php
    echo $form->field($model, 'values[blocked_mobile]')->textInput(
            ['placeholder' => Yii::t("basicfield", "Block mobile number list")
             ])->label(false);
    
    
    ?>
    <p><?php echo Yii::t("basicfield", "Multiple mobile separated by comma") ?></p>

    <hr/>

<!--    <h2><?php echo Yii::t("basicfield", "Guest Checkout") ?></h2>-->

    <?php
    //echo $form->field($model, 'values[website_disabled_guest_checkout]')->checkBox(['label' => 'Disabled Guest Checkout']);
    ?>
    <hr/>

    <h3><?php echo Yii::t("basicfield", "Menu Options") ?></h3>
    <?php 
    
    echo $form->field($model,
        'values[admin_activated_menu]')
            ->radioList([Yii::t("basicfield", "Default Menu"), Yii::t("basicfield", "Activate Menu 1"), Yii::t("basicfield", "Activate Menu 2")]);
    
     ?>


<!--    <h3><?php echo Yii::t("basicfield", "Cart Options") ?></h3>-->

    <?php
    //echo $form->field($model, 'values[disabled_cart_sticky]')->checkBox(['label' => 'Disabled Sticky Cart']);
    ?>

    <?php
    //echo $form->field($model, 'values[website_enabled_map_address]')->checkBox(['label' => 'Enabled Map Address']);
    ?>

    <p>
        <?php //echo Yii::t("basicfield", "This options enabled the customer to select his/her address from the map during checkout") ?></p>

    <hr/>

    <h2><?php echo Yii::t("basicfield", "Featured Services") ?></h2>

    <?php
    echo $form->field($model, 'values[disabled_featured_merchant]')->checkBox(['label' => 'Disabled']);
    ?>

    <hr/>
    <h2><?php echo Yii::t("basicfield", "Subscription") ?></h2>

    <?php
    echo $form->field($model, 'values[disabled_subscription]')->checkBox(['label' => 'Disabled']);
    ?>

    <hr/>
<!--    <h2><?php echo Yii::t("basicfield", "Merchant Registration") ?></h2>-->

    <?php
    //echo $form->field($model, 'values[merchant_disabled_registration]')->checkBox(['label' => 'Disabled Registration']);
    ?>
    <p><?php //echo Yii::t("basicfield", "Check this if you want to disabled merchant registration") ?></p>


    <?php
    
    echo $form->field($model, 'values[merchant_sigup_status]')
            ->dropDownList(AdminHelper::clientStatus(), ['prompt' => 'Registration Status'])
            ->label('Merchant Sign Up Status');
    
    ?>
    <p><?php echo Yii::t("basicfield", "The status of the merchant after registration") ?></p>

    <?php
    //echo $form->field($model, 'values[merchant_email_verification]')->checkBox(['label' => 'Disabled Verification']);
    ?>
    <p><?php echo Yii::t("basicfield", "Check this if you want to disabled merchant Verification") ?></p>
    <?php
    echo $form->field($model, 'values[merchant_payment_enabled]')->checkBox(['label' => 'Disabled Payment']);
    ?>

    <?php
    echo $form->field($model, 'values[admin_enabled_paypal]')->checkBox(['label' => 'Disabled Paypal']);
    ?>

    <?php
    echo $form->field($model, 'values[admin_enabled_card]')->checkBox(['label' => 'Disabled Card Payment']);
    ?>

    <hr/>
    <h2><?php echo Yii::t("basicfield", "Address & Currency") ?></h2>

    <?php
    echo $form->field($model, 'values[website_address]')->textInput(
            ['placeholder' => "Address"
             ])->label("Address");
    
    
    ?>


    <?php
    
    echo $form->field($model, 'values[website_contact_phone]')->textInput(
            ['placeholder' => "Contact Phone Number"
             ])->label("Contact Phone Number");
    
    
    
    ?>

    <?php
    
    echo $form->field($model, 'values[website_contact_email]')->textInput(
            ['placeholder' => "Contact emails"
             ])->label("Contact email");
    
    
    
    ?>

    <?php
    
    echo $form->field($model, 'values[global_admin_sender_email]')->textInput(
            ['placeholder' => "Global Sender email"
             ])->label("Global Sender email");
    
    ?>
    <p>(<?php echo Yii::t("basicfield", "This email address will be use when sending email") ?>)</p>

    <?php
    
     echo $form->field($model, 'values[admin_thousand_separator]')->textInput(
            ['placeholder' => "Thousand Separators"
             ])->label("Thousand Separators");
    
    ?>

    <p>(<?php echo Yii::t("basicfield", "leave empty to use standard decimal separators") ?>)</p>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>