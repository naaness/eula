<?php
	class cursosController extends Controller
	{
		private $_model;
		public function __construct()

		{
			parent::__construct();
			$this->_model = $this->loadModel('cursos');
			$this->_view->setTemplate("admin");
		}

		public function index()
		{
			$this->_acl->acceso('curse');
			$this->_view->setRutaSuave("Cursos");
			$this->_view->setJs(array('index'));
			$this->_view->assign('cursos',$this->_model->getCursos());
			$this->_view->assign('titulo','Cursos');
			$this->_view->renderizar('index');
		}

		public function crear_curso(){

			$this->_acl->acceso('curse_crear_curso');
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Crear Curso");

			if ($this->getInt('guardar')==1) {
				
				$this->getLibrary("validFluent");
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre de curso")->alfa()->minSize(3)->maxSize(60);
				$validador->name("description")->required("Invalida descripcion")->alfa();

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$this->_view->setAlertSis($validador->getError('description'));
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
						"description"=>$_POST["description"],
						"id_user_creator"=>Session::get('id_usuario'),
						"date_create"=>DATE_TIME_NOW,
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->insertarCurso($datos);
					$last_id = $this->_model->getLastCursoId(Session::get('id_usuario'));
					$id = $last_id["id"];

					
					$insertar = array();
					$eliminar = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$id_user=substr($values[$i],5, strlen($values[$i])-4);
							if ($_POST[$values[$i]]=='x') {
								$eliminar[] = array(
									'id_course'=>$id,
									'id_teacher'=>$id_user
								);
							}else{
								$regis = $this->_model->getCursoProfesorRegistro($id,$id_user);
								if (!is_array($regis)) {
									$insertar[] =array(
										'id_course'=>$id,
										'id_teacher'=>$id_user
									);
								}
							}						
						}
					}
					for ($i=0; $i < count($eliminar); $i++) { 
						$this->_model->eliminarCursoProfesores(
							$eliminar[$i]['id_course'],
							$eliminar[$i]['id_teacher']
							);
					}
					for ($i=0; $i < count($insertar); $i++) { 
						$this->_model->editarCursoProfesores(
							$insertar[$i]['id_course'],
							$insertar[$i]['id_teacher']
						);
					}
					$this->redireccionar('cursos');
				}
			}
			$this->_view->assign('profesores',$this->_model->getProfesores());
			$this->_view->assign('titulo','Crear nuevo curso');
			$this->_view->renderizar('crear_curso');
		}

		public function editar_curso($id=false){

			$this->_acl->acceso('curse_editar_curso');
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Editar Curso");

			if (!$id) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}

			if ($this->getInt('editar')==1) {
				
				$this->getLibrary("validFluent");
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre de curso")->alfa()->minSize(3)->maxSize(60);
				$validador->name("description")->required("Invalida descripcion")->alfa();

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$this->_view->setAlertSis($validador->getError('description'));
					$valores = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$valores[substr($values[$i],5, strlen($values[$i])-4)]=	$_POST[$values[$i]];
						}
					}
					$this->_view->assign('values',$valores);
				}else{
					// crear el curso
					$datos=array(
						"id"=>$id,
						"name"=>$_POST["name"],
						"description"=>$_POST["description"],
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->editarCurso($datos);

					$insertar = array();
					$eliminar = array();
					for ($i=0; $i < count($values) ; $i++) { 
						if (substr($values[$i],0,5)=='perm_') {
							$id_user=substr($values[$i],5, strlen($values[$i])-4);
							if ($_POST[$values[$i]]=='x') {
								$eliminar[] = array(
									'id_course'=>$id,
									'id_teacher'=>$id_user
								);
							}else{
								$regis = $this->_model->getCursoProfesorRegistro($id,$id_user);
								if (!is_array($regis)) {
									$insertar[] =array(
										'id_course'=>$id,
										'id_teacher'=>$id_user
									);
								}
							}						
						}
					}
					for ($i=0; $i < count($eliminar); $i++) { 
						$this->_model->eliminarCursoProfesores(
							$eliminar[$i]['id_course'],
							$eliminar[$i]['id_teacher']
							);
					}
					for ($i=0; $i < count($insertar); $i++) { 
						$this->_model->editarCursoProfesores(
							$insertar[$i]['id_course'],
							$insertar[$i]['id_teacher']
						);
					}
					$this->redireccionar('cursos');
				}
			}
			$this->_view->assign('datoscurso',$this->_model->getCurso($id));
			$this->_view->assign('profesores',$this->_model->getCursoProfesor($id));
			$this->_view->assign('titulo','Editar curso');
			$this->_view->renderizar('editar_curso');
		}
		public function matricular_grupo($id=false){
			$this->_acl->acceso('curse_matricular_grupo');
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Matricular grupo");

			if (!$id) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if ($this->getInt('guardar')==1) {
				$values = array_keys($_POST);
				$insertar = array();
				$eliminar = array();
				$usuarios = $this->_model->getUsuarios();
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='perm_') {
						$id_user=substr($values[$i],5, strlen($values[$i])-4);
						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'id_course'=>$id,
								'id_group'=>$id_user
							);
						}else{
							$regis = $this->_model->getCursoGrupoRegistro($id,$id_user);
							if (!is_array($regis)) {
								$insertar[] =array(
									'id_course'=>$id,
									'id_group'=>$id_user
								);
							}
						}						
					}
				}
				for ($i=0; $i < count($eliminar); $i++) { 
					$this->_model->eliminarCursoGrupos(
						$eliminar[$i]['id_course'],
						$eliminar[$i]['id_group']
					);
					for ($j=0; $j < count($usuarios) ; $j++) {
						$this->_model->eliminarCursoUsuarios(
							$eliminar[$i]['id_course'],
							$usuarios[$j]['id']
						);
					}
				}
				for ($i=0; $i < count($insertar); $i++) { 
					$this->_model->editarCursoGrupos(
						$insertar[$i]['id_course'],
						$insertar[$i]['id_group']
					);
					for ($j=0; $j < count($usuarios) ; $j++) {
						$this->_model->editarCursoUsuarios(
							$eliminar[$i]['id_course'],
							$usuarios[$j]['id']
						);
					}
				}
				$this->redireccionar('cursos');
			}
			$this->_view->assign('datoscurso',$this->_model->getCurso($id));
			$this->_view->assign('grupos',$this->_model->getGruposCurso($id));
			$this->_view->assign('titulo','Matricular Curso');
			$this->_view->renderizar('matricular_grupo');
		}

		public function matricular_usuario($id=false){
			$this->_acl->acceso('curse_matricular_usuario');
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Matricular usuario");

			if (!$id) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}

			if ($this->getInt('guardar')==1) {
				$values = array_keys($_POST);
				$insertar = array();
				$eliminar = array();
				$usuarios = $this->_model->getUsuarios();
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='perm_') {
						$id_user=substr($values[$i],5, strlen($values[$i])-4);
						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'id_course'=>$id,
								'id_user'=>$id_user
							);
						}else{
							$regis = $this->_model->getCursoUsuarioRegistro($id,$id_user);
							if (!is_array($regis)) {
								$insertar[] =array(
									'id_course'=>$id,
									'id_user'=>$id_user
								);
							}
						}						
					}
				}
				for ($i=0; $i < count($eliminar); $i++) { 
					$this->_model->eliminarCursoUsuarios(
						$eliminar[$i]['id_course'],
						$eliminar[$i]['id_user']
					);
				}
				for ($i=0; $i < count($insertar); $i++) { 
					$this->_model->editarCursoUsuarios(
						$insertar[$i]['id_course'],
						$insertar[$i]['id_user']
					);
				}
				$this->redireccionar('cursos');
			}
			$this->_view->assign('datoscurso',$this->_model->getCurso($id));
			$this->_view->assign('usuarios',$this->_model->getUsuariosCurso($id));
			$this->_view->assign('titulo','Matricular Curso');
			$this->_view->renderizar('matricular_usuario');
		}

		public function modulos($id=false){
			$this->_acl->acceso('curse_modulos');
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos");

			if (!$id) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			
			$this->_view->assign('id_curso',$id);
			$this->_view->assign('modulos',$this->_model->getModulos($id));
			$this->_view->assign('titulo','Modulos del curso');
			$this->_view->renderizar('modulos');
		}
		public function crear_modulo($id=false){
			$this->_acl->acceso('curse_crear_modulo');
			if (!$id) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id));
			$validador->name("id")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id);
			$this->_view->setRutaSuave("Crear Modulo");

			if ($this->getInt('guardar')==1) {
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre del modulo")->alfa()->minSize(3)->maxSize(60);

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
				}else{
					$datos=array(
						"id_course"=>$id,
						"name"=>$_POST["name"],
						"id_user_creator"=>Session::get('id_usuario'),
						"date_create"=>DATE_TIME_NOW,
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->insertarModulo($datos);
					$this->redireccionar('cursos/modulos/'.$id);
					exit();
				}
			}
			$this->_view->assign('titulo','Modulos del curso');
			$this->_view->renderizar('crear_modulo');
		}
		public function editar_modulo($id_course=false,$id=false){
			$this->_acl->acceso('curse_crear_modulo');
			if (!$id || !$id_course) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id,"id2"=>$id_course));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Editar Modulo");

			if ($this->getInt('guardar')==1) {
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre del modulo")->alfa()->minSize(3)->maxSize(60);

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
				}else{
					$datos=array(
						"id"=>$id,
						"name"=>$_POST["name"],
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->actuaizarModulo($datos);
					$this->redireccionar('cursos/modulos/'.$id_course);
					exit();
				}
			}
			$this->_view->assign('modulo',$this->_model->getModulo($id));
			$this->_view->assign('titulo','Modulos del curso');
			$this->_view->renderizar('editar_modulo');
		}

		public function clases ($id_course=false,$id_module=false){
			$this->_acl->acceso('curse_clases');
			if (!$id_module || !$id_course) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases");

			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('url_tipo',$this->url_clases());
			$this->_view->assign('id_modulo',$id_module);
			$this->_view->assign('id_curso',$id_course);
			$this->_view->assign('clases',$this->_model->getClasesModulosCursos($id_course,$id_module));
			$this->_view->assign('titulo','Clases del curso');
			$this->_view->renderizar('clases');
		}
		public function crear_clase($id_course=false,$id_module=false){
			$this->_acl->acceso('curse_crear_clase');
			if (!$id_module || !$id_course) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Crear Clase");
			$this->_view->setJs(array('crear_clase'));

			if ($this->getInt('guardar')==1) {
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre del clase")->alfa()->minSize(3)->maxSize(60);
				$validador->name("description")->required("Invalida descripcion")->alfa();
				$validador->name("profesor")->required("Invalido Profesor")->numberInteger();
				$validador->name("tipo")->required("Invalido tipo")->numberInteger();

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$this->_view->setAlertSis($validador->getError('description'));
					$this->_view->setAlertSis($validador->getError('profesor'));
					$this->_view->setAlertSis($validador->getError('tipo'));
				}else{
					if ($_POST["profesor"]<1 || $_POST["tipo"]<1) {
						$this->_view->setAlertSis("Invalido profesorXX");
						$this->_view->setAlertSis("Invalido tipo");
					}
					$datos=array(
						"id_course"=>$id_course,
						"id_module"=>$id_module,
						"name"=>$_POST["name"],
						"description"=>$_POST["description"],
						"id_teacher"=>$_POST["profesor"],
						"type"=>$_POST["tipo"],
						"id_user_creator"=>Session::get('id_usuario'),
						"date_create"=>DATE_TIME_NOW,
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->insertarClase($datos);
					$id_class = $this->_model->getLastClaseId(Session::get('id_usuario'));
					// para cada alumno del curso se le asocia este curso
					// y asi almacenar la nota
					$usuarios = $this->_model->getUsuariosCursoClase($id_course);
					foreach ($usuarios as $key) {
						$datos=array(
							"id_class"=>$id_class["id"],
							"id_student"=>$key["id_user"],
							"grade"=>"0"
						);
						$this->_model->insertarUsuarioClase($datos);
					}
					$this->redireccionar('cursos/clases/'.$id_course."/".$id_module);
					exit();
				}
			}
			

			$this->_view->assign('icono_tipo',$this->iconos_clases());

			$this->_view->assign('profesores',$this->_model->getCursoProfesoresClase($id_course));
			$this->_view->assign('titulo','Crear clase');
			$this->_view->renderizar('crear_clase');
		}

		public function editar_clase ($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_crear_clase');
			if ($id_module==0 AND $id_course==0 AND $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Editar Clase");
			$this->_view->setJs(array('crear_clase'));

			if ($this->getInt('guardar')==1) {
				$validador = new ValidFluent($_POST);

				$validador->name("name")->required("Invalido nombre del clase")->alfa()->minSize(3)->maxSize(60);
				$validador->name("description")->required("Invalida descripcion")->alfa();
				$validador->name("profesor")->required("Invalido Profesor")->numberInteger();
				$validador->name("tipo")->required("Invalido tipo")->numberInteger();

				$values = array_keys($_POST);

				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					$this->_view->setAlertSis($validador->getError('description'));
					$this->_view->setAlertSis($validador->getError('profesor'));
					$this->_view->setAlertSis($validador->getError('tipo'));
				}else{
					if ($_POST["profesor"]<1 || $_POST["tipo"]<1) {
						$this->_view->setAlertSis("Invalido profesorXX");
						$this->_view->setAlertSis("Invalido tipo");
					}
					$datos=array(
						"id"=>$id_class,
						"name"=>$_POST["name"],
						"description"=>$_POST["description"],
						"id_teacher"=>$_POST["profesor"],
						"type"=>$_POST["tipo"],
						"id_user_modifier"=>Session::get('id_usuario'),
						"date_modify"=>DATE_TIME_NOW
					);
					$this->_model->actualizarClase($datos);
					
					$this->redireccionar('cursos/clases/'.$id_course."/".$id_module);
					exit();
				}
			}

			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('profesores',$this->_model->getCursoProfesoresClase($id_course));
			$this->_view->assign('titulo','Crear clase');
			$this->_view->renderizar('editar_clase');
		}
		private function iconos_clases(){
			$icono_tipo=array();
			$icono_tipo[1]="fa fa-book";
			$icono_tipo[2]="fa fa-volume-up";
			$icono_tipo[3]="fa fa-film";
			$icono_tipo[4]="fa fa-comments";
			$icono_tipo[5]="fa fa-exclamation-circle";
			return $icono_tipo;
		}
		private function url_clases(){
			$icono_tipo=array();
			$icono_tipo[1]="editar_lectura";
			$icono_tipo[2]="editar_audio";
			$icono_tipo[3]="editar_video";
			$icono_tipo[4]="editar_foro";
			$icono_tipo[5]="editar_examen";
			return $icono_tipo;
		}
		public function vista_curso($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_vista_curso');
			if ($id_module==0 AND $id_course==0 AND $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			if ($id_module==0 AND $id_class==0) {
				$this->_view->setRutaSuave("Vista del curso");
			}elseif ($id_class==0) {
				$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
				$this->_view->setRutaSuave("Vista del curso");
			}else{
				$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
				$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
				$this->_view->setRutaSuave("Vista del curso");
			}

			$this->_view->assign('icono_tipo',$this->iconos_clases());
			
			$this->_view->assign('datos_curso',$this->_model->getClasesCursos($id_course));
			$this->_view->assign('titulo','Vista curso');
			$this->_view->renderizar('vista_curso');
		}
		public function editar_lectura ($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_editar_lectura');
			if ($id_module==0 AND $id_course==0 AND $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Editar Clase de Lectura");

			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$validador = new ValidFluent($_POST);
				$validador->name("name")->required("Invalido nombre del archivo")->alfa()->minSize(3)->maxSize(60);
				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
				}elseif (isset($_FILES['filepdf']['name'])) {
					$target_file = TARGET_DIR_PDF . basename($_FILES["filepdf"]["name"]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					if (strtolower($imageFileType)!="pdf") {
						$this->_view->setAlertSis("Invalido archivo pdf");
					}elseif (file_exists($target_file)) {
						$datos=array(
				        	"id_course"=>$id_course,
							"id_module"=>$id_module,
							"id_class"=>$id_class,
				        	"name"=>$_POST["name"],
				        	"url"=>$_FILES["filepdf"]["name"],
				        	"download"=>0
				        );
				        $this->_model->insertarPDF($datos);
					}elseif (move_uploaded_file($_FILES["filepdf"]["tmp_name"], $target_file)) {
				        $datos=array(
				        	"id_course"=>$id_course,
							"id_module"=>$id_module,
							"id_class"=>$id_class,
				        	"name"=>$_POST["name"],
				        	"url"=>$_FILES["filepdf"]["name"],
				        	"download"=>0
				        );
				        $this->_model->insertarPDF($datos);
				    } else {
				        $this->_view->setAlertSis("Error subiendo el pdf");
				    }
				}else{
					$this->_view->setAlertSis("No se encontro archivo");
				}
			}

			// $this->_view->assign('TARGET_DIR_PDF',TARGET_DIR_PDF);
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('pdfs',$this->_model->getPDFs($id_class));
			$this->_view->assign('titulo','Vista curso');
			$this->_view->renderizar('clase_editar_lectura');
		}
		public function descargar_lectura($id_course=0,$id_module=0,$id_class=0,$id_pdf=0,$download=0){
			$this->_acl->acceso('curse_ver_lectura');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_pdf == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf,"id5"=>$download));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			$validador->name("id5")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if ($download==0) {
				$download=1;
			}else{
				$download=0;
			}
			$datos=array(
				"id"=>$id_pdf,
	        	"download"=>$download
	        );
	        $this->_model->actualizarPDF($datos);
	        $this->redireccionar('cursos/editar_lectura/'.$id_course.'/'.$id_module.'/'.$id_class);
	        exit();

		}
		public function ver_lectura ($id_course=0,$id_module=0,$id_class=0,$id_pdf=0){
			$this->_acl->acceso('curse_ver_lectura');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_pdf == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Ver Lectura");

			$this->_view->assign('id1',$id_course);
			$this->_view->assign('id2',$id_module);
			$this->_view->assign('id3',$id_class);
			$this->_view->assign('id4',$id_pdf);


			$this->_view->assign('titulo','Ver lectura');
			$this->_view->assign('datospdf',$this->_model->getPDFAJAX($id_course,$id_module,$id_class,$id_pdf));
			//$this->_view->setJs(array('ver_lectura'));

			$this->_view->setTemplate("viewpdf");

			$this->_view->renderizar('ver_lectura');
		}

		public function get_pdf($id_course=0,$id_module=0,$id_class=0,$id_pdf=0){
			if ($this->_acl->acceso_bloque('course_get_pdf')) {
				$this->getLibrary("validFluent");
				$validador = new ValidFluent(array("id1"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf));
				$validador->name("id1")->required("Id invalido")->numberInteger();
				$validador->name("id2")->required("Id invalido")->numberInteger();
				$validador->name("id3")->required("Id invalido")->numberInteger();
				$validador->name("id4")->required("Id invalido")->numberInteger();
				if($validador->isGroupValid()){
					$url_pdf=$this->_model->getPDFAJAX($id_course,$id_module,$id_class,$id_pdf);
					echo TARGET_DIR_PDF_WEB . $url_pdf["url"];
				}else{
					echo "";
				}
			}else{
				echo "";
			}
		}
			
		public function editar_audio ($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_editar_audio');
			if ($id_module==0 || $id_course==0 || $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Editar Clase de Audio");

			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$validador = new ValidFluent($_POST);
				$validador->name("name")->required("Invalido nombre del archivo")->alfa()->minSize(3)->maxSize(60);
				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
				}elseif (isset($_FILES['fileaudio']['name'])) {
					$target_file = TARGET_DIR_AUDIO . basename($_FILES["fileaudio"]["name"]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					if (strtolower($imageFileType)!="mp3") {
						$this->_view->setAlertSis("Invalido archivo de audio");
					}elseif (file_exists($target_file)) {
						$datos=array(
				        	"id_course"=>$id_course,
							"id_module"=>$id_module,
							"id_class"=>$id_class,
				        	"name"=>$_POST["name"],
				        	"url"=>$_FILES["fileaudio"]["name"],
				        	"download"=>0
				        );
				        $this->_model->insertarAUDIO($datos);
					}elseif (move_uploaded_file($_FILES["fileaudio"]["tmp_name"], $target_file)) {
				        $datos=array(
				        	"id_course"=>$id_course,
							"id_module"=>$id_module,
							"id_class"=>$id_class,
				        	"name"=>$_POST["name"],
				        	"url"=>$_FILES["fileaudio"]["name"],
				        	"download"=>0
				        );
				        $this->_model->insertarAudio($datos);
				    } else {
				        $this->_view->setAlertSis("Error subiendo el audio");
				    }
				}else{
					$this->_view->setAlertSis("No se encontro archivo");
				}
			}

			// $this->_view->assign('TARGET_DIR_PDF',TARGET_DIR_PDF);
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('audios',$this->_model->getAudios($id_class));
			$this->_view->assign('titulo','Vista curso');
			$this->_view->renderizar('clase_editar_audio');
		}

		public function descargar_audio($id_course=0,$id_module=0,$id_class=0,$id_audio=0,$download=0){
			$this->_acl->acceso('curse_descargar_audio');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_audio == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_audio,"id5"=>$download));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			$validador->name("id5")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if ($download==0) {
				$download=1;
			}else{
				$download=0;
			}
			$datos=array(
				"id"=>$id_audio,
	        	"download"=>$download
	        );
	        $this->_model->actualizarAudio($datos);
	        $this->redireccionar('cursos/editar_audio/'.$id_course.'/'.$id_module.'/'.$id_class);
	        exit();
		}

		public function oir_audio ($id_course=0,$id_module=0,$id_class=0,$id_pdf=0){
			$this->_acl->acceso('curse_oir_audio');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_pdf == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Oir Audio");

			$this->_view->assign('id1',$id_course);
			$this->_view->assign('id2',$id_module);
			$this->_view->assign('id3',$id_class);
			$this->_view->assign('id4',$id_pdf);

			

			$this->_view->assign('purldf',$id_course.'/'.$id_module.'/'.$id_class.'/'.$id_pdf);

			$this->_view->assign('titulo','Oir audio');
			$this->_view->assign('descripcion','Oir audio');
			//$datosaudio = $this->_model->getAudioAJAX($id_course,$id_module,$id_class,$id_pdf);
			//$this->_view->assign('datosaudio',$datosaudio);
			//$this->_view->assign('url_download',TARGET_DIR_AUDIO_WEB.$datosaudio["url"]);
			// $this->_view->setJs(array('oir_audio'));
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->setTemplate("viewaudio");
			$this->_view->renderizar('oir_audio');
		}

		public function get_audios($id_course=0,$id_module=0,$id_class=0){
			if ($this->_acl->acceso_bloque('course_get_pdf')) {
				$this->getLibrary("validFluent");
				$validador = new ValidFluent(array("id1"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
				$validador->name("id1")->required("Id invalido")->numberInteger();
				$validador->name("id2")->required("Id invalido")->numberInteger();
				$validador->name("id3")->required("Id invalido")->numberInteger();
				if($validador->isGroupValid()){
					$url_pdf=$this->_model->getAudiosAJAX($id_course,$id_module,$id_class);
					$data = array();
					foreach ($url_pdf as $key) {
						$data[]=array(
							"id_audio"=>$key["id"],
							"mp3"=>TARGET_DIR_AUDIO_WEB.$key["url"],
							"title"=>$key["name"],
					        "cover"=>'http://eula.com/views/layout/viewaudio/mix/1.png'
						);
					}
					echo json_encode($data);
				}else{
					echo "";
				}
			}else{
				echo "";
			}
		}

		public function editar_video ($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_editar_video');
			if ($id_module==0 || $id_course==0 || $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Clase de Video");

			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$validador = new ValidFluent($_POST);
				$validador->name("name")->required("Invalido nombre del video")->alfa()->minSize(3)->maxSize(60);
				// $validador->name("url")->required("Ruta invalida")->url();
				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('name'));
					// $this->_view->setAlertSis($validador->getError('url'));
				}elseif (!filter_var($_POST["url"], FILTER_VALIDATE_URL)){
					$this->_view->setAlertSis("Url invalida");
				}else{
					$datos=array(
			        	"id_course"=>$id_course,
						"id_module"=>$id_module,
						"id_class"=>$id_class,
			        	"name"=>$_POST["name"],
			        	"url"=>$_POST["url"],
			        	"download"=>0
			        );
			        $this->_model->insertarVIDEO($datos);
				}
			}

			// $this->_view->assign('TARGET_DIR_PDF',TARGET_DIR_PDF);
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('videos',$this->_model->getVideos($id_class));
			$this->_view->assign('titulo','Vista curso');
			$this->_view->renderizar('clase_editar_video');
		}

		public function descargar_video($id_course=0,$id_module=0,$id_class=0,$id_audio=0,$download=0){
			$this->_acl->acceso('curse_descargar_audio');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_audio == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_audio,"id5"=>$download));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			$validador->name("id5")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
				exit();
			}
			if ($download==0) {
				$download=1;
			}else{
				$download=0;
			}
			$datos=array(
				"id"=>$id_audio,
	        	"download"=>$download
	        );
	        $this->_model->actualizarVIDEO($datos);
	        $this->redireccionar('cursos/editar_video/'.$id_course.'/'.$id_module.'/'.$id_class);
	        exit();
		}

		public function ver_video ($id_course=0,$id_module=0,$id_class=0,$id_pdf=0){
			$this->_acl->acceso('curse_ver_video');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_pdf == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Editar Video","fa fa-film","cursos/editar_video/".$id_course."/".$id_module."/".$id_class);
			$this->_view->setRutaSuave("Ver Video");

			$this->_view->assign('id1',$id_course);
			$this->_view->assign('id2',$id_module);
			$this->_view->assign('id3',$id_class);
			$this->_view->assign('id4',$id_pdf);

			

			$this->_view->assign('purldf',$id_course.'/'.$id_module.'/'.$id_class.'/'.$id_pdf);

			$this->_view->assign('titulo','Ver video');
			$this->_view->assign('descripcion','Ver video');
			//$datosaudio = $this->_model->getAudioAJAX($id_course,$id_module,$id_class,$id_pdf);
			//$this->_view->assign('datosaudio',$datosaudio);
			//$this->_view->assign('url_download',TARGET_DIR_AUDIO_WEB.$datosaudio["url"]);
			// $this->_view->setJs(array('oir_audio'));
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('videos',$this->_model->getClaseVideos($id_class));
			//$this->_view->setTemplate("viewaudio");
			$this->_view->renderizar('ver_video');
		}

		public function editar_foro ($id_course=0,$id_module=0,$id_class=0){
			$this->_acl->acceso('curse_editar_video');
			if ($id_module==0 || $id_course==0 || $id_class == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			//$this->_view->setRutaSuave("Editar Foro","fa fa-comments","cursos/clases/".$id_course."/".$id_module."/".$id_class);
			$this->_view->setRutaSuave("Editar Foro");

			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$validador = new ValidFluent($_POST);
				$validador->name("pregunta")->required("Invalido pregunta")->alfa()->minSize(3);
				if(!$validador->isGroupValid()){
					$this->_view->setAlertSis($validador->getError('pregunta'));
				}else{
					$datos=array(
			        	"id_course"=>$id_course,
						"id_module"=>$id_module,
						"id_class"=>$id_class,
			        	"question"=>$_POST["pregunta"]
			        );
			        $this->_model->insertarFORO($datos);
				}
			}

			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('icono_tipo',$this->iconos_clases());
			$this->_view->assign('preguntas',$this->_model->getPreguntas($id_class));
			$this->_view->assign('titulo','Editar Foro');
			$this->_view->renderizar('clase_editar_foro');
		}

		public function ver_foro ($id_course=0,$id_module=0,$id_class=0,$id_pdf=0){
			$this->_acl->acceso('curse_ver_foro');
			if ($id_module==0 || $id_course==0 || $id_class == 0 || $id_pdf == 0) {
				$this->redireccionar('cursos');
			}
			$this->getLibrary("validFluent");
			$validador = new ValidFluent(array("id"=>$id_module,"id2"=>$id_course,"id3"=>$id_class,"id4"=>$id_pdf));
			$validador->name("id")->required("Id invalido")->numberInteger();
			$validador->name("id2")->required("Id invalido")->numberInteger();
			$validador->name("id3")->required("Id invalido")->numberInteger();
			$validador->name("id4")->required("Id invalido")->numberInteger();
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			if(!$validador->isGroupValid()){
				$this->redireccionar('cursos');
			}
			$this->_view->setRutaSuave("Cursos","fa-pencil-square","cursos");
			$this->_view->setRutaSuave("Modulos","fa fa-th","cursos/modulos/".$id_course);
			$this->_view->setRutaSuave("Clases","fa fa-puzzle-piece","cursos/clases/".$id_course."/".$id_module);
			$this->_view->setRutaSuave("Editar Foro","fa fa-comments","cursos/clases/editar_foro/".$id_course."/".$id_module."/".$id_class);
			$this->_view->setRutaSuave("Ver Foro");

			$this->_view->assign('purldf',$id_course.'/'.$id_module.'/'.$id_class.'/'.$id_pdf);

			$this->_view->assign('titulo','Ver Foro');
			$this->_view->assign('descripcion','Ver video');
			//$datosaudio = $this->_model->getAudioAJAX($id_course,$id_module,$id_class,$id_pdf);
			//$this->_view->assign('datosaudio',$datosaudio);
			//$this->_view->assign('url_download',TARGET_DIR_AUDIO_WEB.$datosaudio["url"]);
			// $this->_view->setJs(array('oir_audio'));
			$this->_view->assign('datos',$this->_model->getClase($id_class));
			$this->_view->assign('preguntas',$this->_model->getPreguntas($id_class));
			$this->_view->renderizar('ver_foro');
		}

	}
