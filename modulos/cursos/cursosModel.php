<?php 
	class cursosModel extends Model
	{
		private $_id_role;
	    public function __construct() 
	    {
	        parent::__construct();
	        // El actual id del role profesor es 3
	        $this->_id_role=3;
	    }
	    public function getCursos(){
	    	$registro = $this->_db->query("SELECT * FROM course");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getProfesores(){
	       	$registro = $this->_db->query("SELECT * FROM acl_user WHERE id_role='$this->_id_role' AND state = 1");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function insertarCurso($datos){
	    	$this->insertarSQL($datos,"course");
	    }
	    public function getLastCursoId($id_user_creator){
	    	$registro = $this->_db->query("SELECT * FROM  course WHERE id_user_creator='$id_user_creator' ORDER BY id DESC LIMIT 1");
	      	return $registro->fetch();
	    }
	    public function getCursoProfesorRegistro($id_course,$id_teacher){
        	$datos = $this->_db->query(
				"SELECT * FROM course_teacher " .
				"WHERE id_course = '$id_course' AND id_teacher ='$id_teacher'"
			);
			return $datos->fetch();
        }
         public function eliminarCursoProfesores($id_course,$id_teacher){
            $this->_db->query(
                "DELETE FROM course_teacher " .
                "WHERE id_course=$id_course AND id_teacher='$id_teacher'"
                );
        }
        public function editarCursoProfesores($id_course,$id_teacher){
            $this->_db->query("REPLACE INTO course_teacher " .
            "SET id_course=$id_course, id_teacher='$id_teacher'"
            );
        }
        public function getCursoProfesor($id_course){
			$cursos = $this->_db->query(
				"SELECT * FROM course_teacher " .
				"WHERE id_course = '$id_course'"
			);
			$cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
			$data = $this->getUserAllTeacher();
			for ($i=0; $i < count($cursos); $i++) {
				$data[$cursos[$i]['id_teacher']] = array(
					'id'=>$cursos[$i]['id_teacher'],
					'name' => $data[$cursos[$i]['id_teacher']]["name"],
					'valor'=>'1'
				);
			}
            return $data;
		}
		private function getUserAllTeacher(){
            $usuaerios = $this->_db->query("SELECT * FROM acl_user WHERE id_role='$this->_id_role' AND state = 1 ");
            $usuaerios = $usuaerios->fetchAll(PDO::FETCH_ASSOC);
            $data=array();
            for ($i=0; $i <count($usuaerios) ; $i++) {
            	if ($usuaerios[$i]['id']=='') {
                    continue;
                }
                $data[$usuaerios[$i]['id']] = array(
                	'id'=>$usuaerios[$i]['id'],
                    'name' => $usuaerios[$i]['name'],
					'valor'=>'x'
                );
            }
            return $data;
        }
        public function getCurso($id_course){
        	$registro = $this->_db->query("SELECT * FROM course WHERE id='$id_course'");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
        }
        public function editarCurso($datos){
	    	$this->actualizarSQL($datos,"course");
	    }
	    public function getGruposCurso($id_course){
	    	$cursos = $this->_db->query(
				"SELECT * FROM course_group " .
				"WHERE id_course = '$id_course'"
			);
			$cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
			$data = $this->getUserAllGroup();
			for ($i=0; $i < count($cursos); $i++) {
				$data[$cursos[$i]['id_group']] = array(
					'id'=>$cursos[$i]['id_group'],
					'name' => $data[$cursos[$i]['id_group']]["name"],
					'valor'=>'1'
				);
			}
            return $data;
	    }
	    private function getUserAllGroup(){
            $usuaerios = $this->_db->query("SELECT * FROM group_team ");
            $usuaerios = $usuaerios->fetchAll(PDO::FETCH_ASSOC);
            $data=array();
            for ($i=0; $i <count($usuaerios) ; $i++) {
            	if ($usuaerios[$i]['id']=='') {
                    continue;
                }
                $data[$usuaerios[$i]['id']] = array(
                	'id'=>$usuaerios[$i]['id'],
                    'name' => $usuaerios[$i]['name'],
					'valor'=>'x'
                );
            }
            return $data;
        }
        public function getCursoGrupoRegistro ($id_course,$id_group){
        	$datos = $this->_db->query(
				"SELECT * FROM course_group " .
				"WHERE id_course = '$id_course' AND id_group ='$id_group'"
			);
			return $datos->fetch();
        }
        public function eliminarCursoGrupos($id_course,$id_group){
            $this->_db->query(
                "DELETE FROM course_group " .
                "WHERE id_course=$id_course AND id_group='$id_group'"
                );
        }
        public function editarCursoGrupos($id_course,$id_group){
            $this->_db->query("REPLACE INTO course_group " .
            "SET id_course=$id_course, id_group='$id_group'"
            );
        }
        public function getUsuarios(){
	       	$registro = $this->_db->query("SELECT * FROM acl_user WHERE state = 1");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function eliminarCursoUsuarios($id_course,$id_user){
            $this->_db->query(
                "DELETE FROM course_user " .
                "WHERE id_course=$id_course AND id_user='$id_user'"
                );
        }
        public function editarCursoUsuarios($id_course,$id_user){
            $this->_db->query("REPLACE INTO course_user " .
            "SET id_course=$id_course, id_user='$id_user'"
            );
        }
        public function getUsuariosCurso($id_course){
	    	$cursos = $this->_db->query(
				"SELECT * FROM course_user " .
				"WHERE id_course = '$id_course'"
			);
			$cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
			$data = $this->getUserAll();
			for ($i=0; $i < count($cursos); $i++) {
				$data[$cursos[$i]['id_user']] = array(
					'id'=>$cursos[$i]['id_user'],
					'name' => $data[$cursos[$i]['id_user']]["name"],
					'valor'=>'1'
				);
			}
            return $data;
	    }
	    private function getUserAll(){
            $usuaerios = $this->_db->query("SELECT * FROM acl_user ");
            $usuaerios = $usuaerios->fetchAll(PDO::FETCH_ASSOC);
            $data=array();
            for ($i=0; $i <count($usuaerios) ; $i++) {
            	if ($usuaerios[$i]['id']=='') {
                    continue;
                }
                $data[$usuaerios[$i]['id']] = array(
                	'id'=>$usuaerios[$i]['id'],
                    'name' => $usuaerios[$i]['name'],
					'valor'=>'x'
                );
            }
            return $data;
        }
        public function getCursoUsuarioRegistro ($id_course,$id_user){
        	$datos = $this->_db->query(
				"SELECT * FROM course_user " .
				"WHERE id_course = '$id_course' AND id_user ='$id_user'"
			);
			return $datos->fetch();
        }
        public function insertarModulo($datos){
        	$this->insertarSQL($datos,"module");
        }
        public function getModulos($id_course){
        	$datos = $this->_db->query("SELECT * FROM module WHERE id_course='$id_course'");
        	return $datos->fetchAll(PDO::FETCH_ASSOC);
        }
        public function actuaizarModulo($datos){
        	$this->actualizarSQL($datos,"module");
        }
        public function getModulo($id){
        	$datos = $this->_db->query(
				"SELECT * FROM module " .
				"WHERE id = '$id'"
			);
			$datos = $datos->fetch();
			print_r($datos);
			return $datos;
        }
        public function getCursoProfesoresClase($id_course){
            $data = $this->_db->query(
                "SELECT w.* FROM course_teacher r LEFT JOIN acl_user w ON w.id = r.id_teacher " .
                "WHERE id_course = '$id_course'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getUsuariosCursoClase($id_course){
            $data = $this->_db->query(
                "SELECT * FROM course_user " .
                "WHERE id_course = '$id_course'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function insertarClase($datos){
            $this->insertarSQL($datos,"class");
        }
        public function getLastClaseId($id_user_creator){
            $registro = $this->_db->query("SELECT * FROM  class WHERE id_user_creator='$id_user_creator' ORDER BY id DESC LIMIT 1");
            return $registro->fetch();
        }
        public function insertarUsuarioClase ($datos){
            $this->insertarSQL($datos,"class_student");
        }
        public function getClasesModulosCursos($id_course,$id_module){
            $data = $this->_db->query(
                "SELECT * FROM class " .
                "WHERE id_course = '$id_course' AND id_module='$id_module'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getClasesCursos($id_course){
            $data = $this->_db->query( "SELECT r.*, w.name as name_module FROM class r LEFT JOIN module w ON r.id_module =w.id " .
                "WHERE r.id_course = '$id_course'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getClase($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class " .
                "WHERE id = '$id_class'"
            );
            return $data->fetch();
        }
        public function actualizarClase($datos){
            $this->actualizarSQL($datos,"class");
        }
        public function insertarPDF($datos){
            $this->insertarSQL($datos,"class_pdf");
        }
        public function getPDFs($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_pdf " .
                "WHERE id_class = '$id_class'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getPDFAJAX ($id_course,$id_module,$id_class,$id){
            $data = $this->_db->query(
                "SELECT * FROM class_pdf " .
                "WHERE id = '$id' AND id_course = '$id_course'  AND id_module = '$id_module'  AND id_class = '$id_class'"
            );
            return $data->fetch();
        }

        public function actualizarPDF($datos){
            $this->actualizarSQL($datos,"class_pdf");
        }
        public function getAudios($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_audio " .
                "WHERE id_class = '$id_class'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function insertarAudio($datos){
            $this->insertarSQL($datos,"class_audio");
        }
        public function actualizarAudio ($datos){
            $this->actualizarSQL($datos,"class_audio");
        }

        public function getAudioAJAX ($id_course,$id_module,$id_class,$id){
            $data = $this->_db->query(
                "SELECT * FROM class_audio " .
                "WHERE id = '$id' AND id_course = '$id_course'  AND id_module = '$id_module'  AND id_class = '$id_class'"
            );
            return $data->fetch();
        }
        public function getAudiosAJAX ($id_course,$id_module,$id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_audio " .
                "WHERE id_course = '$id_course'  AND id_module = '$id_module'  AND id_class = '$id_class'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getVideos($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_video " .
                "WHERE id_class = '$id_class'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        public function insertarVIDEO($datos){
            $this->insertarSQL($datos,"class_video");
        }

        public function actualizarVIDEO ($datos){
            $this->actualizarSQL($datos,"class_video");
        }

        public function getClaseVideos($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_video " .
                "WHERE id_class = '$id_class'"
            );
            $data = $data->fetchAll(PDO::FETCH_ASSOC);
            $new_data=array();
            foreach ($data as $key) {
                $url = explode("/", $key["url"]);
                $new_data[]=array(
                    "name"=>$key["name"],
                    "url"=>$url[count($url)-1]
                );
            }
            return $new_data;
        }

        public function getPreguntas($id_class){
            $data = $this->_db->query(
                "SELECT * FROM class_foro " .
                "WHERE id_class = '$id_class'"
            );
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insertarFORO($datos){
            $this->insertarSQL($datos,"class_foro");
        }
	}