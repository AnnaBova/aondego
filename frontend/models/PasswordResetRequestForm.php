<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email_address;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email_address', 'trim'],
            ['email_address', 'required'],
            ['email_address', 'email'],
            ['email_address', 'exist',
                'targetClass' => '\frontend\models\Client',
                'filter' => ['status' => Client::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Client
                ::findOne([
            'status' => Client::STATUS_ACTIVE,
            'email_address' => $this->email_address,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!Client::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        
        $mail = \frontend\components\EmailManager::passwordResetRequest($user);
        
        if($mail){
            return true;
        }

//        return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
//                ['user' => $user]
//            )
//            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($this->email)
//            ->setSubject('Password reset for ' . Yii::$app->name)
//            ->send();
    }
}
