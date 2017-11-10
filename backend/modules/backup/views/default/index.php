<?php
use yii\helpers\Html;
use kartik\grid\GridView;

echo GridView::Widget([//'bootstrap.widgets.TbBox', 
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export'=>false,
        'columns' => [
            'name',
		'size',
		'create_time',
//         [ 'header' => 'Action',
//                            'class' => 'yii\grid\ActionColumn',
//                            'headerOptions' => ['width' => '105'],
//                           'template' => '{Download}',
//                            //'template' => '{Download}',
//                            'buttons' => [
//                                
//                                
//                                'Download' => function ($name) {
//                                    
//                                            return Html::a('Download', Yii::$app->urlManager->createUrl('backup/default/download'), ['style' => 'margin-left: 10px;']);
//                                        
//                                   
//                                },
//                                
//                                    ],
//                                ],
           
]]);
 
?>

<?php $this->render('_list', array(
		'dataProvider'=>$dataProvider,
));
?>
