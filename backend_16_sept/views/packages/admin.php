<?php
$this->breadcrumbs = array(
    Yii::t('default','Packages') => array('index'),
    Yii::t('default','Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Packages')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'packages-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'package_id',
                'title',
                //'description',
                'price',
                'promo_price',
                'expiration',
                // 'post_limit',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),
                'sequence',
                'workers_limit',
                /*
                'expiration_type',
                'unlimited_post',
                'post_limit',
                'sequence',
                'status',
                'date_created',
                'date_modified',
                'ip_address',
                'sell_limit',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>