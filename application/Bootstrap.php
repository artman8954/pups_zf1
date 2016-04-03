<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDatabase(){

		$config = new Zend_Config(require ($_SERVER['DOCUMENT_ROOT'].'/application/configs/config.php'));

		$title  = $config->appName;
		$params = $config->database->toArray();
		Zend_Registry::set('title',$title);

		$base_url = $config->base_url;
		Zend_Registry::set('base_url',$base_url);

		$DB = new Zend_Db_Adapter_Pdo_Mysql($params);

		$DB->setFetchMode(Zend_Db::FETCH_OBJ);
		Zend_Registry::set('DB',$DB);
		Zend_Db_Table::setDefaultAdapter($DB);
    }

}
