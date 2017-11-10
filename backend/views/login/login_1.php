<div class="login_wrap">
<div class="login_logo"></div>
    <div class="row">
<div class="col-centered">

   <?php $name=AdminHelper::getOptionAdmin('website_title');?>
   <h3 class="uk-h3"><?php echo !empty($name)?$name:"";?> <?php echo Yii::t("default","Administration")?></h3>
    <?php

    $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>true,
        'htmlOptions'=>['class'=>"uk-form forms"]
    )); ?>
  <!-- <form id="forms" class="uk-form forms" onsubmit="return false;" method="POST">   -->

        <?php echo $form->textFieldGroup($model,'username'); ?>

        <?php echo $form->passwordFieldGroup($model,'password'); ?>

        <?php echo $form->checkBoxGroup($model,'rememberMe'); ?>

   
   <?php if (AdminHelper::getOptionAdmin('captcha_admin_login')==2):?>
   <?php GoogleCaptcha::displayCaptcha()?>
   <?php endif;?>

   <?php
   $this->widget(
       'booster.widgets.TbButton',
       array('buttonType' => 'submit', 'label' => 'Login')
   );
   ?>
   
   <p><a href="javascript:;" class="mt-fp-link"><?php echo Yii::t("default","Forgot Password")?>?</a></p>
    <?php $this->endWidget(); unset($form); ?>
   
   
    <form id="mt-frm" class="uk-form mt-frm" onsubmit="return false;" method="POST">   
   <?php echo CHtml::hiddenField("action",'adminForgotPass')?>
   <h4><?php echo Yii::t("default","Forgot Password")?></h4>
   
   <div class="uk-form-row">
      <div class="uk-form-icon uk-width-1">
        <i class="uk-icon-envelope"></i>
       <?php echo CHtml::textField('email_address','',array('class'=>"uk-width-1",'placeholder'=>Yii::t("default","Email address"),
       'data-validation'=>"required"
       ));?>
      </div>
   </div>   
      
   <div class="uk-form-row">   
   <button class="uk-button uk-width-1"><?php echo Yii::t("default","Submit")?> <i class="uk-icon-chevron-circle-right"></i></button>
   </div>
   
   <p><a href="javascript:;" class="mt-login-link"><?php echo Yii::t("default","Login")?></a></p>
   
   </form>
   
</div>
</div> <!--END login_wrap-->
</div>