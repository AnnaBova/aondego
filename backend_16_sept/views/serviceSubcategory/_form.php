<div class="box box-primary"><?php
    Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget');
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'service-subcategory-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
        <?= CHtml::image($model->imageBehavior->getImageUrl(), 'image', ['style' => 'width:150px;']) ?>
        <?php echo $form->fileFieldGroup($model, 'image'); ?>

        <?php echo $form->dropDownListGroup($model, 'category_id'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'title'),
                    'htmlOptions' => array('prompt' => 'select category'),
                )
            )
        ); ?>
        <?php echo $form->textFieldGroup($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>
        <?php echo $form->label($model,'description') ?>
        <?php $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $model,
            'attribute' => 'description',
        )); ?>

        <?php echo $form->checkBoxGroup($model, 'is_active'); ?>

        <?php echo $form->textFieldGroup($model, 'date_created', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'date_updated', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>
        <?php echo $form->textFieldGroup($model, 'url', array('class' => 'span5', 'maxlength' => 255)); ?>
        <?php echo $form->textFieldGroup($model, 'seo_title', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->textFieldGroup($model, 'seo_description', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->textFieldGroup($model, 'seo_keywords', array('class' => 'span5', 'maxlength' => 255)); ?>
    </div>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
