<?php
namespace backend\components;

use Yii;
use yii\helpers\StringHelper;
use \common\models\SourceMessage;
Class Translatte{
    
    public static function loadModel($model, $field, $language){
        
        
        $category = strtolower(StringHelper::basename(get_class($model)));
        foreach ($field as $key=>$value){
            $model->$value = self::getMessage($model,$category,$value,$language);
            
        
        }
        
    }
    
    public static function save($model, $field){
        $category = strtolower(StringHelper::basename(get_class($model)));
        
        if(!empty($field)){
            foreach ($field as $key=>$value){
                if(!empty($model->$value)){
                    $sql  = 'SELECT * from source_message where category="'.$category.'" and category_id='.$model->id.' and category_field="'.$value.'"';
                    $connection = Yii::$app->getDb();
                    $result1 =$connection->createCommand($sql)->queryOne();
                    
                    
                    
                    
                   

                    if($result1){
                        $message = $model->$value;
                        $message = str_replace('"', "''", "$message");
                        $update = 'UPDATE source_message
                            SET message= "'.$message.'"
                            WHERE category="'.$category.'" and category_id='.$model->id.' and category_field="'.$value.'"';
                        $connection = Yii::$app->getDb();
                        $command = $connection->createCommand($update);
                        $command->execute();
                    }else{
                        $srcMessage = new SourceMessage();
                        $srcMessage->category = $category;
                        $srcMessage->message = $model->$value;
                        $srcMessage->category_id = $model->id;
                        $srcMessage->category_field = $value;
                        $srcMessage->save();
                        
                    }


                }
            }
            
            
        }
        return true;
    }
    
    public static function getMessage($model, $catgory, $categoryField, $language){
        
        $sql  = 'SELECT * from source_message where category="'.$catgory.'" and category_id='.$model->id.' and category_field="'.$categoryField.'"';
        $connection = Yii::$app->getDb();
        $result1 =$connection->createCommand($sql)->queryOne();
        
        if($result1){
            $sql  = 'SELECT translation from message where id='.$result1['id'].' and language="'.trim($language).'"';
            $connection = Yii::$app->getDb();
            $result1 =$connection->createCommand($sql)->queryOne();
            if($result1){
                return $result1['translation'];
            }else{
                return "Not Translated";
            }
        }else{
            return "Not Translated";
        }
        
    }
    
    public static function saveMessage($model, $field, $language){
        
        $category = strtolower(StringHelper::basename(get_class($model)));
        
        foreach ($field as $key=>$value){
            if(!empty($model->$value)){
                $sql  = 'SELECT * from source_message where category="'.$category.'" and category_id='.$model->id.' and category_field="'.$value.'"';
                $connection = Yii::$app->getDb();
                $result1 =$connection->createCommand($sql)->queryOne();

                $message = \common\models\Message::findOne(['id'=>$result1['id'],'language'=>trim($language)]);

                if(count($message) !=0 ){
                    $update = 'UPDATE message
                                SET translation= "'.$model->$value.'"
                                WHERE id='.$result1['id'].' and language="'.trim($language).'"';
                    $connection = Yii::$app->getDb();
                    $command = $connection->createCommand($update);
                    $command->execute();

                }else{
                    $message = new \common\models\Message;
                    $message->id = $result1['id'];
                    $message->language = trim($language);
                    $message->translation = $model->$value;
                    $message->save(false);
                }
            }
        }
        
    }
    
    public static function getLanguage($model=null){
        $category = strtolower(StringHelper::basename(get_class($model)));
        
        if($category == 'servicecategory'){
            $category = 'service-category';
        }elseif ($category == 'servicesubcategory') {
            $category = 'service-subcategory';
        }elseif ($category == 'custompage') {
            $category = 'custom-page';
        }elseif ($category == 'seorule') {
            $category = 'seo-rule';
        }
        $language = ['en'=>'English',
                    /*'ar'=>'Arabic',
                    'az'=>'Azeri (Latin)',
                    'bg'=>'Bulgarian',
                    'bs'=>'Bosnian ',
                    'ca'=>'Catalan',
                    'cs'=>'Czech',
                    'da'=>'Danish',
                    'de'=>'German',
                    'el'=>'Greek',
                    'es'=>'Spanish',
                    'et'=>'Estonian',
                    'fa'=>'Farsi',
                    'fi'=>'Finnish',
                    'fr'=>'French',
                    'he'=>'Hebrew',
                    'hu'=>'Hungarian',
                    'id'=>'Indonesian',
                    'it'=>'Italian',*/
                    'ja'=>'Japanese',
                    /*'kk'=>'Kazakh',
                    'ko'=>'Korean',
                    'lt'=>'Lithuanian',
                    'lv'=>'Latvian',
                    'ms'=>'Malay',
                    'nb-NO'=>'Norwegian (Bokm?l) (Norway)',
                    'nl'=>'Dutch',
                    'pl'=>'Polish',
                    'pt'=>'Portuguese',
                    'pt-BR'=>'Portuguese (Brazil)',
                    'ro'=>'Romanian',
                    'ru'=>'Russian',
                    'sk'=>'Slovak',
                    'sl'=>'Slovenian',
                    'sr'=>'Serbian ',
                    'sr-Latn'=>'Serbian (Latin)',
                    'sv'=>'Swedish',
                    'th'=>'Thai',
                    //'tj'=>'',
                    'tr'=>'Turkish',
                    'uk'=>'Ukrainian',
                    'uz'=>'Uzbek (Latin)',
                    'vi'=>'Vietnamese',
                    'zh-CN'=>'Chinese (S)',*/
                    'zh-TW'=>'Chinese (T)'];
        
        $language = \common\models\Language::find()->all();
        echo '<ul class="language">';
        
        
        
        
        $i=1;foreach ($language as $data){
            $class = "";
            if((isset($_GET['language']) && $_GET['language']==$data->code) || (!isset($_GET['language']) && $i==1))
            $class = "lag-active";
            
            echo '<li class="'.$class.'"><a href="'.Yii::$app->urlManager->createUrl([$category.'/update','id'=>$model->id,'language'=>$data->code]).'" >'.$data->name.'</a>';
        $i++;
        
        }
        echo '</ul>';
    }
}

