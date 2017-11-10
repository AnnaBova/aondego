<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $this->breadcrumbs = array(
    Yii::t('default','Paypal Settings'),
);
?>
<h1><?= Yii::t('default','Paypal Settings')?></h1>

<?php
$enabled_paypal = AdminHelper::getOptionAdmin('admin_enabled_paypal');
$paypal_mode = AdminHelper::getOptionAdmin('admin_paypal_mode');
?>
<div class="box box-primary">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'paypal-settings-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="box-body">
        <?php echo $form->radioButtonListGroup(
            $model,
            'values[admin_paypal_mode]',
            array(
                'widgetOptions' => array(
                    'data' => [Yii::t("default", "sandbox"), Yii::t("default", "live")]
                )
            )
        ); ?>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_paypal_fee]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Card Fee"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Card Fee"))]
        );
        ?>


        <h3><?php echo Yii::t("default", "Sandbox") ?></h3>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_sanbox_paypal_user]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal User"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal User"))]
        );
        ?>
        <?php
        echo $form->passwordFieldGroup($model, 'values[admin_sanbox_paypal_pass]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal Password"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal Password"))]
        );
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[admin_sanbox_paypal_signature]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal Signature"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal Signature"))]
        );
        ?>



        <h3><?php echo Yii::t("default", "Live") ?></h3>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_live_paypal_user]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal User"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal User"))]
        );
        ?>
        <?php
        echo $form->passwordFieldGroup($model, 'values[admin_live_paypal_pass]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal Password"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal Password"))]
        );
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[admin_live_paypal_signature]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => Yii::t('default', "Paypal Signature"))
            ), 'labelOptions' => array('label' => Yii::t('default', "Paypal Signature"))]
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