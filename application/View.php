<?php
	require_once ROOT . 'libs' . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php'; //VT13 agregar la libreria para plantillas
	class View extends Smarty // VT13 se extiende a plantillas
	{
		private $_controlador;
		private $_js;
		private $_css;
		private $_acl;
		private $_template;
		private static $_item;
		private $_widget;
		private $_ruta_suave;
		private $_alerts_sis;
		private $_emails_sis;
		private $_tasks_sis;
		private $_Nametemplate;


		public function __construct(Request $peticion, ACL $_acl) //VT15 nuevo parametro ACL
		{
			parent::__construct();//VT13 constructuro de la clase plantilla
			$this->_controlador=$peticion->getControlador();// obtiene el controlador
			$this->_js=array();
			$this->_acl = $_acl;
			$this->_template = DEFAULT_LAYOUT;
			$this->_ruta_suave= array();
			$this->_alerts_sis= array();
			$this->_emails_sis= array();
			$this->_tasks_sis= array();
			self::$_item = null;
			$this->_Nametemplate ="template";
			
		}
		public function setRutaSuave($name, $ico="fa-dashboard", $url=""){
			if (trim($name)!="") {
				$this->_ruta_suave[]=array(
					"url"=>$url,
					"ico"=>$ico,
					"name"=>$name
				);
			}
		}
		public function setAlertSis($message, $class="fa fa-warning danger", $url="#"){
			if (trim($message)!="") {
				$this->_alerts_sis[]=array(
					"message"=>$message,
					"class"=>$class,
					"url"=>$url
				);
			}
		}
		public function setEmailSis($message, $title="title", $url="#", $time="Today", $dir_img="img/avatar3.png"){
			if (trim($message)!="") {
				$this->_emails_sis[]=array(
					"message"=>$message,
					"title"=>$title,
					"url"=>$url,
					"time"=>$time,
					"dir_img"=>$dir_img
				);
			}
			
		}
		public function setTasksSis($title, $percent="50", $color="green", $url="#"){
			if (trim($title)!="") {
				$this->_tasks_sis[]=array(
					"title"=>$title,
					"percent"=>$percent,
					"color"=>$color,
					"url"=>$url
				);
			}
		}
		public function IsAlertSis(){
			if (count($this->_alerts_sis)>0) {
				return true;
			}
			return false;
		}
		public function renderizar($vista, $item=false)
		{
			//VT13 se agrego el folder tmp, dentro cache y template para almacenar archivos temporales
			$this->template_dir = ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS;
			$this->config_dir =  ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs' . DS;
			$this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
			$this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;



			if($item!=false){
				define("ID_ITEM",$item);
			}else{
				define("ID_ITEM","");
			}

			$js=array();//inicia un arreglo que almacenara los archivos de java script

			if (count($this->_js)) { //carga todos jscript que se necesitan
				$js = $this->_js;
			}

			$css=array();//inicia un arreglo que almacenara los archivos de java script

			if (count($this->_css)) { //carga todos jscript que se necesitan
				$css = $this->_css;
			}

			$_layoutParams = array(
				'ruta_css' => BASE_URL . 'views/layout/' . $this->_template . '/css/',
				'ruta_js' => BASE_URL . 'views/layout/' . $this->_template . '/js/',
				'ruta_img' => BASE_URL . 'views/layout/' . $this->_template . '/img/',
				"ruta_bootstrap"=>BASE_URL . "public/bootstrap/",
				//'menu_cuenta'=>$menu_cuenta,
				'js' => $js,
				'css' => $css,
				'root'=> BASE_URL,
				"number_format"=>NUMBER_FORMAT,
				'btn_create'=>BTN_CREATE,
				'btn_return'=>BTN_RETURN,
				'btn_remove'=>BTN_REMOVE,
				'btn_view'=> BTN_VIEW,
				'icon_remove'=>ICON_REMOVE,
				'icon_view'=>ICON_VIEW,
				'icon_saved'=>ICON_SAVED,
				'configs'=>array(//VT13 se guardan las constantes de configuracion
					'app_name' => APP_NAME,
					'app_slogan' =>APP_ESLOGAN,
					'app_company' => APP_COMPANY
				),
				'autenticado'=>SESSION::get("autenticado"),
				'nombre_usuario'=>SESSION::get("nombre_usuario")

			);
			// fin de parametros

			$rutaview = ROOT . 'modulos' . DS . $this->_controlador. DS . "views" . DS . $vista . '.tpl'; //genera la ruta

			//$rutaview = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl'; // VT13 cmabio de pthl a ptl, por el uso de la libreria de plantillas

			if (is_readable($rutaview)) { // aqui se carga las diferentes partes la vista
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php'; // VT13 ya no se necesitara por el uso de plantilla
				//include_once $rutaview; //VT13 ahora llamar el metodo assign de smarty
				$this->assign('_contenido', $rutaview);//VT13 llama la vista para que se cargue en el template
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';  // VT13 ya no se necesitara por el uso de plantilla
			}
			else
			{
				throw new Exception("Error de vista");

			}

			$this->assign("widgets",$this->getWidgets());
			$this->assign("anio",date("Y"));
			$this->assign('_acl',$this->_acl);
			$this->assign('_layoutParams',$_layoutParams); // BT13 Assignar los paramentros

			# Almacenar en seccion la ultima vista visitada con sus respectivos argumentos
			$url = filter_input(INPUT_GET, "url",FILTER_SANITIZE_URL);
			$url = explode("/", $url);
			$url = array_filter($url);
			$url = implode("/",$url);
			Session::set("last_url",$url);
			
			// Agregar esto en el caso que todo los recursos del template esten en la misma carpeta
			$this->assign('template_dir',BASE_URL . 'views/layout/' . $this->_template . '/');
			// Agregar la ruta suave al template
			$this->assign('ruta_suave',$this->_ruta_suave);
			$this->assign('alerts_sis',$this->_alerts_sis);
			$this->assign('emails_sis',$this->_emails_sis);
			$this->assign('tasks_sis',$this->_tasks_sis);
			$this->display($this->_Nametemplate.'.tpl'); //VT13 llamar el template
		}
		public function renderizarBasico($vista, $n=false)
		{
			// VT13 se agrego el folder tmp, dentro cache y template para almacenar archivos temporales
			$this->template_dir = ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS;
			$this->config_dir =  ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs' . DS;
			$this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
			$this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;
			
			$rutaview = ROOT . 'modulos' . DS . $this->_controlador. DS . "views" . DS . $vista . '.tpl'; //genera la ruta

			//$rutaview = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl'; // VT13 cmabio de pthl a ptl, por el uso de la libreria de plantillas

			if (is_readable($rutaview)) { // aqui se carga las diferentes partes la vista
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php'; // VT13 ya no se necesitara por el uso de plantilla
				//include_once $rutaview; //VT13 ahora llamar el metodo assign de smarty
				$this->assign('_contenido', $rutaview);//VT13 llama la vista para que se cargue en el template
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';  // VT13 ya no se necesitara por el uso de plantilla
			}
			else
			{
				throw new Exception("Error de vista");

			}
			$this->display('basico.tpl'); //VT13 llamar el template
		}
		public function setJs (array $js)
		{
			if (is_array($js) && count($js))
			{
				for ($i=0; $i < count($js); $i++) {
					$this->_js[] = BASE_URL . 'modulos' . DS . $this->_controlador . DS . 'views/js/' . $js[$i] . '.js';
				}
			}
			else
			{
				throw new Exception("Error de js");
			}
		}



		public function setCss (array $css){

			if (is_array($css) && count($css)){
				for ($i=0; $i < count($css); $i++) {
					$this->_css[] = BASE_URL . 'modulos' . DS . $this->_controlador . DS . 'views/css/' . $css[$i] . '.css';
				}
			}else{
				throw new Exception("Error de css");
			}
		}

		public function setTemplate($template){
			$this->_template = (string) $template;
		}
		public function setNameTemplate($_Nametemplate){
			$this->_Nametemplate = (string) $_Nametemplate;
		}
		public function widget($widget, $method, $options = array())
    	{
        if(!is_array($options)){
            $options = array($options);
        }

        if(is_readable(ROOT . 'widgets' . DS . $widget . '.php')){
            include_once ROOT . 'widgets' . DS . $widget . '.php';

            $widgetClass = $widget . 'Widget';

            if(!class_exists($widgetClass)){
                throw new Exception('Error clase widget');
            }

            if(is_callable($widgetClass, $method)){
                if(count($options)){
                    return call_user_func_array(array(new $widgetClass, $method), $options);
                }
                else{
                    return call_user_func(array(new $widgetClass, $method));
                }
            }

            throw new Exception('Error metodo widget');
        }

        throw new Exception('Error de widget');
    }

    public function getLayoutPositions()
    {
        if(is_readable(ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs.php')){
            include_once ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs.php';

            return get_layout_positions();
        }

        throw new Exception('Error configuracion layout');
    }

    private function getWidgets()
    {
        $widgets = array(
            'menu-top' => array(
              'config' => $this->widget('menu', 'getConfig', array('top')),
              'content' => array('menu', 'getMenu', array('top', 'top'))
            ),

						'menu-secs' => array(
							'config' => $this->widget('menuSecs', 'getConfig', array('top')),
							'content' => array('menuSecs', 'getMenu', array('top', 'top'))
						),



        );

        $positions = $this->getLayoutPositions();
        $keys = array_keys($widgets);

        foreach($keys as $k){
            /* verificar si la posicion del widget esta presente */
            if(isset($positions[$widgets[$k]['config']['position']])){
                /* verificar si esta deshabilitado para la vista */
                if(!isset($widgets[$k]['config']['hide']) || !in_array(self::$_item, $widgets[$k]['config']['hide'])){
                    /* verificar si esta habilitado para la vista */
                    if($widgets[$k]['config']['show'] === 'all' || in_array(self::$_item, $widgets[$k]['config']['show'])){
                        if(isset($this->_widget[$k]))
                        {
                            $widgets[$k]['content'][2] = $this->_widget[$k];
                        }

                        /* llenar la posicion del layout */
                        $positions[$widgets[$k]['config']['position']][] = $this->getWidgetContent($widgets[$k]['content']);
                    }
                }
            }
        }

        return $positions;
    }

    public function getWidgetContent(array $content)
    {
        if(!isset($content[0]) || !isset($content[1])){
            throw new Exception('Error contenido widget');
            return;
        }

        if(!isset($content[2])){
            $content[2] = array();
        }

        return $this->widget($content[0],$content[1],$content[2]);
    }

    public function setWidgetOptions($key, $options)
    {
        $this->_widget[$key] = $options;
    }

	}

?>
