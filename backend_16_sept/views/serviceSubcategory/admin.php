<?php
$this->breadcrumbs = array(
    Yii::t('default','Service Subcategories') => array('index'),
    Yii::t('default','Manage'),
);

?>



<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Service Subcategories')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'service-subcategory-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                array(
                    'name' => 'category_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'title'),
                    'value' => '$data->category->title',
                ),
                'title',


                array(
                    'name' => 'is_active',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->is_active ? "Yes" : "No" ',
                ),

                /*
                'approved_text',
                'date_created',
                'date_updated',
                'merchant_id',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>