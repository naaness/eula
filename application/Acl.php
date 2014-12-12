<?php
	class ACL
	{
		private $_db;
		private $_id;
		private $_role;
		private $_permisos;
		private $_username;
		function __construct($id=false)
		{

			if ($id) {
				$this->_id = (int) $id;
			}
			else{
				if (Session::get('id_usuario')) {
					$this->_id = Session::get('id_usuario');
				}
				else{
					$this->_id = 0; // valor qu restringe el acceso
				}
			}
			$this->_db = new DataBase;
			$this->_role = $this->getRole();
			$this->_permisos = $this->getPermisosRole();
			$this->_username=$this->getDataUsername($this->_id);;
			$this->compilarAcl();
			//SuperAdminEULA HjgzCgBEX0C4
			//AdminEULA 4sMRGzZNq3X7
		}
		public function compilarAcl()
		{
			
			$this->_permisos = array_merge(
				$this->_permisos,
				$this->getPermisoUsuario()
			);
		}
		public function getDataUsername($id){
			if ($id!=0) {
				$role = $this->_db->query(
					"SELECT * FROM acl_user " .
					"WHERE id = '$this->_id' "
				);
				$role = $role->fetch();
				return $role['username'];
			}else{
				return "";
			}
			
		}
		public function getUsername(){
			return $this->_username;
		}
		public function getRole()
		{
			
			$role = $this->_db->query(
				"SELECT * FROM acl_user " .
				"WHERE id = '$this->_id' "
			);
			$role = $role->fetch();
			return $role['id_role'];
		}
		public function getPermisosRoleId()
		{
			
			$ids = $this->_db->query(
				"SELECT id_key FROM acl_role_key " .
				"WHERE id_role = '$this->_role'"
			);
			$ids = $ids->fetchAll(PDO::FETCH_ASSOC);
			$id = array();
			for ($i=0; $i < count($ids); $i++) {
				$id[] = $ids[$i]['id_key'];
			}
			return $id;
		}
		public function getPermisosRole()
		{
			$permisos = $this->_db->query(
				"SELECT * FROM acl_role_key " .
				"WHERE id_role = '$this->_role'"
			);
			$permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);

			$data = array();
			for ($i=0; $i < count($permisos); $i++) {
				$key = $this->getPermisoKey($permisos[$i]['id_key']);
				if ($key=='') {
					continue;
				}
				if ($permisos[$i]['value']==1) {
					$v = true;
				}
				else
				{
					$v = false;
				}
				$data[$key] = array(
					'key' => $key,
					'permiso' => $this->getPermisoNombre($permisos[$i]['id_key']),
					'valor' => $v,
					'heredado' => true,
					'id'=>$permisos[$i]['id_key']
				);
			}

			return $data;
		}
		public function getPermisoKey($id_key)
		{
			$id_key = (int) $id_key;
			$key = $this->_db->query(
				"SELECT permission FROM acl_key " .
				"WHERE id = '$id_key'"
			);
			$key = $key->fetch();
			return $key['permission'];
		}
		public function getPermisoNombre($id_key)
		{
			$id_key = (int) $id_key;
			$key = $this->_db->query(
				"SELECT name FROM acl_key " .
				"WHERE id = '$id_key'"
			);
			$key = $key->fetch();
			return $key['name'];
		}
		public function getPermisoUsuario()
		{
			$id = $this->getPermisosRoleId();
			if (count($id)) {
				$permisos = $this->_db->query(
					"SELECT * FROM acl_user_key " .
					"WHERE id_user = '$this->_id' " .
					"AND id_key in (" . implode(",", $id) . ")"
				);
				$permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				$permisos = array();
			}
			$data = array();
			for ($i=0; $i < count($permisos); $i++) {
				$key = $this->getPermisoKey($permisos[$i]['id_key']);
				if ($key=='') {
					continue;
				}
				if ($permisos[$i]['value']==1) {
					$v = 1;
				}
				else
				{
					$v = 0;
				}
				$data[$key] = array(
					'id_key' => $key,
					'permiso' => $this->getPermisoNombre($permisos[$i]['id_key']),
					'valor' => $v,
					'heredado' => false,
					'id'=>$permisos[$i]['id_key']
				);
			}
			return $data;
		}
		public function getPermisos()
		{
			if (is_array($this->_permisos)) {
				return $this->_permisos;
			}
		}
		public function permiso ($key)
		{	
			// return true;
			if ($this->_id==0) {
				return false;
			}
			if(array_key_exists($key,$this->_permisos)){
				if($this->_permisos[$key]["valor"] == true || $this->_permisos[$key]["valor"] == 1){
					return true;
					
				}else{
					return false;
				}
			}else{
				return true;
			}
		}
		public function acceso($key)
		{
			# Se modifica la funcion de acceso, sigue las siguientes reglas:
			# Si la llave no existe entonces se permite pasar el usuario
			# Si la llave existe, entonces verifica si el acceso es permitido o no,
			# restringuiendo el acceso y redireccionando a la ultima pagina visitada.
			# para esto ultimo se combina con variables se sesion.
			# la last_url se carga justo antes de renderizar la visita.
			$acceso= $this->permiso($key);
		    if (!$acceso) {
		    	# Se obtiene la ruta que se intenta rendedizar y compararla con la anterior
		    	# De esta forma se evita el BUCLE
		    	$url = filter_input(INPUT_GET, "url",FILTER_SANITIZE_URL);
				$url = explode("/", $url);
				$url = array_filter($url);
				$url = implode("/",$url);
				$ruta = Session::get("last_url");
				if ($url!=$ruta) {
					header("location:" . BASE_URL . $ruta);
				}else{
					header("location:" . BASE_URL . "index");
				}
				exit();
				
		    }
		    // return $this->getRole();
		}
		public function acceso_bloque($key)
		{
			return $this->permiso($key);
		}
		public function getId(){
			return $this->_id;
		}
	}
?>
