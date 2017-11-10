<div class="box box-primary">
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'voucher-new-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

        <?php // echo $form->textFieldGroup($model,'voucher_owner',array('class'=>'span5','maxlength'=>255)); ?>

        <?php // echo $form->textFieldGroup($model,'merchant_id',array('class'=>'span5')); ?>

        <?php // echo $form->textAreaGroup($model,'joining_merchant',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

        <?php echo $form->textFieldGroup($model, 'voucher_name', array('class' => 'span5', 'maxlength' => 255)); ?>


        <?php
        echo $form->dropDownListGroup($model, 'voucher_type', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'data' => Voucher::getTypes(),
                'htmlOptions' => array('prompt' => 'Select'),
            )
        ));
        ?>
        <?php echo $form->textFieldGroup($model, 'amount', array('class' => 'span5')); ?>

        <?php echo $form->datepickerGroup($model, 'expiration', array('widgetOptions' => array(
            'options' => array(
                'format' => 'yyyy-mm-dd',
            ),
        ),
            'htmlOptions' => array('placeholder' => 'select date'))); ?>
        <?php echo $form->checkBoxGroup($model, 'status'); ?>
        <?php echo $form->label($model, 'joining_merchant'); ?>
        <?php $model->merchant_list = json_decode($model->joining_merchant);
        $this->widget(
            'booster.widgets.TbSelect2',
            array(
                'model' => $model,
                'attribute' => 'merchant_list',
                'data' => CHtml::listData(Merchant::model()->findAll(), 'merchant_id', 'service_name'),
                'options' => array(
                    'placeholder' => 'merchant select',
                    'width' => '40%',
                ),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                ),
            )
        );

        ?>
        <span> leave empty if you want to apply to all merchants</span>
        <?php echo $form->checkBoxGroup($model, 'used_once'); ?>

        <?php echo $form->textFieldGroup($model, 'date_created', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'date_modified', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>
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