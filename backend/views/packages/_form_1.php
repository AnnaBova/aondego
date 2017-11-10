<div class="box box-primary"><?php
    Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget');
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'packages-form',
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
        <?php echo $form->textFieldGroup($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>
        <?php echo $form->label($model, 'description'); ?>
        <?php $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $model,
            'attribute' => 'description',
        )); ?>
        <?php //echo $form->textAreaGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

        <?php echo $form->textFieldGroup($model, 'price', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'promo_price', array('class' => 'span5')); ?>

        <?php echo $form->dropDownListGroup($model, 'expiration_type'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => Packages::getTypes(),
                    'htmlOptions' => array('prompt' => 'select category'),
                )
            )
        ); ?>

        <?php echo $form->textFieldGroup($model, 'expiration', array('class' => 'span5')); ?>

        <?php echo $form->dropDownListGroup($model, 'unlimited_post'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => Packages::getLimits(),
                    'htmlOptions' => array('prompt' => 'select category'),
                )
            )
        ); ?>

        <?php echo $form->textFieldGroup($model, 'post_limit', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'sequence', array('class' => 'span5')); ?>
        <?php echo $form->textFieldGroup($model, 'workers_limit', array('class' => 'span5')); ?>

        <?php echo $form->checkBoxGroup($model, 'status'); ?>

        <?php echo $form->textFieldGroup($model, 'sell_limit', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'date_created', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'date_modified', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->checkBoxGroup($model, 'is_commission'); ?>

        <?php echo $form->dropDownListGroup($model, 'commission_type'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => [1 => 'General settings commission', 2 => 'Fixed', 3 => 'Percentage'],
                    'htmlOptions' => array('prompt' => 'Select type'),
                )
            )); ?>
        <?php echo $form->textFieldGroup($model, 'percent_commission', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'fixed_commission', array('class' => 'span5')); ?>
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
