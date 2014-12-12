<?php 
	class usuariosModel extends Model
	{
	    public function __construct() 
	    {
	        parent::__construct();
	    }
	    
	    public function getUsuarios()
	    {
	       $usuarios = $this->_db->query(
	       		"SELECT u.*,r.role FROM acl_user u LEFT JOIN acl_role r " .
	       		"ON u.id_role = r.id"
	       		);
	      	return $usuarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	     public function getUsuario($id_usuario)
	    {
	    	$usuarios = $this->_db->query(
	       		"SELECT u.name,r.role FROM acl_user u LEFT JOIN acl_role r " .
	       		"ON u.id_role = r.id WHERE u.id = $id_usuario"
	       		);
	      	return $usuarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getPermisosUsuario($id_usuario)
	    {
	    	$acl = new ACL($id_usuario);
	    	return $acl->getPermisos();
	    }
	    public function getPermisosRole($id_usuario)
	    {
	    	$acl = new ACL($id_usuario);
	    	return $acl->getPermisosRole();
	    }
	    public function eliminarPermiso($id_usuario, $id_permiso)
	    {
	    	$this->_db->query(
	       		"DELETE FROM acl_user_key WHERE " .
	       		"id_user = $id_usuario AND id_key = $id_permiso"
	       		);
	    }
	    public function editarPermiso($id_usuario, $id_permiso, $valor)
	    {
	    	$this->_db->query(
	       		"REPLACE INTO acl_user_key SET " .
	       		"id_user = $id_usuario, id_key = $id_permiso, value = '$valor'"
	       		);
	    }
	    public function getRoles()
	    {
	    	$role = $this->_db->query("SELECT * FROM acl_role");
	      	return $role->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function editarUsuarioRole($datos)
	    {
	  		//   	$id = (int) $id_usuario;
	  		//   	$id_r = (int) $id_role;
			// $this->_db->prepare("UPDATE acl_user SET id_role = :roleu WHERE id = :id")
			// 		->execute(
			// 			array(
			// 				'id'=>$id_usuario,
			// 				'roleu'=>$id_role
			// 			)
			// 		);
	    	
			$this->actualizarSQL($datos,"acl_user");
	    }

	   	public function crearUsuario($datos){
	   		 $this->insertarSQL($datos,"acl_user");
	   	}
	   	public function actualizarUsuario($datos){
	   		$this->actualizarSQL($datos,"acl_user");
	   	}
	}