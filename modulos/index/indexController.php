<?php
	class IndexController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->_view->setTemplate("admin");
		}
		public function index()
		{
			// $this->_view->assign("roleX",$this->_acl->acceso('usuarios_index'));
			// Siempre tiene que ir para definir una ruta suave
			$this->_view->setRutaSuave("Dashboard");
			$this->_view->setJs(array('index'));
			$this->_view->assign('titulo','Inicio'); //esto es una forma de pasar parametros, aqui esta el objeto view creado en la super clase controller

			// for ($i=1; $i <8 ; $i++) { 
			// 	$this->_view->setEmailSis("mensaje".$i,"titulo".$i,"",$i." minutos","img/avatar".$i.".png");
			// }
			// for ($i=1; $i <4 ; $i++) { 
			// 	$this->_view->setAlertSis("Alerta".$i,"fa fa-warning danger","");
			// }
			// for ($i=1; $i <23 ; $i++) { 
			// 	$this->_view->setTasksSis("Tarea".$i,3*$i,"");
			// }
			
			$this->_view->renderizar('index');

			//$this->_acl->acceso('todo');
			//$this->redireccionar("login"); // se llama el metodo de renderizado de views, cuya variable posts luego mediante view es usada
			//exit();
	}
	}
?>
