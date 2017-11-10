<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Seo';
$this->params['breadcrumbs'][] = ['label' => Yii::t('apps','Seo')];
?>
    <h1><?= Yii::t('default','Seo')?></h1>
<div class="box box-primary">
<?php


$form = ActiveForm::begin([
        'id' => 'seo-settings-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
?>
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

echo $form->field($model, 'values[seo_home]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");


?>
<?php

echo $form->field($model, 'values[seo_home_meta]')->textInput(
            ['placeholder' => "Meta Description"])->label("Meta Description");

?>
<?php
echo $form->field($model, 'values[seo_home_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");


?>


    <h3><?php echo Yii::t("default", "Search Page") ?></h3>
<?php

echo $form->field($model, 'values[seo_search]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");

?>
<?php


echo $form->field($model, 'values[seo_search_meta]')->textInput(
            ['placeholder' => "Meta Descriptio"])->label("Meta Descriptio");


?>
<?php


echo $form->field($model, 'values[seo_search_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");

?>

    <h3><?php echo Yii::t("default", "Menu Page") ?></h3>

<?php


echo $form->field($model, 'values[seo_menu]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");


?>
<?php


echo $form->field($model, 'values[seo_menu_meta]')->textInput(
            ['placeholder' => "Meta Description"])->label("Meta Description");

?>
<?php


echo $form->field($model, 'values[seo_menu_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");

?>


    <h3><?php echo Yii::t("default", "Checkout Page") ?></h3>

<?php



echo $form->field($model, 'values[seo_checkout]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");

?>
<?php



echo $form->field($model, 'values[seo_checkout_meta]')->textInput(
            ['placeholder' => "Meta Description"])->label("Meta Description");

?>
<?php


echo $form->field($model, 'values[seo_checkout_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");


?>


    <h3><?php echo Yii::t("default", "Contact Page") ?></h3>

<?php



echo $form->field($model, 'values[seo_contact]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");

?>
<?php


echo $form->field($model, 'values[seo_contact_meta]')->textInput(
            ['placeholder' => "Meta Description"])->label("Meta Description");


?>
<?php



echo $form->field($model, 'values[seo_contact_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");


?>



    <h3><?php echo Yii::t("default", "Merchant Signup Page") ?></h3>

<?php




echo $form->field($model, 'values[seo_merchantsignup]')->textInput(
            ['placeholder' => "SEO Title"])->label("SEO Title");

?>
<?php


echo $form->field($model, 'values[seo_merchantsignup_meta]')->textInput(
            ['placeholder' => "Meta Description"])->label("Meta Description");


?>
<?php
echo $form->field($model, 'values[seo_merchantsignup_keywords]')->textInput(
            ['placeholder' => "Meta Keywords"])->label("Meta Keywords");

?>
</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
    </div>