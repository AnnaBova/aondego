<?php

namespace frontend\controllers;

use Yii;
use frontend\models\MtAddressBook;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressBookController implements the CRUD actions for MtAddressBook model.
 */
class AddressBookController extends Controller
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

    /**
     * Lists all MtAddressBook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MtAddressBook::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MtAddressBook model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MtAddressBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        
        if(Yii::$app->request->isAjax){
            
            
            $model = new MtAddressBook();
	    
            
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }elseif(isset ($_POST['MtAddressBook']['id'])){
                $id = $_POST['MtAddressBook']['id'];
            }

            if(isset($_GET['id']) || isset($_POST['MtAddressBook']['id'])){
                
                $model = MtAddressBook::findOne($id);
            }
            
            
            if($model->load(Yii::$app->request->post())){
		    
		    
                $model->client_id = Yii::$app->user->id;
                $model->ip_address = Yii::$app->getRequest()->getUserIP();
                if($model->validate()){

                    
                    if($model->save()){

                        $dataProvider = new ActiveDataProvider([
                            'query' => MtAddressBook::find()->where(['client_id' => Yii::$app->user->id]),
                        ]);

                        $data = $this->renderAjax('index', ['dataProvider' => $dataProvider]);
                        echo \yii\helpers\Json::encode(['success' => true, 'data' => $data]);
                        Yii::$app->end();
                    }


                }else{

                    echo \yii\helpers\Json::encode(['success' => false, 'data' => $model->getErrors()]);
                    Yii::$app->end();
                }
            
                Yii::$app->end();
            }else{
                return $this->renderAjax('update', [
                'model' => $model,
            ]);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MtAddressBook model.
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
     * Deletes an existing MtAddressBook model.
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
     * Finds the MtAddressBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MtAddressBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MtAddressBook::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
