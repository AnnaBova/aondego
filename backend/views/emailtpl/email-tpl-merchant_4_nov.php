<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;

$this->title = 'Email Tpl For Merchant';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Email Tpl For Merchant')];
?>
    <h1><?= Yii::t('basicfield','Email Templates For Merchant')?></h1>
<div class="box box-primary">
    
    <?php 
     \backend\components\Translatte::getLanguage($model);
    ?>

<?php

$form = ActiveForm::begin([
        'id' => 'tpl-email-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
?>

    <div class="box-body">

        
        
<h3><?php echo Yii::t('basicfield',"Welcome Message after signing up email template")?></h3>

<?= $form->field($model, 'values[email_tpl_merchant_welcome_message]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>



<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('basicfield',"{website_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{client_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{email_address}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"Activation Email when merchant requests to activate his account email template")?></h3>

    
    <?= $form->field($model, 'values[email_tpl_merchant_activation_merchant_request]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>



<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('basicfield',"{service_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{activation_key}")?></li>
 <li><?php echo Yii::t('basicfield',"{website_title}")?></li>
 <li><?php echo Yii::t('basicfield',"{website_url}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"Forgot password email template")?></h3>
  <?= $form->field($model, 'values[email_tpl_merchant_forgot_password]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('basicfield',"{service_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{website_title}")?></li>
 <li><?php echo Yii::t('basicfield',"{verification_code}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"new appointment message email template")?></h3>
   <?= $form->field($model, 'values[email_tpl_merchant_new_appointment]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{booked_service}")?></li>
    <li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
 <li><?php echo Yii::t('basicfield',"{customer_name}")?></li>
 
 <li><?php echo Yii::t('basicfield',"{startdate}")?></li>
 <li><?php echo Yii::t('basicfield',"{starttime}")?></li>
 <li><?php echo Yii::t('basicfield',"{enddate}")?></li>
 <li><?php echo Yii::t('basicfield',"{endtime}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_id}")?></li>
 <li><?php echo Yii::t('basicfield',"{booked_seats}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_due}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_deposit}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_total}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"appointment has been modified email template")?></h3>
     <?= $form->field($model, 'values[email_tpl_merchant_appointment_modified]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{booked_service}")?></li>
    <li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
 <li><?php echo Yii::t('basicfield',"{customer_name}")?></li>
 
 <li><?php echo Yii::t('basicfield',"{startdate}")?></li>
 <li><?php echo Yii::t('basicfield',"{starttime}")?></li>
 <li><?php echo Yii::t('basicfield',"{enddate}")?></li>
 <li><?php echo Yii::t('basicfield',"{endtime}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_id}")?></li>
 <li><?php echo Yii::t('basicfield',"{booked_seats}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_due}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_deposit}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_total}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"appointment has been canceled email template")?></h3>
        <?= $form->field($model, 'values[email_tpl_merchant_appointment_cancelled]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{booked_service}")?></li>
    <li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
 <li><?php echo Yii::t('basicfield',"{customer_name}")?></li>
 
 <li><?php echo Yii::t('basicfield',"{startdate}")?></li>
 <li><?php echo Yii::t('basicfield',"{starttime}")?></li>
 <li><?php echo Yii::t('basicfield',"{enddate}")?></li>
 <li><?php echo Yii::t('basicfield',"{endtime}")?></li>
 <li><?php echo Yii::t('basicfield',"{booking_id}")?></li>
 <li><?php echo Yii::t('basicfield',"{cancellation_id}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"email templates for customers")?></h3>
    
          <?= $form->field($model, 'values[email_tpl_merchant_reminder_email]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>  


<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    
    <li><?php echo Yii::t('basicfield',"{website_title}")?></li>
 <li><?php echo Yii::t('basicfield',"{reminder}")?></li>
 
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"birthday email email template")?></h3>

    <?= $form->field($model, 'values[email_tpl_merchant_birthday_email]')->widget(
        TinyMce::className(),
        [
            'fileManager' => [
                'class' => TinyMceElFinder::className(),
                'connectorRoute' => 'emailtpl/connector',
            ],
            'settings' => [
                'plugins' => array(
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "template paste textcolor fullpage"
                    ),
                ]
        ]
    )->label(false);
    ?>
    

<p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
 <li><?php echo Yii::t('basicfield',"{website_title}")?></li>
 <li><?php echo Yii::t('basicfield',"{birthday}")?></li>
</ul>

</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield','Create') : Yii::t('basicfield','Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
    </div>