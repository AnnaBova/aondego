<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use demogorgorn\ajax\AjaxSubmitButton;
?>

<div class="box box-primary">
    
    <?php 
    if(Yii::$app->controller->action->id == 'update'){
     \backend\components\Translatte::getLanguage($model);
    }
    ?>
    
    <?php

    
    $form = ActiveForm::begin([
        'id' => 'service-category-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
        <?= Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['style' => 'width:150px;']) ?>
        <?php echo $form->field($model, 'image')->fileInput(); ?>

        <?php echo $form->field($model, 'title')->textInput(); ?>
        <?php  echo $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]);?>
        


        <?php echo $form->field($model, 'is_active')->checkBox(); ?>



        <?php echo $form->field($model, 'date_created')->textInput(['readonly'=>true]); ?>

        <?php echo $form->field($model, 'date_updated')->textInput(['readonly'=>true]); ?>
        <?php echo $form->field($model, 'url')->textInput(); ?>
        
        <?php echo $form->field($model, 'seo_title')->textInput(); ?>

        <?php echo $form->field($model, 'seo_description')->textInput(); ?>

        <?php echo $form->field($model, 'seo_keywords')->textInput(); ?>
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
        'url' => Yii::$app->urlManager->createUrl(['service-category/update','id'=>$model->id, 'language'=>$_GET['language']]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#service-category-form")[0])'),
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
