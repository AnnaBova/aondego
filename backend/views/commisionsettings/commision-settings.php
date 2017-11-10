<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php /*$this->breadcrumbs = array(
    Yii::t('default','Commission Settings'),
);*/

$this->title = 'Comission Setting';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Commission Settings')];

?>
<h1><?= Yii::t('basicfield','Commission Settings')?></h1>
<?php
$enabled = AdminHelper::getOptionAdmin('admin_commission_enabled');
$disabled_membership = AdminHelper::getOptionAdmin('admin_disabled_membership');
$admin_commision_ontop = AdminHelper::getOptionAdmin('admin_commision_ontop');
?>
<div class="box box-primary">
    <?php 
    
    $form = ActiveForm::begin([
        'id' => 'commission-settings-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    
    <div class="box-body">
        <h3><?php echo Yii::t("basicfield", "Admin Commission Settings") ?></h3>
        <?php
        echo $form->field($model, 'values[admin_exclude_cod_balance]')->checkBox(['label' => 'Exclude All Offline Payment from admin balance']);
        ?>

        <h3><?php echo Yii::t("basicfield", "Merchant Signup Settings") ?></h3>
        <?php
        echo $form->field($model, 'values[admin_commission_enabled]')->checkBox(['label' => 'Enabled Commission']);
        ?>

        <?php
        echo $form->field($model, 'values[admin_disabled_membership]')->checkBox(['label' => 'Disabled Membership']);
        ?>

        <?php
        echo $form->field($model, 'values[admin_include_merchant_cod]')->checkBox(['label' => 'Include Cash Payment on merchant balance']);
        ?>
        <?php
        
        echo $form->field($model, 'values[admin_commission_type]')->dropDownList([ 'percentage' => Yii::t("basicfield", "Percentage"),
                    'fixed' => Yii::t("basicfield", "Fixed")], ['prompt' =>  'select commission on orders']);
        
        ?>

        <?php
        echo $form->field($model, 'values[admin_commission_percent]')->textInput(
            ['placeholder' => "Admin Commission Percent"
             ])->label("Admin Commission Percent");
        
        ?>

        <?php
        echo $form->field($model, 'values[admin_commission_fixed_val]')->textInput(
            ['placeholder' => "Admin Commission Fixed Value"])->label("Admin Commission Fixed Value");
        ?>
        <?php 
        echo $form->field($model,'values[commission_total_order]')
                ->radioList([Yii::t("basicfield", "Commission on Sub total order"), Yii::t("basicfield", "Commission on Total order")]);
        
         ?>

        <h3><?php echo Yii::t("basicfield", "Invoice") ?></h3>
        <?php
        echo $form->field($model, 'values[admin_vat_no]')->textInput(
            ['placeholder' => "VAT No"])->label("VAT No");
        ?>

        <?php
        echo $form->field($model, 'values[admin_vat_percent]')->textInput(
            ['placeholder' => "VAT"])->label("VAT");
        
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>