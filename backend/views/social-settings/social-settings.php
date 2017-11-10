<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php 


$this->title = 'Social Setting';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Social Settings')];
?>
<h1><?= Yii::t('basicfield','Social Settings')?></h1>
<div class="box box-primary">
    <?php
    
    
    $form = ActiveForm::begin([
        'id' => 'social-settings-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    
    ?>
    <div class="box-body">
        <?php
        
        echo $form->field($model, 'values[default_share_text]')->textArea(
            ['placeholder' => "Default Share text"])->label("Default Share text");
        
        
        
        ?>

        <p><?php echo Yii::t('basicfield', "Available tags {merchant-name}") ?></p>
        <?php
        echo $form->field($model, 'values[social_flag]')->checkBox(['label' => 'Disabled Social Icon']);
        ?>

        <?php
        echo $form->field($model, 'values[admin_merchant_share]')->checkBox(['label' => 'Disabled restaurant share']);
        ?>

        <h2><?php echo Yii::t('basicfield', "Facebook") ?></h2>
        <?php
        echo $form->field($model, 'values[fb_flag]')->checkBox(['label' => 'Disabled Facebook Login']);
        ?>
        <?php
        
        echo $form->field($model, 'values[fb_app_id]')->textInput(
            ['placeholder' => "App ID"])->label("App ID");
        
        
        ?>

        <?php
        
        echo $form->field($model, 'values[fb_app_secret]')->textInput(
            ['placeholder' => "App Secret"])->label("App Secret");
        
        
        ?>

        <?php 
        
        echo $form->field($model, 'values[admin_fb_page]')->textInput(
            ['placeholder' => "Facebook Page URL"])->label("Facebook Page URL");
        
        
        ?>

        <h2><?php echo Yii::t('basicfield', "Pinterest") ?></h2>

        <?php
        
        echo $form->field($model, 'values[admin_pinterest_page]')->textInput(
            ['placeholder' => "pinterest Page URL"])->label("pinterest Page URL");
        
        
        ?>

        <h2><?php echo Yii::t('basicfield', "Instagramm") ?></h2>

        <?php
        
        echo $form->field($model, 'values[admin_instagramm_page]')->textInput(
            ['placeholder' => "instagramm Page URL"])->label("instagramm Page URL");
        
        
        ?>


        <h2><?php echo Yii::t('basicfield', "Twitter") ?></h2>

        <?php
        
        echo $form->field($model, 'values[admin_twitter_page]')->textInput(
            ['placeholder' => "Twitter Page URL"])->label("Twitter Page URL");
        
        
        ?>

        <h2><?php echo Yii::t('basicfield', "Google") ?></h2>
        <?php
        
        echo $form->field($model, 'values[admin_google_page]')->textInput(
            ['placeholder' => "Google Page URL"])->label("Google Page URL");
        
        
        ?>
        <?php
        echo $form->field($model, 'values[google_login_enabled]')->checkBox(['label' => 'Enabled Google Login']);
        ?>
        <?php
        
        echo $form->field($model, 'values[google_client_id]')->textInput(
            ['placeholder' => "Client ID"])->label("Client ID");
        
        ?>
        <?php
        echo $form->field($model, 'values[google_client_secret]')->textInput(
            ['placeholder' => "Client Secret"])->label("Client Secret");
        

        ?>

        <?php
        
        echo $form->field($model, 'values[google_client_redirect_ulr]')->textInput(
            ['placeholder' => "Redirect Url"])->label("Redirect Url");
        
        
        ?>

        <p class="uk-text-muted uk-text-small">
            <?php echo Yii::t('basicfield', "Redirect URL Must equal to") . " " . Yii::$app->urlManager->getBaseUrl(true) . "/store/GoogleLogin" ?>
            <br>
            <?php echo Yii::t('basicfield', "Set this url to your google developer settings") ?>
        </p>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     <?php ActiveForm::end(); ?>
</div>