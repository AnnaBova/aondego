<!-- SubHeader =============================================== -->
<?php 
use yii\widgets\ActiveForm;


?>
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
    	<div id="sub_content">
    	 <h1>Verification</h1>
         
         <p></p>
        </div><!-- End sub_content -->
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield', 'Home')?></a></li>
                <li><?php echo Yii::t('basicfield', 'Verification');?></li>
                
            </ul>
        </div>
    </div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    
    <div class="box_style_2" id="order_process">

                    <h2 class="inner">
                        <?php echo Yii::t('basicfield', 'We have sent verification code to your email address');?></h1>
                        <div class="box-grey rounded">	     	     	    
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


                                <div class="section-label">
                                    <a class="section-label-a">
                                        <span class="bold">
                                            <?php echo Yii::t('basicfield', 'Please enter you verification code');?>
                                        </span>
                                        <b></b>
                                    </a>     
                                </div>    


                                <?= $form->field($client, 'activation_key')->textInput(['autofocus' => true])->label(false) ?>
                                <input type="submit" value="<?php echo Yii::t('basicfield', 'Submit');?>" class="green-button inline">		  


                           <?php ActiveForm::end(); ?>

<!--                            <p class="text-small text-center block">
                                Did not receive your verification code? 
                                <a href="javascript:;" class="resend-email-code">Click here to resend</a>
                            </p>-->

                        </div> <!--box-grey-->
                </div>
  
    
</div>	
