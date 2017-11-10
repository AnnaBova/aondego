<?php

namespace frontend\controllers;

use frontend\components\ImageBehavior;
use frontend\models\Client;
use frontend\models\ClientLoyalityPoints;
use frontend\models\MtAddressBook;
use frontend\models\Order;
use yii\imagine\Image;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
    
    
    public function actionUploadImage(){
        
        if(Yii::$app->request->isAjax){
            
            $model = Client::findOne(Yii::$app->user->id);
            
            
            $upload = UploadedFile::getInstance($model, 'image');
            
            
            
            
            if($model->validate()){
                $model->image = $upload;
                $imagePath = \Yii::getAlias('@webroot').'/upload/'.$model::UPLOAD_DIR.'/'.$model->id.'.jpg';
                
                $imagePathThumb = \Yii::getAlias('@webroot').'/upload/'.$model::UPLOAD_DIR.'/thumb/'.$model->id.'.jpg';
                
                
                
                
                if($model->image->saveAs($imagePath)){
                    
                    
                    
                    Image::thumbnail($imagePath, 120, 120)
                        ->save(Yii::getAlias($imagePathThumb), ['quality' => 80]);
                    
                    $image = ImageBehavior::getImage($model->id, 'client/thumb');
                    echo json_encode(['success' => true, 'image' => $image]);
                    Yii::$app->end();
                }else{
                    echo json_encode(['success' => false]);
                    Yii::$app->end();
                }
                
            }else{
                echo json_encode($model->getErrors);
                
            }
            
        }else{
            echo 'i mahere';exit;
        }
        
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Client::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();
        $model->scenario = 'register';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
            
            if($model->save()){
                $email = \frontend\components\EmailManager::customerAccountActivate($model);
                $result = ['success'=>true, 'redirect'=>Yii::$app->urlManager->createUrl('client/verification')];
                Yii::$app->response->format = trim(Response::FORMAT_JSON);
                return $result;
                
            }else{
                
                $error = ActiveForm::validate($model);
                Yii::$app->response->format = trim(Response::FORMAT_JSON);
                return $error; 
            
            }
            return $this->redirect(['view', 'id' => $model->client_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionVerification(){
        $client = new Client;
        $client->scenario = 'activation';
        
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    
                    $this->redirect(['site/login']);
                    
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        
        return $this->render('verification', [
            'client' => $client
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->client_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
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
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDashboard(){
        $model = $this->findModel(Yii::$app->user->id);
	
	$addressBook = MtAddressBook::findOne(['client_id' => $model->id, 'as_default' => 1]);
	
	if(count($addressBook) == 0){
		$addressBook = new MtAddressBook;
		$addressBook->client_id = $model->id;
		$addressBook->first_name = $model->first_name;
		$addressBook->last_name = $model->last_name;
		$addressBook->street = $model->street;
		$addressBook->city = $model->city;
		$addressBook->state = $model->state;
		$addressBook->zipcode = $model->zipcode;
		$addressBook->country_code = $model->country_code;
		$addressBook->as_default  = 1;
		$addressBook->save(false);
		
	}
        
        
        $dataProviderOrder = new ActiveDataProvider([
            'query' => Order::find()
                ->where(['client_id' => Yii::$app->user->id,
		    'is_service_gift' => 0])
                //->andWhere(['!=', 'status', '2'])
                ,
        ]);
        
        $dataProviderLoyality = new ActiveDataProvider([
            'query' => ClientLoyalityPoints::find()->where(['client_id' => Yii::$app->user->id]),
        ]);
        
        
        $dataProviderAddress = new ActiveDataProvider([
            'query' => MtAddressBook::find()->where(['client_id' => Yii::$app->user->id]),
        ]);
	
	$dataProviderVoucher = new ActiveDataProvider([
            'query' => Order::find()
                ->where(['client_id' => Yii::$app->user->id, 
		    'is_service_gift' => 1])
                //->andWhere(['!=', 'status', '2'])
                ,
        ]);

        
        
        if($model->load(Yii::$app->request->post())){
            $model->newpassword = $_POST['Client']['newpassword'];
            $model->confirm_password = $_POST['Client']['confirm_password'];
            
            
            
            if($model->validate()){
                if(!empty($model->newpassword)){

                    if(trim($model->newpassword) != trim($model->confirm_password)){
                        
                        
                        $model->addError('confirm_password', 'New Password and Confirm Passord must be same.');
                    }else{
                        $model->password = $model->newpassword;
                        $model->setPassword($model->newpassword);
                        $model->newpassword = "";
                        $model->confirm_password = "";
                    }

                }
                
                $model->save(false);
                Yii::$app->session->setFlash('success', "Profile updated successfully");
            
            }
            
            
            
            
        }
        return $this->render('dashboard', [
            'model' => $model, 
            'dataProviderOrder' => $dataProviderOrder,
            'dataProviderLoyality' => $dataProviderLoyality,
            'dataProviderAddress' => $dataProviderAddress,
	    'dataProviderVoucher' => $dataProviderVoucher
        ]);
    }
}
