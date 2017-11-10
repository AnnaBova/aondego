<?php
namespace common\models;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe;

        private $_user;
    public $role = 1;


	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return [
			// username and password are required
			[['username', 'password'], 'required'],
			// rememberMe needs to be a boolean
			[['rememberMe', 'role'], 'boolean'],
			// password needs to be authenticated
			['password', 'validatePassword'],
		];
	}

	/**
	 * Declares attribute labels.
	 */
	public function validatePassword($attribute, $params)
        {

            if (!$this->hasErrors()) {
                $user = $this->getUser();

                if (!$user || !$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Incorrect email or password.');
                }
            }
        }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \backend\models\AdminUser::findByUsername($this->username);
        }
        

        return $this->_user;
    }
}
