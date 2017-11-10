<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 11-Feb-16
 * Time: 16:36
 */
class ImageBehavior extends CActiveRecordBehavior
{
    public $imagePath = '';
    const UPLOAD_DIR = '/frontend/www/upload/';
    const UPLOAD_PATH =  '/upload/';
    public $imageField = 'image';
    private  $_prefix = null;
    
    //public $project = 'appointment-portal';

    private function getPrefix(){
        if(is_null($this->_prefix)){
            $this->_prefix = str_replace(['admin.','merchant.'],'',Yii::app()->request->hostInfo);
        }
        return $this->_prefix;
    }

    public function getImagePath(){
        

      return self::UPLOAD_DIR.$this->imagePath.DIRECTORY_SEPARATOR.$this->owner->getPrimaryKey().'.jpg?lastmod='.time();
    }

    public function getImageUrl(){
        if(!$this->owner->isNewRecord && file_exists($this->getBaseImagePath()))
            return $this->getImagePath();
        else
            return $this->getPrefix().self::UPLOAD_DIR.'empty.jpg';

    }

    private function getBaseImagePath(){

        return    Yii::getPathOfAlias('site').self::UPLOAD_DIR.$this->imagePath.'/'.$this->owner->getPrimaryKey().'.jpg';
    }

    public function beforeValidate($event){

        $this->owner->{$this->imageField} = CUploadedFile::getInstance($this->owner, $this->imageField);

    }


    public function afterSave($event){
        if ($this->owner->{$this->imageField}){
            if(file_exists($this->getBaseImagePath())){
                
                //echo $this->getBaseImagePath();
                chmod($this->getBaseImagePath(), 777);
                $unlink = unlink($this->getBaseImagePath());
//                
//                if($unlink){
//                    echo 'deleted';
//                }else{
//                    echo 'not deleted';
//                }
//                exit;
                
            }
            
            $this->owner->{$this->imageField}->saveAs($this->getBaseImagePath());
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