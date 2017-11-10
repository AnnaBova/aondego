

<?php
/* @var $this MenusController */
/* @var $dataProvider CActiveDataProvider */
use yii\helpers\Html;
use kartik\grid\GridView;
?>




<?php echo GridView::Widget( array(
	'id'=>'menus-grid',
	'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export'=>false,
//	'type'=>'striped bordered condensed', 
	'columns'=>array(
		'name',
		'size',
		'create_time',

                ['class' => 'yii\grid\SerialColumn'],
		array(
                     'attribute' => 'Manage database backup files',
             
		)

	),
)); ?>
