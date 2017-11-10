<?php $this->breadcrumbs = array(
    Yii::t('default','Commission Settings'),
);
?>
<h1><?= Yii::t('default','Commission Settings')?></h1>
<?php
$enabled = AdminHelper::getOptionAdmin('admin_commission_enabled');
$disabled_membership = AdminHelper::getOptionAdmin('admin_disabled_membership');
$admin_commision_ontop = AdminHelper::getOptionAdmin('admin_commision_ontop');
?>
<div class="box box-primary">
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'commission-settings-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="box-body">
        <h3><?php echo Yii::t("default", "Admin Commission Settings") ?></h3>
        <?php
        echo $form->checkBoxGroup($model, 'values[admin_exclude_cod_balance]');
        ?>

        <h3><?php echo Yii::t("default", "Merchant Signup Settings") ?></h3>
        <?php
        echo $form->checkBoxGroup($model, 'values[admin_commission_enabled]');
        ?>

        <?php
        echo $form->checkBoxGroup($model, 'values[admin_disabled_membership]');
        ?>

        <?php
        echo $form->checkBoxGroup($model, 'values[admin_include_merchant_cod]');
        ?>
        <?php
        echo $form->dropDownListGroup($model, 'values[admin_commission_type]', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'data' => array(
                    'percentage' => Yii::t("default", "Percentage"),
                    'fixed' => Yii::t("default", "Fixed"),
                ),
                'label' => Yii::t("default", "commission on orders"),
                'htmlOptions' => array('prompt' => 'select commission on orders'),
            )
        ));
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_commission_percent]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Admin Commission Percent")
            ), 'labelOptions' => array('label' => "Admin Commission Percent")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_commission_fixed_val]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Admin Commission Fixed Value")
            ), 'labelOptions' => array('label' => "Admin Commission Fixed Value")]
        );
        ?>
        <?php echo $form->radioButtonListGroup(
            $model,
            'values[commission_total_order]',
            array(
                'widgetOptions' => array(
                    'data' => [Yii::t("default", "Commission on Sub total order"), Yii::t("default", "Commission on Total order")],
                )
            )
        ); ?>

        <h3><?php echo Yii::t("default", "Invoice") ?></h3>
        <?php
        echo $form->textFieldGroup($model, 'values[admin_vat_no]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "VAT No")
            ), 'labelOptions' => array('label' => "VAT No")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[admin_vat_percent]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "VAT")
            ), 'labelOptions' => array('label' => "VAT")]
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