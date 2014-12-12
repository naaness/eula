<?php
	ini_set('display_errors',1);
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', realpath(dirname(__FILE__)) . DS);
	define('APP_PATH', ROOT . 'application' . DS);
	try
	{
		require_once APP_PATH . 'Autoload.php'; //Funcion que permite cargar clases sin definir
		require_once APP_PATH . 'Config.php';
		// se cargan las siguiente clases sin definir
		Session::init(); 
		$registry = Registry::getInstancia(); //se instancia ella misma
		$registry->_request = new Request(); // instancia otras clases
		$registry->_db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHAR);
		$registry->_acl = new ACL();

		Bootstrap::run($registry->_request);
	}
	catch (Exception $e)
	{
		echo $e->getMessage();

	}
?>
