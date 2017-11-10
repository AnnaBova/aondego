<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
?>

<div class="box box-primary">
    <?php 


$this->title = 'Contact Setting';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Contact Settings')];
    ?>

   

    <h1><?= Yii::t('basicfield','Contact Settings')?></h1>
    <?php
    
    
    $form = ActiveForm::begin([
        'id' => 'contact-settings-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <div class="box-body">
        <h3><?php echo Yii::t('basicfield', "Client Contact Content") ?></h3>
        
        
        <?php  echo $form->field($model, 'values[contact_content]')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ])->label(false);?>

        <h3><?php echo Yii::t('basicfield', "Merchant Contact Content") ?></h3>
        
        
        <?php  echo $form->field($model, 'values[m_contact_content]')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ])->label(false);?>

        <h2><?php echo Yii::t('basicfield', "Map") ?></h2>
        <?php
        echo $form->field($model, 'values[contact_map]')->checkBox(['label' => 'Display Google Maps']);
        ?>
        <?php
        
        echo $form->field($model, 'values[map_latitude]')->textInput(
            ['placeholder' => "Latitude"])->label("Latitude");
        
        
        ?>
        <?php
        
        echo $form->field($model, 'values[map_longitude]')->textInput(
            ['placeholder' => "Longitude"])->label("Longitude");
        
        ?>

        <?php
        
        echo $form->field($model, 'values[contact_email_receiver]')->textInput(
            ['placeholder' => "Email address"])->label("Send To");
        
        
        ?>

    </div>
    <div class="box-footer">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>