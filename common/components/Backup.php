<?php
namespace common\components;
use Yii;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Backup{
	
	
	public static function getTables($dbName = null)
	{
		$sql = 'SHOW TABLES';
		$cmd = Yii::$app->db->createCommand($sql);
		$tables = $cmd->queryColumn();
		return $tables;
	}
	
	public static function StartBackup($addcheck = true)
	{           
		$filename = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 

		$fp = fopen( $filename, 'w+');

		if ( $fp == null ){
                    
                return false;
                
                }
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
	
	
	public static function getColumns($tableName)
	{   
            $tableName ='`'.$tableName.'`';
		$sql = 'SHOW CREATE TABLE '.$tableName;
		$cmd = Yii::$app->db->createCommand($sql);
		$table = $cmd->queryOne();

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
			$this->tables[$tableName]['create'] = $create_query;
			return $create_query;
		}
	}
	
	
	public static function getData($tableName)
	{
            
		$sql = 'SELECT * FROM '.$tableName;
		$cmd = Yii::$app->db->createCommand($sql);
		$dataReader = $cmd->query();
		
		$file_name =  dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 

		$fp = fopen( $file_name, 'a');

		$data_string = '';

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
			$this->tables[$tableName]['data'] = $data_string;
			return $data_string;
		}
	}
	
	public static function writeComment($string)
	{
		$file_name = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 
                $fp = fopen( $file_name, 'a');
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
		fwrite ( $fp, '-- '.$string .PHP_EOL );
		fwrite ( $fp, '-- -------------------------------------------'.PHP_EOL );
	}
	
	public function EndBackup($addcheck = true)
	{
		$file_name = dirname(Yii::$app->basePath).'/backup/' . date('Y-m-d') . '.backup.sql'; 
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
	
	
	public static function backup(){
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
		
		\frontend\components\EmailManager::sendBackUp($path, $name);
	}
	
}

