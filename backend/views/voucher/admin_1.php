<?php
$this->breadcrumbs = array(
    Yii::t('default','Voucher') => array('index'),
    Yii::t('default','Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Voucher')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'voucher-new-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'voucher_id',
                //'voucher_owner',
                //'merchant_id',
                //'joining_merchant',
                'voucher_name',
                'voucher_type',
                /*
                'amount',
                'expiration',
                'status',
                'date_created',
                'date_modified',
                'ip_address',
                'used_once',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
