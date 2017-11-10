<?php $this->breadcrumbs = array(
    Yii::t('default','Seo'),
);
?>
    <h1><?= Yii::t('default','Seo')?></h1>
<div class="box box-primary">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'seo-settings-form',
    'enableAjaxValidation' => false,
)); ?>
    <div class="box-body">
    <div class="uk-text-muted">
        <ul class="uk-text-muted">
            <?php echo Yii::t("default", "Available Tags") ?>:
            <li><?php echo Yii::t("default", "{website_title}") ?></li>
            <li><?php echo Yii::t("default", "{merchant_name}") ?></li>
        </ul>
    </div>

    <h3><?php echo Yii::t("default", "Home Page") ?></h3>

<?php
echo $form->textFieldGroup($model, 'values[seo_home]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_home_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_home_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
);
?>


    <h3><?php echo Yii::t("default", "Search Page") ?></h3>
<?php
echo $form->textFieldGroup($model, 'values[seo_search]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_search_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_search_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
);
?>

    <h3><?php echo Yii::t("default", "Menu Page") ?></h3>

<?php
echo $form->textFieldGroup($model, 'values[seo_menu]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_menu_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_menu_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
);
?>


    <h3><?php echo Yii::t("default", "Checkout Page") ?></h3>

<?php
echo $form->textFieldGroup($model, 'values[seo_checkout]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_checkout_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_checkout_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
);
?>


    <h3><?php echo Yii::t("default", "Contact Page") ?></h3>

<?php
echo $form->textFieldGroup($model, 'values[seo_contact]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_contact_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_contact_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
);
?>



    <h3><?php echo Yii::t("default", "Merchant Signup Page") ?></h3>

<?php
echo $form->textFieldGroup($model, 'values[seo_merchantsignup]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "SEO Title"))
    ), 'labelOptions' => array('label' => Yii::t('default', "SEO Title"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_merchantsignup_meta]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Description"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Description"))]
);
?>
<?php
echo $form->textFieldGroup($model, 'values[seo_merchantsignup_keywords]',
    ['widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('default', "Meta Keywords"))
    ), 'labelOptions' => array('label' => Yii::t('default', "Meta Keywords"))]
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