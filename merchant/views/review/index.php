<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
$this->context->menu = false;
?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?= Yii::t('basicfield','Reviews')?></h1>
    </div>
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
            'pjax' => true,
            'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,

                    'id'=>'w0',


                ],
            ],

                'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",

                'pager' => [
                    'class' => \liyunfang\pager\LinkPager::className(),

                    'prevPageLabel' => '<<',   // Set the label for the "previous" page button
                    'nextPageLabel' => '>>',   // Set the label for the "next" page button
                    'firstPageLabel'=>'First',   // Set the label for the "first" page button
                    'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                    'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                    'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                    'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                    'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                    'maxButtonCount'=>10,
                    'template' => '{pageButtons}  {pageSize}',
                    //'pageSizeList' => [10, 20, 30, 50],
//                    'pageSizeMargin' => 'margin-left:5px;margin-right:5px;',
                    'pageSizeOptions' => ['class' => 'form-control box-alignment','style' =>  Yii::$app->params['pageSizeStyle']],
//                    'customPageWidth' => 50,
//                    'customPageBefore' => ' Jump to ',
//                    'customPageAfter' => ' Page ',
//                    'customPageMargin' => 'margin-left:5px;margin-right:5px;',
                    //'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;'],
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            'review:ntext',
            'rating',


            array(
                'attribute' => 'status',
                'filter' => array('1' => 'Yes', '0' => 'No'),
                'value' => function($model){
                    return $model->status ? "Yes" : "No" ;
                }
            ),
            // 'ip_address',
            // 'order_id',
            // 'name',
            // 'email:email',
            // 'food_review',
            // 'price_review',
            // 'punctuality_review',
            // 'courtesy_review',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', '#', [
                            'title' => Yii::t('yii', 'Update'),
                            'data-id'=> $model["id"],
                            'data-body'=> $model["review"],
                            'data-name'=> $model["name"],
                            'class'=>"showreviewAnswer"
                        ]);
                    },
                    'comments' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', '#', [
                            'title' => Yii::t('yii', 'Update'),
                            'data-id'=> $model["id"],
                            'data-body'=> $model["review"],
                            'data-name'=> $model["name"],
                            'class'=>"showreviewAnswer"
                        ]);
                    }
                ]],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'comments' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>', '#', [
                            'title' => Yii::t('yii', 'Update'),
                            'data-id'=> $model["id"],
                            'data-body'=> $model["review"],
                            'data-name'=> $model["name"],
                            'class'=>"showreviewAnswer"
                        ]);
                    }
                ]],
        ],
    ]);
    ?>

</div>
    <div class="modal fade" id="reviewAnswer" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="margin-top: 25%;">
            <div class="modal-content modal-popup">
                <div class='modal-header'>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class='modal-title'>
                        <strong id="reviewClientName">Order status</strong>
                    </h4>
                </div>
                <!-- / modal-header -->
                <div class='modal-body'>
                                <h4><i id="reviewText" style="max-height: 500px; overflow-y: scroll;"></i></h4>
                    <hr>
                                <textarea  rows="10" name="answerBody" data-id="<?php echo $status->stats_id ?>" style="width: 100%;"></textarea>
                                <input type="hidden" id="reviewModalId">
                </div>
                <div class='modal-footer'>
                    <div class="checkbox pull-right">
                        <label>
                            <button type="button" class="btn btn-default" id="saveAnswer">Save</button>
                        </label>
                    </div>
                    <!--/ checkbox -->
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJs('
    $("#w0").on("click",".showreviewAnswer", function (event) {
        var body = $(this).attr("data-body");
        var reviewId = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var modal = $("#reviewAnswer");
        modal.find("#reviewText").text(body);
        modal.find("#reviewClientName").text(name);
        modal.find("#reviewModalId").val(reviewId);
        modal.modal("show");
    });
     $("#reviewAnswer").on("hidden.bs.modal", function (e) {
        $(this).find("#reviewText").text("");
        $(this).find("#reviewClientName").text("");
        $(this).find("[name=\'answerBody\']").val("");
    })
    
    $("#saveAnswer").click(function(event){
         var modal = $("#reviewAnswer");
       var reviewId = modal.find("#reviewModalId").val();
       var body = modal.find("[name=\'answerBody\']").val();
         $.ajax({
                    type : "get",
                    url : "' . Yii::$app->urlManager->createUrl('comment/comment-review') . '",
                    data : {reviewId : reviewId, body: body},
                    success : function(response){
                        response = JSON.parse(response);
                        var resp = response;
						if( resp.status == 200 ){
						    modal.modal("hide");
						}else{
						console.log(response);
						}
					},
                    error: function(err) {
                        console.log(err);
                    }
                });
        modal.modal("show");
        console.log("sdf");
    });
');