<?php

	define('DEFAULT_CONTROLLER', 'index');
	define('DEFAULT_LAYOUT', 'responsive');
	define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');


	define('APP_NAME', 'EULA');
	define('APP_ESLOGAN', 'Plataforma para el aprendizage online');
	define('APP_COMPANY', 'www.xxxxxxx.com');
	define('SESSION_TIME',1);
	define('HASH_KEY', 'zaqwsxcderfvbgt');
    define('NUMBER_FORMAT',"2,'.', ''");

	//para base de datos
	define('DB_HOST', 'localhost');
	define('DB_USER', 'eula');
	define('DB_PASS', 'eula');
	define('DB_NAME', 'eula');
	define('DB_CHAR', 'utf8');
	define('BTN_CREATE','primary');
	define('BTN_RETURN','default');
	define('BTN_REMOVE','danger');
	define('ICON_REMOVE',"trash");

	define('BTN_VIEW','success');
	define('ICON_VIEW',"eye-open");
	define('ICON_SAVED',"saved");
	define("DATE_NOW",date("d/m/Y"));
	define("DATE_TIME_NOW",date("Y-m-d H:i:s"));

	define("TARGET_DIR_PDF",ROOT . 'public' . DS . 'filepdf' . DS );
	define("TARGET_DIR_PDF_WEB", BASE_URL . '/public/filepdf/'  );

	define("TARGET_DIR_AUDIO",ROOT . 'public' . DS . 'fileaudio' . DS );
	define("TARGET_DIR_AUDIO_WEB", BASE_URL . '/public/fileaudio/'  );
	
	

// $entorno = "dev";

// if($entorno == "dev"){
// 	define("WS","http://www.admovil.net/adconnectionbeta/webservice_soap.asmx?WSDL");
// 	define("USER","administrador");
// 	define("PASS",10101010);
// 	define("WS_TIPO","prueba");
// }elseif($entorno == "prod"){
// 	define("WS","http://www.admovil.net/adconnection/webservice_soap.asmx?WSDL");
// 	define("USER","COF070627R60");
// 	define("PASS","rtg98sqw7");
// 	define("WS_TIPO","produccion");
// }

?>
