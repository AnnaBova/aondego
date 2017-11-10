<div class="box box-primary"><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'merchant-form',
	'enableAjaxValidation'=>false,
)); ?>
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Main Info'=>$this->renderPartial('_form1',['model'=>$model, 'form' => $form],true),
        'Additional Info'=>$this->renderPartial('_form2',['model'=>$model, 'form' => $form],true),
        'Seo'=>$this->renderPartial('_form3',['model'=>$model, 'form' => $form],true),
        'Commission info'=>$this->renderPartial('_form5',['model'=>$model, 'form' => $form],true),
        'Username and Passwords'=>$this->renderPartial('_form6',['model'=>$model, 'form' => $form],true),
        'Administration info'=>$this->renderPartial('_form4',['model'=>$model, 'form' => $form],true),

    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>
</div>
<div class="box-footer">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
    </div>
