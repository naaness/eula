<?php 
	class gruposModel extends Model
	{
	    public function __construct() 
	    {
	        parent::__construct();
	    }

	    public function getGrupos(){
	    	$registro = $this->_db->query("SELECT * FROM  group_team ");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getUsuarios(){
	       $registro = $this->_db->query("SELECT * FROM acl_user WHERE state = 1");
	      	return $registro->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function insertarGrupo($datos){
	    	$this->insertarSQL($datos,"group_team");
	    }
	    public function editarGrupo($datos){
	    	$this->actualizarSQL($datos,"group_team");
	    }
	    public function getLastGropoId($id_user_creator){
	    	$registro = $this->_db->query("SELECT * FROM  group_team WHERE id_user_creator='$id_user_creator' ORDER BY id DESC LIMIT 1");
	      	return $registro->fetch();
	    }
	    public function eliminarGrupoLideres($id_group,$id_user){
            $this->_db->query(
                "DELETE FROM group_team_leader " .
                "WHERE id_group=$id_group AND id_user='$id_user'"
                );
        }
        public function editarGrupoLideres($id_group,$id_user){
            $this->_db->query("REPLACE INTO group_team_leader " .
            "SET id_group=$id_group, id_user='$id_user'"
            );
        }
        public function getGrupoNombre($id_group){
			$grupos = $this->_db->query(
				"SELECT * FROM group_team " .
				"WHERE id = '$id_group'"
			);
			$grupos = $grupos->fetch();
            return $grupos["name"];
		}
        public function getGrupoLider($id_group){
			$grupos = $this->_db->query(
				"SELECT * FROM group_team_leader " .
				"WHERE id_group = '$id_group'"
			);
			$grupos = $grupos->fetchAll(PDO::FETCH_ASSOC);
			$data = $this->getUserAll();
			for ($i=0; $i < count($grupos); $i++) {
				$data[$grupos[$i]['id_user']] = array(
					'id'=>$grupos[$i]['id_user'],
					'name' => $data[$grupos[$i]['id_user']]["name"],
					'valor'=>'1'
				);
			}
            return $data;
		}
		private function getUserAll(){
            $usuaerios = $this->_db->query("SELECT * FROM acl_user");
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
        public function getMisGrupos($id_user){
        	$datos = $this->_db->query(
				"SELECT r.* FROM group_team_leader w LEFT JOIN group_team r ON w.id_group = r.id " .
				"WHERE w.id_user = '$id_user'"
			);
			return $datos->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getGrupoLiderRegistro($id_group,$id_user){
        	$datos = $this->_db->query(
				"SELECT * FROM group_team_leader " .
				"WHERE id_group = '$id_group' AND id_user ='$id_user'"
			);
			return $datos->fetch();
        }

        public function getUsuariosGrupo($id_group){
			$grupos = $this->_db->query(
				"SELECT * FROM group_user " .
				"WHERE id_group = '$id_group'"
			);
			$grupos = $grupos->fetchAll(PDO::FETCH_ASSOC);
			$data = $this->getUserAll();
			for ($i=0; $i < count($grupos); $i++) {
				$data[$grupos[$i]['id_user']] = array(
					'id'=>$grupos[$i]['id_user'],
					'name' => $data[$grupos[$i]['id_user']]["name"],
					'valor'=>'1'
				);
			}
            return $data;
		}

		public function eliminarGrupoUsuarios($id_group,$id_user){
            $this->_db->query(
                "DELETE FROM group_user " .
                "WHERE id_group=$id_group AND id_user='$id_user'"
                );
        }
        public function editarGrupoUsuarios($id_group,$id_user){
            $this->_db->query("REPLACE INTO group_user " .
            "SET id_group=$id_group, id_user='$id_user'"
            );
        }
        public function getGrupoUserRegistro($id_group,$id_user){
        	$datos = $this->_db->query(
				"SELECT * FROM group_user " .
				"WHERE id_group = '$id_group' AND id_user ='$id_user'"
			);
			return $datos->fetch();
        }
	}