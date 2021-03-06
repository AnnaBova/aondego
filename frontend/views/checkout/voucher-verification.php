<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">

        <?php echo $this->render('sub_header', ['type' => 'voucher']) ?>

    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield', 'Home');?></a></li>
            <li><?php echo Yii::t('basicfield', 'Verification');?></li>
            
        </ul>
    </div>
</div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div id="container_pin">
        <div class="row">
            <div class="col-md-3">

                <div class="box_style_2 hidden-xs info">
                    <h2 class="inner"><?php echo Yii::t('basicfield', 'Login');?></h2>


                    <?php //echo $this->render('left_bar')  ?>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($login, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($login, 'password')->passwordInput() ?>



                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('basicfield', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div><!-- End col-md-3 -->

            <div class="col-md-5">
                <div class="box_style_2" id="order_process">

                    <h2 class="inner"><?php echo Yii::t('basicfield', 'We have sent verification code to your email address');?></h1>
                        <div class="box-grey rounded">	     	     	    
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


                                <div class="section-label">
                                    <a class="section-label-a">
                                        <span class="bold">
                                            <?php echo Yii::t('basicfield', 'Please enter you verification code');?></span>
                                        <b></b>
                                    </a>     
                                </div>    


                                <?= $form->field($client, 'activation_key')->textInput(['autofocus' => true])->label(false) ?>
                                <input type="submit" value="<?php echo Yii::t('basicfield', 'Submit');?>" class="green-button inline">		  


                           <?php ActiveForm::end(); ?>


                        </div> <!--box-grey-->
                </div>

            </div><!-- End col-md-6 -->

            <div class="col-md-4">
                <div id="cart_box">
                    <?php echo $this->render('voucher_right_bar'); ?>
<!--                    <a class="btn_full" href="javascript:void(0)" id="checkout">
                        <?php echo Yii::t('basicfield', 'Go to checkout');?>
                    </a>-->
                    
                </div>
            </div><!-- End col-md-3 -->

        </div><!-- End row -->
    </div><!-- End container pin -->
</div><!-- End container -->
<!-- End Content =============================================== -->
