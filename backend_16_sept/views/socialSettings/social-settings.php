<?php $this->breadcrumbs = array(
    Yii::t('default','Social Settings'),
);
?>
<h1><?= Yii::t('default','Social Settings')?></h1>
<div class="box box-primary">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'contact-settings-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="box-body">
        <?php
        echo $form->textAreaGroup($model, 'values[default_share_text]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Default Share text")
            ), 'labelOptions' => array('label' => "Default Share text")]
        );
        ?>

        <p><?php echo Yii::t('default', "Available tags {merchant-name}") ?></p>
        <?php
        echo $form->checkBoxGroup($model, 'values[social_flag]');
        ?>

        <?php
        echo $form->checkBoxGroup($model, 'values[admin_merchant_share]');
        ?>

        <h2><?php echo Yii::t('default', "Facebook") ?></h2>
        <?php
        echo $form->checkBoxGroup($model, 'values[fb_flag]');
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[fb_app_id]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "App ID")
            ), 'labelOptions' => array('label' => "App ID")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[fb_app_secret]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "App Secret")
            ), 'labelOptions' => array('label' => "App Secret")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_fb_page]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Facebook Page URL")
            ), 'labelOptions' => array('label' => "Facebook Page URL")]
        );
        ?>

        <h2><?php echo Yii::t('default', "Pinterest") ?></h2>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_pinterest_page]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "pinterest Page URL"))
            ), 'labelOptions' => array('label' => Yii::t('default', "pinterest Page URL"))]
        );
        ?>

        <h2><?php echo Yii::t('default', "Instagramm") ?></h2>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_instagramm_page]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "instagramm Page URL"))
            ), 'labelOptions' => array('label' => Yii::t('default', "instagramm Page URL"))]
        );
        ?>


        <h2><?php echo Yii::t('default', "Twitter") ?></h2>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_twitter_page]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Twitter Page URL"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Twitter Page URL"))]
        );
        ?>

        <h2><?php echo Yii::t('default', "Google") ?></h2>
        <?php
        echo $form->textFieldGroup($model, 'values[admin_google_page]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Google Page URL"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Google Page URL"))]
        );
        ?>
        <?php
        echo $form->checkBoxGroup($model, 'values[google_login_enabled]');
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[google_client_id]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Client ID"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Client ID"))]
        );
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[google_client_secret]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Client Secret"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Client Secret"))])

        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[google_client_redirect_ulr]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Redirect Url"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Redirect Url"))]
        );
        ?>

        <p class="uk-text-muted uk-text-small">
            <?php echo Yii::t('default', "Redirect URL Must equal to") . " " . Yii::app()->getBaseUrl(true) . "/store/GoogleLogin" ?>
            <br>
            <?php echo Yii::t('default', "Set this url to your google developer settings") ?>
        </p>
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