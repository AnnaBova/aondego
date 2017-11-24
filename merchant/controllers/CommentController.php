<?php
namespace merchant\controllers;


use common\models\Comment;
use common\models\Review;

class CommentController extends \merchant\components\MerchantController {

	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'only' => ['create', 'update'],
				'rules' => [
					// allow authenticated users
					[
						'allow' => true,
						'roles' => ['@'],
					],
					// everything else is denied
				],
			],
		];
	}

	public function actionCommentReview($reviewId, $body)
	{
		$modelReview = Review::findOne($reviewId);
		if ( $modelReview ) {
			$model = new Comment();
			$model->merchant_id = \Yii::$app->user->id;
			$model->review_id = intval($reviewId);
			$model->body = $body;
			if ( $model->validate()){
				return json_encode(['status' => $model->save()?200:500]);
			}
		}
		return false;
	}
}