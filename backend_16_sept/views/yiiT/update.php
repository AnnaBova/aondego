<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Manage Language') => array('index'),
    Yii::t('default', 'Update'),
);

?>

    <h1><?= Yii::t('default', 'Update') ?> <?= Yii::t('default', 'Translation') ?> <?php echo $model->value_en; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>