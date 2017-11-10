<?php

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:21
 */
class OneManyBehavior extends CActiveRecordBehavior
{

    public $fields = [];
    public $relation = null;
    public $relationModel = null;
    public $oneManyField = 'oneMany';
    public $validationErrors = [];
    public $parent_column_name;
    private $modelsForSave = [];

    /**
     * @param CModelEvent $event
     */
    public function beforeValidate($event)
    {
        $mods = [];
        if (isset($_POST[$this->relationModel])) {
            $this->owner->{$this->oneManyField} = $_POST[$this->relationModel];
            if ($this->owner->{$this->oneManyField}) {

                foreach ($this->owner->{$this->oneManyField} as $attrs) {
                    if (isset($attrs['id'])) {
                        $model = call_user_func(array($this->relationModel, 'model'))->findByPk($attrs['id']);

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

        $criteria = new CDbCriteria();
        $criteria->addCondition($this->parent_column_name . ' = ' . $this->owner->getPrimaryKey());
        $criteria->addNotInCondition('id', $ids);

        $oldIds = CHtml::listData($this->owner->{$this->relation}, 'id', 'id');
        $oldIds = array_diff($oldIds, $ids);

        $criteria->addInCondition('id', $oldIds);


        call_user_func(array($this->relationModel, 'model'))->deleteAll($criteria);
    }


}