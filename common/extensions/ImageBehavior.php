<?php

namespace common\extensions;

use CUploadedFile;
use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 11-Feb-16
 * Time: 16:36
 */
class ImageBehavior extends Behavior
{
    public $imagePath = '';
    const UPLOAD_DIRR = '/upload/';
    const UPLOAD_DIR = '/upload/';
    const UPLOAD_PATH =  '/upload/';
    public $imageField = 'image';
    private  $_prefix = null;
    
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }
    
    //public $project = 'appointment-portal';

    private function getPrefix(){
        if(is_null($this->_prefix)){
            $this->_prefix = str_replace(['admin.','merchant.'],'',Yii::$app->request->hostInfo);
        }
        return $this->_prefix;
    }

    public function getImagePath(){
        

      return self::UPLOAD_DIR.$this->imagePath.DIRECTORY_SEPARATOR.$this->owner->getPrimaryKey().'.jpg?lastmod='.time();
    }

    public function getImageUrl(){
//		echo $this->getBaseImagePath();
//		exit;
        if(!$this->owner->isNewRecord && file_exists($this->getBaseImagePath()))
            return $this->getImagePath();
        else
            return $this->getPrefix().self::UPLOAD_DIR.'empty.jpg';

    }

    private function getBaseImagePath(){
        
        return    \Yii::$app->basePath.'/..'.self::UPLOAD_DIRR.$this->imagePath.'/'.$this->owner->getPrimaryKey().'.jpg';
    }

    public function beforeValidate($event){

        $this->owner->{$this->imageField} = \yii\web\UploadedFile::getInstance($this->owner, $this->imageField);
	
//	if($this->imageField == 'image_big'){
//		echo 'i here';
//	echo $this->imageField;
//	print_r($this->owner->{$this->imageField});
//	
//	exit;
//	}
	

    }


    public function afterSave($event){
        if ($this->owner->{$this->imageField}){
            if(file_exists($this->getBaseImagePath())){
                
                //echo $this->getBaseImagePath();
                //chmod($this->getBaseImagePath(), 777);
                $unlink = unlink($this->getBaseImagePath());

                
            }
	    
            
            $upload = $this->owner->{$this->imageField}->saveAs($this->getBaseImagePath());
	    
//	    if($this->imageField == 'image_big'){
//		    echo $upload;
//	    echo $this->getBaseImagePath();
//	    exit;
//	    }
        }
        
        
    }
    
    

    public function afterDelete($event){
        if(file_exists($this->getBaseImagePath()))
        $this->deleteImage();
    }

    public function deleteImage(){
        unlink($this->getBaseImagePath());
    }
}