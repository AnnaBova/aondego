<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;
?>

<?php 


$this->title = 'Email Tpl For Admin';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Email Tpl For Admin')];
?>
    <h1><?= Yii::t('basicfield','Email Templates For Admin')?></h1>
<div class="box box-primary">

<?php

$form = ActiveForm::begin([
        'id' => 'tpl-email-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
?>

    <div class="box-body">
<?php 

?>
        
        
<h3><?php echo Yii::t('basicfield',"New Merchant registration email template")?></h3>

<?php echo $form->field($model, 'values[email_tpl_sub_admin_new_merchant]')->label('Subject');?>

<?= $form->field($model, 'values[email_tpl_admin_new_merchant]')->widget(
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
    <h3><?php echo Yii::t('basicfield',"activation request of merchant email template")?></h3>
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_activation_merchant]')->label('Subject');?>

    <?= $form->field($model, 'values[email_tpl_admin_activation_merchant]')->widget(
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
    <h3><?php echo Yii::t('basicfield',"membership expires email template")?></h3>
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_membership_expires]')->label('Subject');?>

    <?= $form->field($model, 'values[email_tpl_admin_membership_expires]')->widget(
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
 <li><?php echo Yii::t('basicfield',"{expire_date}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"new user registration email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_new_customer_register]')->label('Subject');?>

    <?= $form->field($model, 'values[email_tpl_admin_new_customer_register]')->widget(
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
 <li><?php echo Yii::t('basicfield',"{first_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{last_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{email}")?></li>
</ul>


<hr/>
    <h3><?php echo Yii::t('basicfield',"new appointment email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_new_appointment]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>
    
    <?= $form->field($model, 'values[email_tpl_admin_new_appointment]')->widget(
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
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
    <li><?php echo Yii::t('basicfield',"{merchant_address}")?></li>
    <li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
    <li><?php echo Yii::t('basicfield',"{service_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{service_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{username}")?></li>
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
    
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_appointment_modified]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>

    <?= $form->field($model, 'values[email_tpl_admin_appointment_modified]')->widget(
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
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
    <li><?php echo Yii::t('basicfield',"{merchant_address}")?></li>
    <li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
 <li><?php echo Yii::t('basicfield',"{service_name}")?></li>
 <li><?php echo Yii::t('basicfield',"{username}")?></li>
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
    
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_appointment_cancelled]')->label('Subject');?>
    
    <p style="margin:0;"><?php echo Yii::t('basicfield',"Available Tags")?>:</p>
<ul>
    <li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
</ul>
    
    

    <?= $form->field($model, 'values[email_tpl_admin_appointment_cancelled]')->widget(
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
	<li><?php echo Yii::t('basicfield',"{merchant_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{merchant_address}")?></li>
	<li><?php echo Yii::t('basicfield',"{staff_member}")?></li>
	<li><?php echo Yii::t('basicfield',"{service_name}")?></li>
	<li><?php echo Yii::t('basicfield',"{username}")?></li>
	<li><?php echo Yii::t('basicfield',"{startdate}")?></li>
	<li><?php echo Yii::t('basicfield',"{starttime}")?></li>
	<li><?php echo Yii::t('basicfield',"{enddate}")?></li>
	<li><?php echo Yii::t('basicfield',"{endtime}")?></li>
	<li><?php echo Yii::t('basicfield',"{booking_id}")?></li>
	<li><?php echo Yii::t('basicfield',"{cancellation_id}")?></li>
	<li><?php echo Yii::t('basicfield',"{cancel_reason}")?></li>
</ul>

<hr/>
    <h3><?php echo Yii::t('basicfield',"newsletter template email template")?></h3>
    
    <?php echo $form->field($model, 'values[email_tpl_sub_admin_newsletter]')->label(Yii::t('basicfield', 'Subject'));?>

    <?= $form->field($model, 'values[email_tpl_admin_newsletter]')->widget(
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
 <li><?php echo Yii::t('basicfield',"{email}")?></li>
 
</ul>

</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
    </div>