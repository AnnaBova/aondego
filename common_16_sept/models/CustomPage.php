<?php

/**
 * This is the model class for table "{{custom_page}}".
 *
 * The followings are the available columns in table '{{custom_page}}':
 * @property integer $id
 * @property string $slug_name
 * @property string $page_name
 * @property string $content
 * @property string $seo_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $icons
 * @property string $assign_to
 * @property integer $sequence
 * @property string $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 * @property integer $open_new_tab
 * @property integer $is_custom_link
 */
class CustomPage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{custom_page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_name, seo_title', 'required'),
			array('sequence, open_new_tab, is_custom_link, status', 'numerical', 'integerOnly'=>true),
			array('slug_name, page_name, seo_title, meta_description, meta_keywords, icons', 'length', 'max'=>255),
			array('assign_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug_name, page_name, content, seo_title, meta_description, meta_keywords, icons, assign_to, sequence, status, date_created, date_modified, ip_address, open_new_tab, is_custom_link', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'slug_name' => Yii::t('default','Slug Name'),
			'page_name' => Yii::t('default','Page Name'),
			'content' => Yii::t('default','Content'),
			'seo_title' => Yii::t('default','Seo Title'),
			'meta_description' => Yii::t('default','Meta Description'),
			'meta_keywords' => Yii::t('default','Meta Keywords'),
			'icons' => Yii::t('default','Icons'),
			'assign_to' => Yii::t('default','Assign To'),
			'sequence' => Yii::t('default','Sequence'),
			'status' => Yii::t('default','Is Active'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Modified'),
			'open_new_tab' => Yii::t('default','Open New Tab'),
			'is_custom_link' => Yii::t('default','Is Custom Link'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('slug_name',$this->slug_name,true);
		$criteria->compare('page_name',$this->page_name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('icons',$this->icons,true);
		$criteria->compare('assign_to',$this->assign_to,true);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('open_new_tab',$this->open_new_tab);
		$criteria->compare('is_custom_link',$this->is_custom_link);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->assign_to) $this->assign_to = json_encode($this->assign_to);
            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }

    public function afterFind(){
        if($this->assign_to) $this->assign_to = json_decode($this->assign_to);
        parent::afterFind();
    }
}
