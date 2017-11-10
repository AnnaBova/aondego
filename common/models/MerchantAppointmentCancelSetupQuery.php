<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MerchantAppointmentCancelSetup]].
 *
 * @see MerchantAppointmentCancelSetup
 */
class MerchantAppointmentCancelSetupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MerchantAppointmentCancelSetup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MerchantAppointmentCancelSetup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
