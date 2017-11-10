<?php
$this->breadcrumbs = array(
    Yii::t('default','Order Statuses') => array('index'),
    Yii::t('default','Manage'),
);
?>


<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Order Statuses')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'order-status-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'stats_id',
                'description',
                'date_created',
                'date_modified',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
