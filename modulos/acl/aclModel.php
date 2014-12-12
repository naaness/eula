<?php
    class aclModel extends Model{
        public function __construct(){
            parent::__construct();
        }
        public function getRole($id_role){
            $role = $this->_db->query("SELECT * FROM acl_role WHERE id='$id_role'");
            return $role->fetch();
        }
        public function getPermiso($id_permiso)
        {
            $permiso = $this->_db->query("SELECT * FROM acl_key WHERE id='$id_permiso'");
            return $permiso->fetch();
        }
        public function getRoles(){
            $role = $this->_db->query("SELECT * FROM acl_role");
            return $role->fetchAll();
        }
        public function getPermisosAll(){
            $permisos = $this->_db->query("SELECT * FROM acl_key");
            $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
            $data=array();
            for ($i=0; $i <count($permisos) ; $i++) {
                if ($permisos[$i]['permission']=='') {
                    continue;
                }
                $data[$permisos[$i]['permission']] = array(
                    'key'=>$permisos[$i]['permission'],
                    'valor'=>'x',
                    'nombre'=>$permisos[$i]['name'],
                    'id' => $permisos[$i]['id']
                );
            }
            return $data;
        }
        public function getPermisosRole($id_role){
            $data = array();
            $permisos = $this->_db->query("SELECT * FROM acl_role_key WHERE id_role='$id_role'");
            $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i <count($permisos) ; $i++) {
                $key = $this->getPermisoKey($permisos[$i]['id_key']);
                if ($key=='') {
                    continue;
                }
                if ($permisos[$i]['value']==1) {
                    $v=1;
                }else{
                    $v=0;
                }
                $data[$key] = array(
                    'key'=>$key,
                    'valor'=>$v,
                    'nombre'=> $this->getPermisoNombre($permisos[$i]['id_key']),
                    'id' => $permisos[$i]['id_key']
                    );
            }
            $data = array_merge($this->getPermisosAll(),$data);
            return $data;
        }
        public function eliminarPermisoRole($id_role,$id_key){
            $this->_db->query(
                "DELETE FROM acl_role_key " .
                "WHERE id_role=$id_role AND id_key='$id_key'"
                );
        }
        public function editarPermisoRole($id_role,$id_key, $valor){
            $this->_db->query("REPLACE INTO acl_role_key " .
            "SET id_role=$id_role, id_key='$id_key', value='$valor'"
            );
        }
        public function getPermisoKey($valor){
            $valor = (int) $valor;
            $key = $this->_db->query("SELECT permission FROM acl_key " .
            "WHERE id = {$valor}");
            $key = $key->fetch();
            return $key['permission'];
        }
        public function getPermisoNombre($valor){
            $valor = (int) $valor;
            $key = $this->_db->query(
                "SELECT name FROM acl_key " .
                "WHERE id = '$valor'"
                );
            $key = $key->fetch();
            return $key['name'];	
        }
        public function insertarRole($role){
            $this->_db->query("INSERT INTO acl_role VALUES(null, '{$role}')");
        }
        public function editarRole($id_role,$role){	
            $id = (int) $id_role;
            $this->_db->prepare("UPDATE acl_role SET role = :nombre_role WHERE id = :id")
            ->execute(
                array(
                    'id'=>$id,
                    'nombre_role'=>$role
                )
            );
        }
        public function editarPermiso($datos){
            // $id = (int) $id_permiso;
            // $this->_db->prepare("UPDATE acl_key SET name = :nombre_permiso, key = :llavep WHERE id = :id")
            // ->execute(
            //     array(
            //         'id'=>$id,
            //         'nombre_permiso'=>$permiso,
            //         'llavep'=>$llave
            //     )
            // );
            $this->actualizarSQL($datos,"acl_key");
        }
        public function eliminarRole($id_role){
            $id = (int) $id_role;
            $this->_db->query(
                "DELETE FROM acl_role " .
                "WHERE id=$id"	 
            );
        }
        public function eliminarPermiso($id_permiso){
            $id = (int) $id_permiso;
            $this->_db->query("DELETE FROM acl_key " .
            "WHERE id='$id_permiso'"
            );
        }
        public function insertarPermiso($datosEnviar){
            $this->insertarSQL($datosEnviar,"acl_key");
        }
        public function getPermisos(){
            $permisos = $this->_db->query("SELECT * FROM acl_key");
            return $permisos->fetchAll(PDO::FETCH_ASSOC);
        }
    }