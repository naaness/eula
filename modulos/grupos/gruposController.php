<?php
	class gruposController extends Controller
	{
		private $_model;
		public function __construct()

		{
			parent::__construct();
			$this->_model = $this->loadModel('grupos');
			$this->_view->setTemplate("admin");
		}

		public function index()
		{
			$this->_acl->acceso('group');
			$this->_view->setRutaSuave("Grupos");


			$this->_view->renderizar('index');
		}

		public function crear_editar(){

			$this->_acl->acceso('group_crear_editar');
			$this->_view->setRutaSuave("Grupos","fa-users","grupos");
			$this->_view->setRutaSuave("Listado");

			$this->_view->assign('grupos',$this->_model->getGrupos());
			$this->_view->assign('titulo','Crear y Editar Grupos');
			$this->_view->renderizar('crear_editar');

		}

		public function crear_grupo(){

			$this->_acl->acceso('group_crear_grupo');

			$this->_view->setRutaSuave("Grupos","fa-users","grupos");
			$this->_view->setRutaSuave("Listado","fa-list","grupos/crear_editar");
			$this->_view->setRutaSuave("Crear Grupo");

			if ($this->getInt('guardar')==1) {
				
				$this->getLibrary("validFluent");
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre de grupo")->alfa()->minSize(3)->maxSize(60);

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$valores = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$valores[substr($values[$i],5, strlen($values[$i])-4)]=	$_POST[$values[$i]];
						}
					}
					$this->_view->assign('values',$valores);
				}else{
					// crear el grupo
					$datos=array(
						"name"=>$_POST["name"],
						"id_user_creator"=>Session::get('id_usuario'),
						"date_create"=>DATE_TIME_NOW,
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->insertarGrupo($datos);
					$last_id = $this->_model->getLastGropoId(Session::get('id_usuario'));
					$id = $last_id["id"];

					
					$insertar = array();
					$eliminar = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$id_user=substr($values[$i],5, strlen($values[$i])-4);
							if ($_POST[$values[$i]]=='x') {
								$eliminar[] = array(
									'id_group'=>$id,
									'id_user'=>$id_user
								);
							}else{
								$regis = $this->_model->getGrupoLiderRegistro($id,$id_user);
								if (!is_array($regis)) {
									$insertar[] =array(
										'id_group'=>$id,
										'id_user'=>$id_user
									);
								}
							}						
						}
					}
					for ($i=0; $i < count($eliminar); $i++) { 
						$this->_model->eliminarGrupoLideres(
							$eliminar[$i]['id_group'],
							$eliminar[$i]['id_user']
							);
					}
					for ($i=0; $i < count($insertar); $i++) { 
						$this->_model->editarGrupoLideres(
							$insertar[$i]['id_group'],
							$insertar[$i]['id_user']
						);
					}
					$this->redireccionar('grupos/crear_editar');
				}
				
			}

			$this->_view->assign('usuarios',$this->_model->getUsuarios());
			$this->_view->assign('titulo','Crear nuevo grupo');
			$this->_view->renderizar('crear_grupo');

		}

		public function editar_grupo($id=false){
			if (!$id) {
				$this->redireccionar('grupos/crear_editar');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('grupos/crear_editar');
			}

			$this->_acl->acceso('group_editar_grupo');
			
			$this->_view->setRutaSuave("Grupos","fa-users","grupos");
			$this->_view->setRutaSuave("Listado","fa-list","grupos/crear_editar");
			$this->_view->setRutaSuave("Editar Grupo");

			if ($this->getInt('editar')==1) {

				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre de grupo")->alfa()->minSize(3)->maxSize(60);

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$valores = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$valores[substr($values[$i],5, strlen($values[$i])-4)]=	$_POST[$values[$i]];
						}
					}
					$this->_view->assign('values',$valores);
				}else{
					// crear el grupo
					$datos=array(
						"id"=>$id,
						"name"=>$_POST["name"],
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->editarGrupo($datos);

					
					$insertar = array();
					$eliminar = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$id_user=substr($values[$i],5, strlen($values[$i])-4);
							if ($_POST[$values[$i]]=='x') {
								$eliminar[] = array(
									'id_group'=>$id,
									'id_user'=>$id_user
								);
							}else{
								$regis = $this->_model->getGrupoLiderRegistro($id,$id_user);
								if (!is_array($regis)) {
									$insertar[] =array(
										'id_group'=>$id,
										'id_user'=>$id_user
									);
								}
							}						
						}
					}
					for ($i=0; $i < count($eliminar); $i++) { 
						$this->_model->eliminarGrupoLideres(
							$eliminar[$i]['id_group'],
							$eliminar[$i]['id_user']
							);
					}
					for ($i=0; $i < count($insertar); $i++) { 
						$this->_model->editarGrupoLideres(
							$insertar[$i]['id_group'],
							$insertar[$i]['id_user']
						);
					}
					$this->redireccionar('grupos/crear_editar');
					exit();
				}
			}

			$this->_view->assign('nombre',$this->_model->getGrupoNombre($id));
			$this->_view->assign('lideres',$this->_model->getGrupoLider($id));
			$this->_view->assign('titulo','Crear nuevo grupo');
			$this->_view->renderizar('editar_grupo');
		}

		public function administracion(){
			$this->_acl->acceso('group_administracion');
			$this->_view->setRutaSuave("Grupos","fa-users","grupos");
			$this->_view->setRutaSuave("Administracion");

			$this->_view->assign('misgrupos',$this->_model->getMisGrupos(Session::get('id_usuario')));
			$this->_view->assign('titulo','Administracion de Grupos');
			$this->_view->renderizar('administracion');
		}

		public function editar_grupo_usuarios($id_group){
			if (!$id_group) {
				$this->redireccionar('grupos/administracion');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_group));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('grupos/administracion');
			}

			$this->_acl->acceso('group_editar_grupo');

			$this->_acl->acceso('group_administracion');
			$this->_view->setRutaSuave("Grupos","fa-users","grupos");
			$this->_view->setRutaSuave("Administracion","fa-users","grupos/administracion");
			$this->_view->setRutaSuave("Usuarios del grupo");

			if ($this->getInt('editar')==1) {
				$insertar = array();
				$eliminar = array();
				$values = array_keys($_POST);
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='perm_') {
						$id_user=substr($values[$i],5, strlen($values[$i])-4);
						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'id_group'=>$id_group,
								'id_user'=>$id_user
							);
						}else{
							$regis = $this->_model->getGrupoUserRegistro($id_group,$id_user);
							if (!is_array($regis)) {
								$insertar[] =array(
									'id_group'=>$id_group,
									'id_user'=>$id_user
								);
							}
						}						
					}
				}
				for ($i=0; $i < count($eliminar); $i++) { 
					$this->_model->eliminarGrupoUsuarios(
						$eliminar[$i]['id_group'],
						$eliminar[$i]['id_user']
						);
				}
				for ($i=0; $i < count($insertar); $i++) { 
					$this->_model->editarGrupoUsuarios(
						$insertar[$i]['id_group'],
						$insertar[$i]['id_user']
					);
				}
				//$this->redireccionar('grupos/administracion');
				// exit();
			}

			$this->_view->assign('usuarios',$this->_model->getUsuariosGrupo($id_group));
			$this->_view->assign('titulo','Administracion de Grupos');
			$this->_view->renderizar('editar_grupo_usuarios');
		}
	}