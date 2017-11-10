<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtReview */
/* @var $form yii\widgets\ActiveForm */
?>




    <?php $form = ActiveForm::begin([
        'id'=>'review',
        'options' => [
            'class' => 'popup-form'
            ]
    ]); ?>
    
    <div class="login_icon"><i class="icon_comment_alt"></i></div>

    
    


    <?php //$form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'merchant_id')->hiddenInput(['maxlength' => true, 'value'=>$merchant->id])->label(false) ?>

    
    <div class="row" >
                    <div class="col-md-6">
                        <?= $form->field($model, 'name',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Name')])->label(false) ?>	
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Email')])->label(false) ?>
                    </div>
    </div>
    <!--rating-->
    
    <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'food_review',['template' => '{input}{error}',
                             'options' => [
                            'tag'=>false
                                 ]])->dropDownList(\frontend\models\MtReview::getRating(),['class'=>'form-control form-white','prompt'=>Yii::t('basicfield','Peris')])?>                            
                           
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'price_review',['template' => '{input}{error}',
                             'options' => [
                            'tag'=>false
                                 ]])->dropDownList(\frontend\models\MtReview::getRating(),['class'=>'form-control form-white','prompt'=>Yii::t('basicfield','Ambiente')])?>                            
                           
                    </div>
                </div>
    <div class="row">
        <div class="col-md-6">
                        <?= $form->field($model, 'punctuality_review',['template' => '{input}{error}',
                             'options' => [
                            'tag'=>false
                                 ]])->dropDownList(\frontend\models\MtReview::getRating(),['class'=>'form-control form-white','prompt'=>Yii::t('basicfield','Mitarbeiter')])?>           
                            
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'courtesy_review',['template' => '{input}{error}',
                             'options' => [
                            'tag'=>false
                                 ]])->dropDownList(\frontend\models\MtReview::getRating(),['class'=>'form-control form-white','prompt'=>Yii::t('basicfield','Sauberkeit')])?>           
                          
                    </div>
                    
    </div>               
                            
        
     
   
 
  <div class ="row">
        <div class="col-md-12">
                        <?= $form->field($model, 'review',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white','placeholder'=>Yii::t('basicfield','Review')])->label(false) ?>	
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
             <input type="text" id="verify_review" class="form-control form-white" placeholder="<?php echo Yii::t('basicfield','Are you human? 3 + 1 =');?>">
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield','Create') : Yii::t('basicfield','Update'), ['class' => $model->isNewRecord ? 'btn btn-success save-review' : 'btn btn-primary save-review', 'id'=>'review']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php
$this->registerJs("
$('.save-review').on('click',function(){
$('body .help-block').remove();
                $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('mt-review/create')."',
                    data : $('#review').serialize(),
                    dataType : 'json',
                    success : function(response){
                        if(response.success == true){
                            $('#extras').modal('hide');
                            $('#orders').html(response.data);
                            $('#subtotal').html(response.subtotal);
                            $('#total').html(response.total);
                        
                        }else{
                            $.each(response.data, function(key, val) {
                                console.log(key);
                                $('#mtreview-'+key).after('<div class=\"help-block\">'+val+'</div>');
                                $('#mtreview-'+key).closest('.form-group').addClass('has-error');
                            });
                        }
                        
                        
                    
                    }
                })
              })
");
?>