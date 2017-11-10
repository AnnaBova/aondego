<?php
/**
 * Класс WebUser
 */
class WebUser extends CWebUser
{
	/**
	 * Модель
	 * @var User
	 */
	private $_model = null;

	/**
	 * Вернуть имя пользователя
	 * @return string|null
	 */
	public function getUserName()
	{
		if ($user = $this->loadModel()) { return $user->name;}
		return null;
	}
	
	/**
	 * Вернуть имейл пользователя
	 * @return string|null
	 */
	public function getEmail()
	{
		if ($user = $this->loadModel()) { return $user->email;}
		return null;
	}
	
	/**
	 * Получить айди группы
	 * @return integer
	 */
	public function getGroupId()
	{
		$result = 0;
		if ($user = $this->loadModel()) { $result = $user->group_id;}
		return $result;
	}
	
    /**
	 * Получить модель текущего пользователя
	 * @return User
	 */
	public function getModel() 
	{ 
		if (empty($this->_model)) { $this->loadModel();}
		return $this->_model;
	}
	
	/**
	 * Загрузить модель
	 * @return ACmsUser
	 */
	protected function loadModel()
	{
		if (!$this->isGuest && $this->_model === null) {
			$this->_model = AdminUser::model()->findByPk($this->id);
		}
		return $this->_model;
	}
	
	/**
	 * Узнать, активирован ли залогиненный пользователь
	 * @return boolean
	 */
	public function isActive()
	{
		$model = $this->loadModel();
		return $model->getActive();
	}
	
	/**
	 * Получить роль пользователя
	 * @return string
	 */
	public function getRole()
	{
		$activeGroup = GroupHelper::GROUP_GUEST;
		
		//если пользователь залогиненный, то он, как минимум в группе user
		$user = $this->getModel();
		if (!empty($user)) {
			
			//получаем номер базовой группы
			$baseId = $user->Group->base_id;
			$primaryGroups = GroupHelper::getPrimaryGroupsData();
			if (isset($primaryGroups[$baseId])) {
				$activeGroup = $primaryGroups[$baseId]['alias'];
			}
		}
		return $activeGroup;
	}

    public function afterLogin($fromCookie)
    {
        if (parent::beforeLogout()) {
            $user = Yii::app()->user->loadModel();
            $user->last_login = date('Y-m-d H:i:s');
            $user->ip_address = Yii::app()->request->userHostAddress;
            $user->saveAttributes(array('last_login','ip_address'));
            return true;
        } else {
            return false;
        }
    }

    /**
	 * Enter description here...
	 * @param unknown_type $operation
	 * @param unknown_type $params
	 * @param unknown_type $allowCaching
	 * @return unknown
	 */
	public function checkAccess($operation,$params=array(),$allowCaching=true)
	{
		return $this->getRole() === $operation;
	}
	
}
?>