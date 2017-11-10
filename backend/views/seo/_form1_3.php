<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Seo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    
    <?php 
    
    $disable = false;
    
    if(Yii::$app->controller->action->id == 'update'){
        \backend\components\Translatte::getLanguage($model);
        $disable = true;
    }
    ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        
         
         <?= $form->field($model, 'type')->dropDownList($model::$type, ['disabled' => $disable]) ;?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_keyword')->textarea(['rows' => 6]) ?>

    

    <?= $form->field($model, 'created_at')->textInput(['readonly'=> true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['readonly'=> true]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield', 'Create') : Yii::t('basicfield', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
