<?php
$this->breadcrumbs = array(
    Yii::t('default','Clients') => array('index'),
    Yii::t('default','Manage'),
);

?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Clients')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'client-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'client_id',
                //'social_strategy',
                'first_name',
                'last_name',
                'email_address',
                'city',
                'last_login',
                'date_created',
                //'password',
                /*
                'street',
                'city',
                'state',
                'zipcode',
                'country_code',
                'location_name',
                'contact_phone',
                'lost_password_token',
                'date_created',
                'date_modified',
                'last_login',
                'ip_address',
                'status',
                'token',
                'mobile_verification_code',
                'mobile_verification_date',
                'custom_field1',
                'custom_field2',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>