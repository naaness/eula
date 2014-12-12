<?php
	class Model
	{
		protected $_db;

		public function __construct(){
			$this->_registry = Registry::getInstancia();
			$this->_db = $this->_registry->_db;
		}
		public function insertarSQL($arreglo,$tabla)
		{
			$arra = array_keys($arreglo);
	    	$cadena1="";
	    	$cadena2="";
	    	foreach ($arra as $value) {
	    		$cadena1.=$value .", ";
	    		$cadena2.=":".$value .", ";
	    	}
	    	$cadena1= substr($cadena1, 0, strlen($cadena1)-2);
	    	$cadena2= substr($cadena2, 0, strlen($cadena2)-2);

	    	$resul=$this->_db->prepare("
            	INSERT INTO `". $tabla ."`
            	(
					" . $cadena1 . "
				)
        		VALUES (
					" . $cadena2 . "
            	)"
            )
            ->execute(
                $arreglo
            );
            if (!$resul) {
            	echo "Ha ocurrido un error almacendando la informacion. Verifique el nombre de cada columna, columnas no nulas.<br>";
            }
		}
		public function actualizarSQL($arreglo,$tabla)
		{
			$arra = array_keys($arreglo);
	    	$cadena="";
	    	$prime="";
	    	foreach ($arra as $value) {
	    		if ($prime=="") {
	    			$prime = " WHERE " . $value . " = :"  . $value;
	    		}
	    		else
	    		{
	    			$cadena.=" ". $value . " = :"  . $value .",";
	    		}
	    	}
	    	$cadena= substr($cadena, 0, strlen($cadena)-1). $prime;

	    	$resul=$this->_db->prepare("
            	UPDATE ". $tabla ." SET
                ".  $cadena
                )
                ->execute(
                    $arreglo
                );
            if (!$resul) {
            	echo "Ha ocurrido un error actualizando la informacion. Verifique el nombre de cada columna, columnas no nulas.<br>";
            }
		}
	}
