<?php

namespace frontend\controllers;

use Yii;
use frontend\models\MtCustomPage;
use frontend\models\mtCustomPageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MtCustomPageController implements the CRUD actions for MtCustomPage model.
 */
class MtCustomPageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($event)
    {
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }

    /**
     * Lists all MtCustomPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new mtCustomPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MtCustomPage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($slug)
    {
        
        $language = \common\models\Language::findOne(['code' => Yii::$app->language]);
        
        $model = MtCustomPage::findOne(['slug_name'=> $slug, 'language_id' => $language->id]);
        
        if(count($model) == 0){
            $model = MtCustomPage::findOne(['slug_name'=> $slug]);
        }
        
        
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('custompage',$model->meta_description)
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('custompage',$model->meta_keywords)
        ]);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MtCustomPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MtCustomPage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MtCustomPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MtCustomPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MtCustomPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MtCustomPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MtCustomPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
