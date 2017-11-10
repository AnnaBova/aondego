<?php
namespace common\extensions;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:21
 */
class OneManyBehavior extends Behavior
{

    public $fields = [];
    public $relation = null;
    public $relationModel = null;
    public $oneManyField = 'oneMany';
    public $validationErrors = [];
    public $parent_column_name;
    private $modelsForSave = [];
    
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            //BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    /**
     * @param CModelEvent $event
     */
    public function beforeValidate($event)
    {
        
        $mods = [];
        
        $explode = explode("\\", $this->relationModel);
        
        $modelName = $this->relationModel;
        
        if(is_array($explode)){
            $modelName = $explode[sizeof($explode) - 1];
        }
        
        
        
        if (isset($_POST[$modelName])) {
            
            
            $this->owner->{$this->oneManyField} = $_POST[$modelName];
            if ($this->owner->{$this->oneManyField}) {

                foreach ($this->owner->{$this->oneManyField} as $attrs) {
                    if (isset($attrs['id'])) {
                        //$model = call_user_func(array($this->relationModel, 'model'))->findByPk($attrs['id']);
                        
                        $name = $this->relationModel;
                        $model = $name::findOne($attrs['id']);
                    } else {
                        $model = new  $this->relationModel;
                    }
                    $model->attributes = $attrs;
                    $mods[] = $model;
                    if ($model->validate()) {
                        $this->modelsForSave[] = $model;
                    } else {
                        $this->owner->addError($this->oneManyField, 'Validation error');
                        $this->validationErrors[] = $model->getErrors();
                    }

                }
            }
        }

        $this->owner->{$this->oneManyField} = $mods;
    }


    public function afterSave($event)
    {
        $ids = [];


        foreach ($this->modelsForSave as $model) {
            $model->{$this->parent_column_name} = $this->owner->getPrimaryKey();
            $model->save();
            
            $ids[] = $model->id;
        }
        
       

//        $criteria = new CDbCriteria();
//        $criteria->addCondition($this->parent_column_name . ' = ' . $this->owner->getPrimaryKey());
//        $criteria->addNotInCondition('id', $ids);

        $oldIds = \yii\helpers\ArrayHelper::map($this->owner->{$this->relation}, 'id', 'id');
        $oldIds = array_diff($oldIds, $ids);

        //$criteria->addInCondition('id', $oldIds);
        
        $condition =  "$this->parent_column_name = ". $this->owner->getPrimaryKey();
        if(!empty($ids)){
            $condition .= " and id NOT IN (".implode(',', $ids).")";
        }
        
        if(!empty($oldIds)){
            $condition .= " and id IN (".implode(',', $oldIds).")";
        }
        
      

        $model = $this->relationModel;
        $model::deleteAll($condition);

        //call_user_func(array($this->relationModel))->deleteAll($condition);
    }


}