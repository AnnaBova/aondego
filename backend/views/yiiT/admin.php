<?php
$this->breadcrumbs = array(
    Yii::t('default','Manage language') => array('index'),
    Yii::t('default','Manage'),
);

?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Language')?></h1>
    </div>
    <div class="box-body">

        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'yii-t-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'value_en',
                'translate_de',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>