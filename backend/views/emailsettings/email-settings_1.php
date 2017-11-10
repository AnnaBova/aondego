<?php $this->breadcrumbs = array(
    Yii::t('default','Email Settings'),
);
?>
<h1><?= Yii::t('default','Email Settings')?></h1>
<div class="box box-primary">
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'email-settings-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="box-body">
        <?php
        $email_provider = AdminHelper::getOptionAdmin('email_provider');
        ?>

        <?php echo $form->radioButtonListGroup(
            $model,
            'values[email_provider]',
            array(
                'widgetOptions' => array(
                    'data' => [Yii::t("default", "phpmail"), Yii::t("default", "smtp"), 'mandrill']
                )
            )
        ); ?>

        <?php
        echo $form->textFieldGroup($model, 'values[smtp_host]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "SMTP host")
            ), 'labelOptions' => array('label' => "SMTP host")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[smtp_port]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "SMTP port")
            ), 'labelOptions' => array('label' => "SMTP port")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[smtp_username]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Username")
            ), 'labelOptions' => array('label' => "Username")]
        );
        ?>


        <?php
        echo $form->passwordFieldGroup($model, 'values[smtp_password]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Password")
            ), 'labelOptions' => array('label' => "Password")]
        );
        ?>


        <p><?php echo Yii::t("default", "Note: When using SMTP make sure the port number is open in your server") ?>
            .<br/>
            <?php echo Yii::t("default", "You can ask your hosting to open this for you") ?>.
        </p>


        <h3><?php echo Yii::t("default", "Mandrill API") ?></h3>

        <?php
        echo $form->textFieldGroup($model, 'values[mandrill_api_key]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "API KEY")
            ), 'labelOptions' => array('label' => "API KEY")]
        );
        ?>
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