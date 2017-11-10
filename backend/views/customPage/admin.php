<?php
$this->breadcrumbs = array(
    Yii::t('default','Custom Pages') => array('index'),
    Yii::t('default','Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Custom Pages')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'custom-page-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                //'slug_name',
                'page_name',
                'sequence',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),

                //'content',
                //'seo_title',
                //'meta_description',
                /*
                'meta_keywords',
                'icons',
                'assign_to',
                'sequence',
                'status',
                'date_created',
                'date_modified',
                'ip_address',
                'open_new_tab',
                'is_custom_link',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
