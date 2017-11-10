<div class="box box-primary"><?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'admin-user-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
        <?= CHtml::hiddenField('id', $model->admin_id) ?>
        <?php echo $form->textFieldGroup($model, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->textFieldGroup($model, 'first_name', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->textFieldGroup($model, 'last_name', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->textFieldGroup($model, 'email_address', array('class' => 'span5', 'maxlength' => 255)); ?>

        <?php echo $form->passwordFieldGroup($model, 'new_password', array('class' => 'span5', 'maxlength' => 100)); ?>

        <?php echo $form->passwordFieldGroup($model, 'new_password_repeat', array('class' => 'span5', 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxGroup($model, 'is_active'); ?>

        <?php echo $form->textFieldGroup($model, 'date_created', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'date_modified', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'last_login', array('class' => 'span5', 'widgetOptions' => [
            'htmlOptions' => ['disabled' => true]
        ])); ?>

        <?php echo $form->textFieldGroup($model, 'ip_address', array('class' => 'span5', 'widgetOptions' => [
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
