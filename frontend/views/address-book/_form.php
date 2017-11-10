<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtAddressBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mt-address-book-form">

    <?php $form = ActiveForm::begin([
        'id' => 'address-form'
    ]); 
    
   
    ?>
    
    <?php echo $form->field($model, 'id')->hiddenInput()
            ->label(false)?>
    
    
    <div class="row bottom10">
	<div class="col-md-6">
            <p class="text-small">First Name</p>
            <?= $form->field($model, 'first_name', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
	
	<div class="col-md-6">
            <p class="text-small">Last Name</p>
            <?= $form->field($model, 'last_name', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
        <div class="col-md-6">
            <p class="text-small">Street</p>
            <?= $form->field($model, 'street', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
        <div class="col-md-6">
            <p class="text-small">City</p>
            <?= $form->field($model, 'city', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
    </div> <!--row-->
    
    
    <div class="row bottom10">
        <div class="col-md-6">
            <p class="text-small">State</p>
            <?= $form->field($model, 'state', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
        <div class="col-md-6">
            <p class="text-small">Zip code</p>
            <?= $form->field($model, 'zipcode', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
    </div> <!--row-->
    
    
    <div class="row bottom10">
<!--        <div class="col-md-6">
            <p class="text-small">Location Name</p>
            <?= $form->field($model, 'location_name', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>-->
        <div class="col-md-6">
            <p class="text-small">Country</p>
            <?= $form->field($model, 'country_code', ['template'=>'{input}{error}', 
                    'options' => [
                    'tag'=>false
                ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
            ->label(false) ?>
        </div>
    </div> <!--row-->

    

<!--    <div class="row bottom10">
        <div class="col-md-6">
            <?= $form->field($model, 'as_default')->checkbox() ?>
        </div>
    </div>-->
    
    
    
  <div class="col-md-2">
  <input value="Submit" class="green-button medium inline" type="button" id="save-address">
  </div>
  <div class="col-md-5">
    <a class="green-text top10 block" href="javascript:void(0)" id="address-back">
	<i class="ion-ios-arrow-thin-left"></i> Back	</a>
  </div>



    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJs("
    ")?>
