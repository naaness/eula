<?php
	class loginController extends Controller
	{
		private $_login;
		public function __construct()

		{
			parent::__construct();
			$this->_login = $this->loadModel('login');
			$this->_view->setTemplate("admin");
			$this->_view->setNameTemplate("login");
			$this->getLibrary('validFluent');
		}

		public function index()
		{
			if (Session::get('autenticado')) {
				// imprimir aqui la logica hacia donde quiere que se dirija
				// una vez se logee
				$this->redireccionar("index");
			}
			//echo sha1(md5($password)) . "<br>";

			$this->_view->assign('titulo',"Iniciar Sesion");
			$this->_view->setJs(array('login'));

			if ($this->getInt('login') == 1) { // si el formulario fue enviado, osea logear es = 1
				$datos = $_POST;
				$this->_view->assign("datos",$datos);

				if (!$this->getAlphaNum('usuario')) {
					$this->_view->assign('error', "Debe introducir el nombre del usuario");
					$this->_view->renderizar('index','login');
					exit;
				}

				if (!$this->getSql('pass')) {
					$this->_view->assign('error',"Debe introducir el password del usuario");
					$this->_view->renderizar('index','login');
					exit;
				}

				$row = $this->_login->getUsuario( // consula en la base de datos
						$this->getAlphaNum('usuario'),
						$this->getAlphaNum('pass')
					);
				if (!is_array($row)) {
					$this->_view->assign('_error',"El usuario y/o password incorrecto");
					$this->_view->renderizar('index','login');
					exit;
				}
				if ($row['state'] !=1) {
					$this->_view->assign('_error',"Este usuario no esta habilitado");
					$this->_view->renderizar('index','login');
					exit;
				}
				
				Session::set('autenticado',true); // indica que el usuario se ha autenticado
				//Session::set('level',$row['role']); //da el nivel de usuario
				Session::set('usuario',$row['username']);
				Session::set('nombre_usuario',$row['name']);
				Session::set('id_usuario',$row['id']);
				Session::set('tiempo',time());

				$this->redireccionar("login");
			}

			$this->_view->renderizar('index','login');
		}

		public function cerrar()
		{
			Session::destroy();
			$this->redireccionar("index");
		}


	}
