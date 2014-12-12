<?php
	class usuariosController extends Controller
	{
	    private $_usuarios;
		public function __construct()
		{
			parent::__construct();
			$this->_usuarios = $this->loadModel('usuarios');
			$this->_view->setTemplate("admin");
		}
		public function index()
		{
			$this->_acl->acceso('user');

			$this->_view->setRutaSuave("ACL","fa-bar-chart-o","acl");
			$this->_view->setRutaSuave("Usuarios");

			$this->_view->assign('titulo','Usuarios');
			$this->_view->assign('usuarios',$this->_usuarios->getUsuarios());
			$this->_view->assign('roles',$this->_usuarios->getRoles());
			$this->_view->renderizar('index');

		}
		public function estado($id_user,$state){
			$this->_acl->acceso('user_habilitar');
			if ($id_user!=1) {
				if ($state==0) {
					$state=1;
				}else{
					$state=0;
				}
				$datos=array(
					"id"=>$id_user,
					"state"=>$state
				);
				$this->_usuarios->actualizarUsuario($datos);
			}
			$this->redireccionar('usuarios');
		}

		public function permisos($id_usuario)
		{
			$this->_acl->acceso('user_role');

			$id = $this->filtrarInt($id_usuario);
			if (!$id) {
				$this->redireccionar('usuarios');
			}

			$this->_view->setRutaSuave("ACL","fa-bar-chart-o","acl");
			$this->_view->setRutaSuave("Usuarios","fa-users","usuarios");
			$this->_view->setRutaSuave("Editar Role");

			if ($this->getInt('guardar')==1) {

				$values = array_keys($_POST);
				$replace = array();
				$eliminar = array();
				for ($i=0; $i < count($values) ; $i++) {
					if (substr($values[$i],0,5)=='perm_') {

						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'usuario'=>$id,
								'permiso'=>substr($values[$i],-strlen($values[$i])+5),
								);
						}
						else
						{
							if ($_POST[$values[$i]]==1) {
								$v=1;
							}
							else
							{
								$v=0;

							}
							$replace[] =array(
								'usuario'=>$id,
								'permiso'=>substr($values[$i],-strlen($values[$i])+5),
								'valor'=>$v
							);

						}

					}

				}
				for ($i=0; $i < count($eliminar); $i++) {
					$this->_usuarios->eliminarPermiso(
						$eliminar[$i]['usuario'],
						$eliminar[$i]['permiso']
						);
				}
				for ($i=0; $i < count($replace); $i++) {
					$this->_usuarios->editarPermiso(
						$replace[$i]['usuario'],
						$replace[$i]['permiso'],
						$replace[$i]['valor']
					);
				}
			}
			$permisosUsuario = $this->_usuarios->getPermisosUsuario($id);
			$permisosRole = $this->_usuarios->getPermisosRole($id);
			
			if (!$permisosUsuario || !$permisosRole) {
				$this->redireccionar('usuarios');
			}
			$entro=array_keys($permisosUsuario);
			$this->_view->assign('titulo','Permisos de usuario');
			$this->_view->assign('permisos',array_keys($permisosUsuario));
			$this->_view->assign('usuario',$permisosUsuario);
			$this->_view->assign('role',$permisosRole);
			$this->_view->assign('info',$this->_usuarios->getUsuario($id));
			$this->_view->renderizar('permisos');
		}
		public function editar_role($id_usuario)
		{
			$this->_acl->acceso('user_role');
			$id = $this->filtrarInt($id_usuario);
			if (!$id) {
				$this->redireccionar('usuarios');
			}
			$row = $this->_usuarios->getUsuario($id);
			if (!$row) {
				$this->redireccionar('usuarios');
			}
			$this->_view->setRutaSuave("ACL","fa-bar-chart-o","acl");
			$this->_view->setRutaSuave("Usuarios","fa-users","usuarios");
			$this->_view->setRutaSuave("Editar Role");

			if ($this->getInt('editar')==1) {
				$values = array_keys($_POST);
				$id_role=0;
				for ($i=0; $i < count($values) ; $i++) {
					if (substr($values[$i],0,5)=='usur_') {
						$id_role= (int) $_POST[$values[$i]];
					}
				}
				if ($id_role>1) {
					$datos=array(
						"id"=>$id,
						"id_role"=>$id_role
					);
					$this->_usuarios->editarUsuarioRole($datos);
				}
			}
			$this->_view->assign('titulo','Editar Role');
			$this->_view->assign('actualrol',$id);
			$this->_view->assign('info',$this->_usuarios->getUsuario($id));
			$this->_view->assign('roles',$this->_usuarios->getRoles());
			$this->_view->renderizar('editar_role');
		}

		public function crear_usuario(){
			$this->_acl->acceso('user_nuevo');
			$this->_view->setRutaSuave("ACL","fa-bar-chart-o","acl");
			$this->_view->setRutaSuave("Usuarios","fa-users","usuarios");
			$this->_view->setRutaSuave("Crear Usuario");

			$this->_view->assign('titulo','Crear usuario');

			if($this->getInt("crear")==1){
				$datos=array(
					"name"=>$this->getSql("nombre"),
					"username"=>$this->getSql("usuario"),
					"email"=>$this->getSql("email"),
					"password"=>sha1(md5($this->getSql("pass")))
				);

				$this->getLibrary("validFluent");
				$this->validador = new ValidFluent($_POST);

				$this->validador->name("nombre")->required("El Nombre no puede quedar vacío")->alfa()->minSize(3);
				$this->validador->name("usuario")->required("El Usuario no puede quedar vacío")->alfa()->minSize(3);
				$this->validador->name("email")->required("El Email es obligatorio")->email();
				$this->validador->name("pass")->required("La Contraseña es obligatoria")->alfa()->minSize(3);
				$this->validador->name("pass_r")->required("Debe repetir la contraseña")->alfa()->minSize(3);

				if(!$this->validador->isGroupValid()){
					$this->_view->setAlertSis($this->validador->getError('nombre'));
					$this->_view->setAlertSis($this->validador->getError('usuario'));
					$this->_view->setAlertSis($this->validador->getError('email'));
					$this->_view->setAlertSis($this->validador->getError('pass'));
					$this->_view->setAlertSis($this->validador->getError('pass_r'));
				}else{
					$pass = $this->getSql("pass");
					$pass_r = $this->getSql("pass_r");

					if($pass === $pass_r){
						$this->_usuarios->crearUsuario($datos);
					}else{
						$this->_view->setAlertSis("Las constraseñas no coinciden");
					}
				}
			}
			$this->_view->assign("_POST",$_POST);
			$this->_view->renderizar('crear_usuario');
		}
	}
