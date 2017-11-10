<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;
use demogorgorn\ajax\AjaxSubmitButton;
/* @var $this yii\web\View */
/* @var $model common\models\CustomPage */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="box box-primary">
    
    <?php 
    if(Yii::$app->controller->action->id == 'update'){
     \backend\components\Translatte::getLanguage($model);
    }
    ?>

    <?php $form = ActiveForm::begin([
        'id' => 'custompage-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box-body">
    

    <?= $form->field($model, 'page_name')->textInput(['maxlength' => true]) ?>
        
    <?= $form->field($model, 'icons')->textInput(['maxlength' => true]) ?>

    
        
    <?php  echo $form->field($model, 'content')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ],
                    'replaceDivs' => false
                ],
            
            ]);?>
        
        <?= $form->field($model, 'sequence')->textInput() ?>
        
        <?= $form->field($model, 'open_new_tab')->checkBox() ?>

    <?= $form->field($model, 'is_custom_link')->checkBox() ?>
        
        <?php echo $form->field($model,'slug_name')->textInput(['readonly' => true]); ?>
        
        <h2>Seo</h2>
        
    
        
    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

     <?php  echo $form->field($model, 'assign_to')->widget(Select2::classname(), [
                'data' => [1=>'For Users',2=>'For Merchants'],
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?> 

    

    

    <?= $form->field($model, 'status')->checkBox() ?>
        
        <?php echo $form->field($model,'date_created')->textInput(['readonly' => true]); ?>

	<?php echo $form->field($model,'date_modified')->textInput(['readonly' => true]);  ?>

    
    </div>
    
    <div class="box-footer">
      <?php
       
        if( Yii::$app->controller->action->id =='create'){?>
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        <?php }else { ?>
            <?php
            
                AjaxSubmitButton::begin([
                    
    'label' => Yii::t('basicfield','Update'),
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => Yii::$app->urlManager->createUrl(['custom-page/update','id'=>$model->id, 'language'=>$_GET['language']]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#custompage-form")[0])'),
        'cache'=> 'false',
                'contentType'=> false,
                'processData'=> false,
        'success' => new \yii\web\JsExpression('function(html){
            $("#w0").yiiGridView("applyFilter");
            
        }'),
    ],
    'options' => [
        'class' => 'btn btn-primary',
        'type' => 'button',
        'id' => 'addButtonFotThis'.'update' 
    ]
]);

AjaxSubmitButton::end();
            }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


