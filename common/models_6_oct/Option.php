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
            [['values', 'option_value'], 'safe'],
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
            'merchant_id' => Yii::t('app', 'Merchant'),
            'option_name' => Yii::t('app', 'option name'),
            'values[customer_ask_address]' => Yii::t('app', 'Disabled popup asking customer address'),
            'values[merchant_changeorder_sms]' => Yii::t("app", "Disabled send sms/email after change order"),
            'values[website_disabled_guest_checkout]' => Yii::t("app", "Disabled Guest Checkout"),
            'values[admin_activated_menu]' => Yii::t("app", "Default Menu"),
            'values[disabled_cart_sticky]' => Yii::t("app", "Disabled Sticky Cart"),
            'values[website_enabled_map_address]' => Yii::t("app", "Enabled Map Address"),
            'values[disabled_featured_merchant]' => Yii::t("app", "Disabled"),
            'values[disabled_subscription]' => Yii::t("app", "Disabled"),
            'values[merchant_disabled_registration]' => Yii::t("app", "Disabled Registration"),
            'values[merchant_email_verification]' => Yii::t("app", "Disabled Verification"),
            'values[merchant_payment_enabled]' => Yii::t("app", "Enabled Payment"),
            'values[admin_enabled_paypal]' => Yii::t("app", "Disabled Paypal"),
            'values[admin_enabled_card]' => Yii::t("app", "Disabled Card Payment"),
            'values[admin_exclude_cod_balance]' => Yii::t("app", "Exclude All Offline Payment from admin balance"),
            'values[admin_commission_enabled]' => Yii::t("app", "Enabled Commission"),
            'values[admin_disabled_membership]' => Yii::t("app", "Disabled Membership"),
            'values[admin_include_merchant_cod]' => Yii::t("app", "Include Cash Payment on merchant balance"),
            'values[commission_total_order]' => Yii::t("app", "Set commission on"),
            'values[email_provider]' => Yii::t("app", "email provider"),
            'values[contact_map]' => Yii::t("app", "Display Google Map"),
            'values[social_flag]' => Yii::t("app", "Disabled Social Icon"),
            'values[admin_merchant_share]' => Yii::t("app", "Disabled restaurant share"),
            'values[fb_flag]' => Yii::t("app", "Disabled Facebook Login"),
            'values[google_login_enabled]' => Yii::t("app", "Enabled Google Login"),
            'values[admin_paypal_mode]' => Yii::t("app", "Mode"),
            'option_value' => Yii::t('app', 'Option Value'),
            'values[admin_commission_type]' => Yii::t('app', 'Admin Commission Type'),
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
                    $model = self::find()->where(['option_name' => $key])->one();
                    if (empty($model)) $model = new self;
                    $model->scenario = 'settings';
                    $model->option_name = $key;
                    $model->option_value = $val;
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
