<?php
namespace frontend\components;

use Yii;

class ClientNotificationFilter
{
	public static function check(int $user_id, int $notification_action_id) : bool
	{
		$sql = "SELECT notifications_action_id from mt_client_notifications_action where $user_id";
		$idsNotifications = Yii::$app->db->createCommand($sql)->queryAll();
		if ($idsNotifications) {
			$idsNotifications = array_column($idsNotifications, 'notifications_action_id');
		}
		if (!in_array($notification_action_id, $idsNotifications)) {
			return true;
		}
		return false;
	}
}