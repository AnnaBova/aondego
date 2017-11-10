<?php $this->breadcrumbs = array(
    Yii::t('default','Settings'),
);
?>
<h1><?= Yii::t('default','Settings')?></h1>
<div class="box box-primary">
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'settings-form',
    'enableAjaxValidation' => false,
)); ?>
<div class="box-body">
    <?php //echo CHtml::hiddenField('action', 'adminSettings') ?>

    <h2><?php echo Yii::t("default", "Website") ?></h2>

    <?php

    echo $form->textFieldGroup($model, 'values[website_title]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Title of the website")
        ), 'labelOptions' => array('label' => 'Website Title')]
    );
    ?>


    <?php

    echo $form->textFieldGroup($model, 'values[website_loyalty_points]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Per 1 eur")
        ), 'labelOptions' => array('label' => 'Loyalty Points per 1 eur')]
    );
    ?>


    <h2><?php echo Yii::t("default", "Customer popup address options") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[customer_ask_address]')
    ?>

    <hr/>

    <h2><?php echo Yii::t("default", "Merchant change order options") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[merchant_changeorder_sms]')
    ?>

    <hr/>


    <h3><?php echo Yii::t("default", "Block email address list") ?></h3>
    <?php
    echo $form->textAreaGroup($model, 'values[blocked_email_add]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t("default", "Block email address list"))
        ), 'labelOptions' => array('label' => false)]
    )?>
    <p><?php echo Yii::t("default", "Multiple email separated by comma") ?></p>

    <h3><?php echo Yii::t("default", "Block mobile number list") ?></h3>

    <?php
    echo $form->textAreaGroup($model, 'values[blocked_mobile]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t("default", "Block mobile number list"))
        ), 'labelOptions' => array('label' => false)]
    );
    ?>
    <p><?php echo Yii::t("default", "Multiple mobile separated by comma") ?></p>

    <hr/>

    <h2><?php echo Yii::t("default", "Guest Checkout") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[website_disabled_guest_checkout]');
    ?>
    <hr/>

    <h3><?php echo Yii::t("default", "Menu Options") ?></h3>
    <?php echo $form->radioButtonListGroup(
        $model,
        'values[admin_activated_menu]',
        array(
            'widgetOptions' => array(
                'data' => [Yii::t("default", "Default Menu"), Yii::t("default", "Activate Menu 1"), Yii::t("default", "Activate Menu 2")]
            )
        )
    ); ?>


    <h3><?php echo Yii::t("default", "Cart Options") ?></h3>

    <?php
    echo $form->checkBoxGroup($model, 'values[disabled_cart_sticky]');
    ?>

    <?php
    echo $form->checkBoxGroup($model, 'values[website_enabled_map_address]');
    ?>

    <p>
        <?php echo Yii::t("default", "This options enabled the customer to select his/her address from the map during checkout") ?></p>

    <hr/>

    <h2><?php echo Yii::t("default", "Featured Services") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[disabled_featured_merchant]');
    ?>

    <hr/>
    <h2><?php echo Yii::t("default", "Subscription") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[disabled_subscription]');
    ?>

    <hr/>
    <h2><?php echo Yii::t("default", "Merchant Registration") ?></h2>

    <?php
    echo $form->checkBoxGroup($model, 'values[merchant_disabled_registration]');
    ?>
    <p><?php echo Yii::t("default", "Check this if you want to disabled merchant registration") ?></p>


    <?php
    echo $form->dropDownListGroup($model, 'values[merchant_sigup_status]', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => AdminHelper::clientStatus(),
            'label' => Yii::t("default", "Registration Status"),
            'htmlOptions' => array('prompt' => 'Registration Status'),
        )
    ));
    ?>
    <p><?php echo Yii::t("default", "The status of the merchant after registration") ?></p>

    <?php
    echo $form->checkBoxGroup($model, 'values[merchant_email_verification]');
    ?>
    <p><?php echo Yii::t("default", "Check this if you want to disabled merchant Verification") ?></p>
    <?php
    echo $form->checkBoxGroup($model, 'values[merchant_payment_enabled]');
    ?>

    <?php
    echo $form->checkBoxGroup($model, 'values[admin_enabled_paypal]');
    ?>

    <?php
    echo $form->checkBoxGroup($model, 'values[admin_enabled_card]');
    ?>

    <hr/>
    <h2><?php echo Yii::t("default", "Address & Currency") ?></h2>

    <?php
    echo $form->textFieldGroup($model, 'values[website_address]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Address")
        ), 'labelOptions' => array('label' => "Address")]
    );
    ?>


    <?php
    echo $form->textFieldGroup($model, 'values[website_contact_phone]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Contact Phone Number")
        ), 'labelOptions' => array('label' => "Contact Phone Number")]
    );
    ?>

    <?php
    echo $form->textFieldGroup($model, 'values[website_contact_email]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Contact email")
        ), 'labelOptions' => array('label' => "Contact email")]
    );
    ?>

    <?php
    echo $form->textFieldGroup($model, 'values[global_admin_sender_email]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Global Sender email")
        ), 'labelOptions' => array('label' => "Global Sender email")]
    );
    ?>
    <p>(<?php echo Yii::t("default", "This email address will be use when sending email") ?>)</p>

    <?php
    echo $form->textFieldGroup($model, 'values[admin_thousand_separator]',
        ['widgetOptions' => array(
            'htmlOptions' => array('placeholder' => "Thousand Separators")
        ), 'labelOptions' => array('label' => "Thousand Separators")]
    );
    ?>

    <p>(<?php echo Yii::t("default", "leave empty to use standard decimal separators") ?>)</p>
</div>
<div class="box-footer">
    <?php $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    )); ?>
</div>
<?php $this->endWidget(); ?>
</div>