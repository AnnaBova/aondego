<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



?>

<?php 

$this->title = Yii::t('basicfield','Email Settings');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Email Settings'), 'url' =>'#'];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Yii::t('basicfield','Email Settings')?></h1>
<div class="box box-primary">
    
    <?php $form = ActiveForm::begin([
        'id' => 'email-settings-form'
    ]); ?>
    
    <div class="box-body">
        <?php
        $email_provider = AdminHelper::getOptionAdmin('email_provider');
        ?>
        

        <?php 
        
        echo $form->field($model,'values[email_provider]')
                ->radioList([Yii::t("basicfield", "phpmail"), Yii::t("basicfield", "smtp"), 'mandrill'])
                 ->label('email provider');
        
         ?>
        
        
        <?php 
        
        echo $form->field($model, 'values[smtp_host]')->textInput(
            ['placeholder' => Yii::t('basicfield',"SMTP hostt"),
             ])->label("SMTP host");
        
        ?>

        <?php 
        
        echo $form->field($model, 'values[smtp_port]')->textInput(
            ['placeholder' => Yii::t('basicfield',"SMTP port")
             ])->label("SMTP port");
        
        ?>

        <?php 
        
        echo $form->field($model, 'values[smtp_username]')->textInput(
            ['placeholder' => Yii::t('basicfield',"Username")
             ])->label("Username");
        
        ?>


        <?php 
        
        echo $form->field($model, 'values[smtp_password]')->textInput(
            ['placeholder' => Yii::t('basicfield',"Password")
             ])->label("Password");
        
        ?>


        <p><?php echo Yii::t("basicfield", "Note: When using SMTP make sure the port number is open in your server") ?>
            .<br/>
            <?php echo Yii::t("basicfield", "You can ask your hosting to open this for you") ?>.
        </p>


        <h3><?php echo Yii::t("basicfield", "Mandrill API") ?></h3>

        <?php 
        
        echo $form->field($model, 'values[mandrill_api_key]')->textInput(
            ['placeholder' => Yii::t('basicfield',"API KEY")
             ])->label("API KEY");
        
        ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield','Create') : Yii::t('basicfield','Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     <?php ActiveForm::end(); ?>
</div>