<?php
namespace common\models;
use Yii;
use CActiveDataProvider;
use CDbCriteria;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{option}}".
 *
 * The followings are the available columns in table '{{option}}':
 * @property integer $id
 * @property integer $merchant_id
 * @property string $option_name
 * @property string $option_value
 */
class Option extends ActiveRecord
{
    public $values = [];

    public static function getValByName($name)
    {
        $model = self::findOne(['option_name' => $name]);
        if ($model)
            return $model->option_value;
        else
            return '';

    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'mt_option';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['option_name', 'required', 'on' => 'settings'],
            ['merchant_id', 'integer'],
            ['option_name', 'string', 'max' => 255],
            [['values', 'option_value', 'language_code'], 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'merchant_id' => Yii::t('basicfield', 'Merchant'),
            'option_name' => Yii::t('basicfield', 'option name'),
            'values[customer_ask_address]' => Yii::t('basicfield', 'Disabled popup asking customer address'),
            'values[merchant_changeorder_sms]' => Yii::t("basicfield", "Disabled send sms/email after change order"),
            'values[website_disabled_guest_checkout]' => Yii::t("basicfield", "Disabled Guest Checkout"),
            'values[admin_activated_menu]' => Yii::t("basicfield", "Default Menu"),
            'values[disabled_cart_sticky]' => Yii::t("basicfield", "Disabled Sticky Cart"),
            'values[website_enabled_map_address]' => Yii::t("basicfield", "Enabled Map Address"),
            'values[disabled_featured_merchant]' => Yii::t("basicfield", "Disabled"),
            'values[disabled_subscription]' => Yii::t("basicfield", "Disabled"),
            'values[merchant_disabled_registration]' => Yii::t("basicfield", "Disabled Registration"),
            'values[merchant_email_verification]' => Yii::t("basicfield", "Disabled Verification"),
            'values[merchant_payment_enabled]' => Yii::t("basicfield", "Enabled Payment"),
            'values[admin_enabled_paypal]' => Yii::t("basicfield", "Disabled Paypal"),
            'values[admin_enabled_card]' => Yii::t("basicfield", "Disabled Card Payment"),
            'values[admin_exclude_cod_balance]' => Yii::t("basicfield", "Exclude All Offline Payment from admin balance"),
            'values[admin_commission_enabled]' => Yii::t("basicfield", "Enabled Commission"),
            'values[admin_disabled_membership]' => Yii::t("basicfield", "Disabled Membership"),
            'values[admin_include_merchant_cod]' => Yii::t("basicfield", "Include Cash Payment on merchant balance"),
            'values[commission_total_order]' => Yii::t("basicfield", "Set commission on"),
            'values[email_provider]' => Yii::t("basicfield", "email provider"),
            'values[contact_map]' => Yii::t("basicfield", "Display Google Map"),
            'values[social_flag]' => Yii::t("basicfield", "Disabled Social Icon"),
            'values[admin_merchant_share]' => Yii::t("basicfield", "Disabled restaurant share"),
            'values[fb_flag]' => Yii::t("basicfield", "Disabled Facebook Login"),
            'values[google_login_enabled]' => Yii::t("basicfield", "Enabled Google Login"),
            'values[admin_paypal_mode]' => Yii::t("basicfield", "Mode"),
            'option_value' => Yii::t('basicfield', 'Option Value'),
            'values[admin_commission_type]' => Yii::t('basicfield', 'Admin Commission Type'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('merchant_id', $this->merchant_id);
        $criteria->compare('option_name', $this->option_name, true);
        $criteria->compare('option_value', $this->option_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            if ($this->values) {
                foreach ($this->values as $key => $val) {
                    $model = self::find()->where(['option_name' => $key, 'language_code'=> $this->language_code])->one();
		    
                    if (empty($model)) $model = new self;
                    $model->scenario = 'settings';
                    $model->option_name = $key;
                    $model->option_value = $val;
                    $model->language_code = $this->language_code;
                    
                    
                    $model->save();
                    
                   
                }

                return false;
            }
            return true;
        } else
            return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your ActiveRecord descendants!
     * @param string $className active record class name.
     * @return Option the static model class
     */
   
}
