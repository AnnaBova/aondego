<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceSubcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    
    <?php if(Yii::$app->controller->action->id == 'update'){
     \backend\components\Translatte::getLanguage($model);
    }?>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    
    <div class="box-body">
        
        <?= Html::img($model->behaviors['imageBehavior']->getImageUrl()) ?>
        <?php echo $form->field($model, 'image')->fileInput(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(yii\helpers\ArrayHelper::map(common\models\ServiceCategory::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php  echo $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [

            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);?>

    <?= $form->field($model, 'is_active')->checkBox() ?>

    

    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'date_updated')->textInput(['readonly' => true]) ?>

    

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
