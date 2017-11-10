<?php
$this->breadcrumbs = array(
    Yii::t('default','Merchants') => array('index'),
    Yii::t('default','Manage'),
);
?>


<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Merchants')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'merchant-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'merchant_id',
                'service_name',
                'service_phone',
                'contact_name',
                'contact_phone',
                'membership_expired',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),
                array(
                    'name' => 'is_purchase',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),
                array(
                    'name' => 'is_ready',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),

                /*
                'contact_email',
                'country_code',
                'street',
                'city',
                'state',
                'post_code',
                'cuisine',
                'service',
                'free_delivery',
                'delivery_estimation',
                'username',
                'password',
                'activation_key',
                'activation_token',
                'status',
                'date_created',
                'date_modified',
                'date_activated',
                'last_login',
                'ip_address',
                'package_id',
                'package_price',
                'membership_expired',
                'payment_steps',
                'is_featured',
                'is_ready',
                'is_sponsored',
                'sponsored_expiration',
                'lost_password_code',
                'user_lang',
                'membership_purchase_date',
                'sort_featured',
                'is_commission',
                'percent_commision',
                'abn',
                'session_token',
                'commision_type',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
