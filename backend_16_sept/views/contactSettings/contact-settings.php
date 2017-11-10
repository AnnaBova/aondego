<div class="box box-primary"><?php $this->breadcrumbs = array(
        Yii::t('default','Contact Settings'),
    );
    ?>

    <?php Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget'); ?>

    <h1><?= Yii::t('default','Contact Settings')?></h1>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'contact-settings-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="box-body">
        <h3><?php echo Yii::t('default', "Client Contact Content") ?></h3>
        <?php $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $model,
            'attribute' => 'values[contact_content]',
        )); ?>

        <h3><?php echo Yii::t('default', "Merchant Contact Content") ?></h3>
        <?php $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $model,
            'attribute' => 'values[m_contact_content]',
        )); ?>

        <h2><?php echo Yii::t('default', "Map") ?></h2>
        <?php
        echo $form->checkBoxGroup($model, 'values[contact_map]');
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[map_latitude]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Latitude")
            ), 'labelOptions' => array('label' => "Latitude")]
        );
        ?>
        <?php
        echo $form->textFieldGroup($model, 'values[map_longitude]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Longitude")
            ), 'labelOptions' => array('label' => "Longitude")]
        );
        ?>

        <?php
        echo $form->textFieldGroup($model, 'values[contact_email_receiver]',
            ['widgetOptions' => array(
                'htmlOptions' => array('placeholder' => "Email address")
            ), 'labelOptions' => array('label' => "Send To")]
        );
        ?>

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