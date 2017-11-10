<?php

class YiiTController extends AdminController
{


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = YiiT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = null)
    {
        if($id)
         $model =  YiiT::model()->findByPk($id);
        else{
            $model = YiiT::model()->findByAttributes(['translate_de'=>'']);
            if($model)
            $this->redirect(['create','id'=>$model->id]);
            else
                $this->redirect(['index']);
        }

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['YiiT'])) {
            $model->attributes = $_POST['YiiT'];
            if ($model->save()){
                $model = YiiT::model()->findByAttributes(['translate_de'=>'']);
                if($model)
                    $this->redirect(['create','id'=>$model->id]);
                else
                    $this->redirect(['index']);
            }

        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['YiiT'])) {
            $model->attributes = $_POST['YiiT'];
            if ($model->save())
                $this->redirect(['index']);
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new YiiT('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['YiiT']))
            $model->attributes = $_GET['YiiT'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'yii-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
