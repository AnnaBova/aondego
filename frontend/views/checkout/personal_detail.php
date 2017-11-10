<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box_style_2" id="order_process">


    <h2 class="inner"><?php echo Yii::t('basicfield', 'Please enter your personal details')?></h2>
	<p><?php echo Yii::t('basicfield', "Its the first time you book an appointment? Please fill out the form and register as a new customer.");?></p>
    <?php $form = ActiveForm::begin(['id'=> 'checkout-form']); ?>



    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','First name')]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Last name')]) ?>
    
    <div class="form-group field-client-dob required">
    <label class="control-label" for="client-dob">
		
		<?php echo Yii::t('basicfield', 'Date of Birth')?></label>
            
	<?php echo $form->field($model, 'dob')->textInput(['maxlength'=>"5",'placeholder' => Yii::t('basicfield','dd/mm')])->label(false); ?>
	
    <?php /*echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'dob',
                    'template' => '{input}{addon}',
                    'clientOptions' => [
					'autoclose' => true,
					'changeMonth'=> true,
					'changeYear'=> true,
					'showButtonPanel'=> true,
					'dateFormat' => 'dd MM'

                    ],
                    'options' => [
                        'class' => 'grey-fields full-widthe',
                        'tag'=>false
                    ]
                ]);*/?>
    <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Telephone/Mobile')]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your email')]) ?>

    <?= $form->field($model, 'street')->textInput(['placeholder' => Yii::t('basicfield','Your full address')]) ?>

    <div class="row">
        <div class="col-md-6 col-sm-6">

            <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your postal code')]) ?>

        </div>

        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your city')]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'language_id')->dropDownList(
	yii\helpers\ArrayHelper::map(\common\models\Language::find()->all(), 'id', 'name'),
	['prompt' => Yii::t('basicfield','Select language or country')]) ;?>

    <hr>

    <div class="row">
        <div class="col-md-12">

            <label><?php Yii::t('basicfield','Message to the merchant');?></label>
            <?= $form->field($model, 'business_note')->textarea(['style' => "height:150px", 'placeholder' => Yii::t('basicfield','Special request etc ...')])->label(false); ?>

        </div>
    </div>
	
	<p><?php echo Yii::t('basicfield', "Please note: You will receive an email with an confirmation code, which you need to enter in the next step. Please make sure you check your spam folder if you haven't received an email.")?>
	</p>
				
	<a class="btn_full" href="javascript:void(0)" id="checkout">
	<?php echo Yii::t('basicfield', 'Register and proceed') ?>
		</a>



    <?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerJs('$(document).ready(function() {
            $("#client-dob").keyup(function(ev){
				var key = ev.keyCode || ev.which;

				// this prevents other characters but numeric
				if (key > 31 && (key < 48 || key > 57)) {
					ev.preventDefault();
					$(this).val("")
				}else{
					
					if ($(this).val().length == 2){
						$(this).val($(this).val() + "/");
					}
					
				}
            });
});')

?>
                   



