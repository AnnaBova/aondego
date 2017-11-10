<?php
$this->breadcrumbs = array(
    Yii::t('default','Admin Users') => array('index'),
    Yii::t('default','Manage'),
);

?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Admin Users')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'admin-user-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'admin_id',
                'username',
                'email_address',
                'first_name',
                'last_name',
                'date_created',
                'last_login',
                /*
                'date_created',
                'date_modified',
                'ip_address',
                'user_lang',
                'email_address',
                'lost_password_code',
                'session_token',
                'last_login',
                'user_access',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>