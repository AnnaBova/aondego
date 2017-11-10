<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace backend\modules\models;

use \yii\base\Model;

class Backuptest extends Model {
    
	protected static function getPath()
	{
		if ( isset ($this->module->path )) $this->_path = $this->module->path;
		else $this->_path = Yii::$app->basePath .'/../_backup/';
		
		if ( !file_exists($this->_path ))
		{
			mkdir($this->_path );
			chmod($this->_path, '777');
		}
		return $this->_path;
	}
	public static function execSqlFile($sqlFile)
	{
		$message = "ok";

		if ( file_exists($sqlFile))
		{
			$sqlArray = file_get_contents($sqlFile);

			$cmd = Yii::$app->db->createCommand($sqlArray);
			try	{
				$cmd->execute();
			}
			catch(CDbException $e)
			{
				$message = $e->getMessage();
			}

		}
		return $message;
	}
	public static function getColumns($tableName)
	{
		$sql = 'SHOW CREATE TABLE '.$tableName;
		$cmd = Yii::$app->db->createCommand($sql);
		$table = $cmd->queryRow();

		$create_query = $table['Create Table'] . ';';

		$create_query  = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
		//$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
                $file_name = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 

		$fp = fopen( $file_name, 'a');
		if ( $fp)
		{
			self::writeComment('TABLE '. addslashes ($tableName) );
			$final = 'DROP TABLE IF EXISTS ' .addslashes($tableName) . ';'.PHP_EOL. $create_query .PHP_EOL.PHP_EOL;
			
                        fwrite ( $fp, $final );
		}
		else
		{
			$tables[$tableName]['create'] = $create_query;
			return $create_query;
		}
	}

	public static function getData($tableName)
	{
		$sql = 'SELECT * FROM '.$tableName;
		$cmd = Yii::$app->db->createCommand($sql);
		$dataReader = $cmd->query();

		$data_string = '';
                $file_name =  dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 

		$fp = fopen( $file_name, 'a');

		foreach($dataReader as $data)
		{
			$itemNames = array_keys($data);
			$itemNames = array_map("addslashes", $itemNames);
			$items = join('`,`', $itemNames);
			$itemValues = array_values($data);
			$itemValues = array_map("addslashes", $itemValues);
			$valueString = join("','", $itemValues);
			$valueString = "('" . $valueString . "'),";
			$values ="\n" . $valueString;
			if ($values != "")
			{
				$data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";" . PHP_EOL;
			}
		}

		if ( $data_string == '')
		return null;
			
		if ( $fp)
		{
			self::writeComment('TABLE DATA '.$tableName);
			$final = $data_string.PHP_EOL.PHP_EOL.PHP_EOL;
			fwrite ( $fp, $final );
		}
		else
		{
			$tables[$tableName]['data'] = $data_string;
			return $data_string;
		}
	}
	public static function getTables($dbName = null)
	{
		$sql = 'SHOW TABLES';
		$cmd = Yii::$app->db->createCommand($sql);
		$tables = $cmd->queryColumn();
		return $tables;
	}
	public static function StartBackup($addcheck = true)
	{
                $file_name = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 
                $fp = fopen( $file_name, 'w+');
                if ( $fp == null )
		return false;
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		if ( $addcheck )
		{
			fwrite ( $fp,  'SET AUTOCOMMIT=0;' .PHP_EOL );
			fwrite ( $fp,  'START TRANSACTION;' .PHP_EOL );
			fwrite ( $fp,  'SET SQL_QUOTE_SHOW_CREATE = 1;'  .PHP_EOL );
		}
		fwrite ( $fp, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;'.PHP_EOL );
		fwrite ( $fp, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;'.PHP_EOL );
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		self::writeComment('START BACKUP');
                return true;
	}
	public static function EndBackup($addcheck = true)
	{
                
                $file_name =  dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 
                $fp = fopen( $file_name, 'a');
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		fwrite ( $fp, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;'.PHP_EOL );
		fwrite ( $fp, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;'.PHP_EOL );

		if ( $addcheck )
		{
			fwrite ( $fp,  'COMMIT;' .PHP_EOL );
		}
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		self::writeComment('END BACKUP');
		fclose($fp);
		$fp = null;
	}
		
	public static function writeComment($string)
	{
                $file_name = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 
                $fp = fopen( $file_name, 'a');
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		fwrite ( $fp, '-- '.$string .PHP_EOL );
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
	}
        
        protected static function updateMenuItems($model = null)
	{
		// create static model if model is null
		if ( $model == null ) $model=new UploadForm('install');

		switch($this->action->id)
		{
			case 'restore':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'View Site') , 'url'=>Yii::$app->HomeUrl);
				}
			case 'create':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'List Backups') , 'url'=>array('index'));
				}
				break;
			case 'upload':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'Create Backup') , 'url'=>array('create'));
				}
				break;
			default:
				{
					$this->menu[] = array('label'=>Yii::t('app', 'List Backups') , 'url'=>array('index'));
					$this->menu[] = array('label'=>Yii::t('app', 'Create Backup') , 'url'=>array('create'));
					$this->menu[] = array('label'=>Yii::t('app', 'Upload Backup') , 'url'=>array('upload'));
					$this->menu[] = array('label'=>Yii::t('app', 'Restore Backup') , 'url'=>array('restore'));
					$this->menu[] = array('label'=>Yii::t('app', 'Clean Database') , 'url'=>array('clean'));
					$this->menu[] = array('label'=>Yii::t('app', 'View Site') , 'url'=>Yii::$app->HomeUrl);
				}
				break;
		}
	}
        
        public static function Createbackup(){
           Yii::import('application.extensions.phpmailer.*');
                $tables = self::getTables();
		self::StartBackup();
                foreach($tables as $tableName)
		{
                    self::getColumns($tableName);
                }
		foreach($tables as $tableName)
		{
			self::getData($tableName);
		}
		self::EndBackup();
            $path = dirname(Yii::$app->basePath).'/backup/'.date('Y-m-d') . '.backup.sql';
            $name = date('Y-m-d') . '.backup.sql';
            $site_settings = DatabaseEmailSetting::model()->findByPk(1);
            $mailer = new JPhpMailer();
            $mailer->IsSMTP();
            $mailer->IsHTML();t;
            $mailer->Host=$site_settings->smtp_host;
            $mailer->SMTPAuth=true;
            $mailer->Port=		$site_settings->smtp_port;
            //$mailer->SMTPSecure=  $site_settings->smtpsecure;
            $mailer->Username = 	$site_settings->smtp_username;
            $mailer->Password = 	$site_settings->smtp_password;
            /*****************************************************/
            $subject = 'Database Backup';
            $message  = 'Databse Backup '. date('Y-m-d');
            $mailer->AddAddress($site_settings->email_to);
            $mailer->SetFrom($site_settings->email_from,$site_settings->email_from);
            $mailer->Subject=$subject;
            $mailer->MsgHTML($message);
            $mailer->AddAttachment($path,$name);
            if($mailer->Send())
                return true;
            
        }
}

?>