<?

namespace bloquesModelo\bloqueContenido;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $miFormulario;
	var 

	$miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
                $_REQUEST['botonRegistrarEPS']='false';
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->miFormulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
        if(isset($_REQUEST['opcion'])){
            
            if($_REQUEST['botonRegistrarEPS'] == 'true'){
                $_REQUEST ['opcion']="registrar";
               
            }
//            if($_REQUEST['botonModificar'] == 'true' ){
//                $_REQUEST ['opcion']="modificar";
//            }
//            if($_REQUEST['botonVerDetalle'] == 'true'){
//                $_REQUEST ['opcion']="detalle";
//            }
//            if($_REQUEST['botonInactivar'] == 'true'){
//               echo '<script>alert("ingresaaaaaaaaa")</script>';
//                $_REQUEST ['opcion']="inactivar";
//                
//            }
               
                           switch ($_REQUEST ['opcion']) {
				
				case "registrar" :
                                    
					include_once ($this->ruta . "/formulario/registrar.php");
					break;
				
				case "modificar":
					include_once($this->ruta."/formulario/modificar.php");
					break;	
                                case "mostrar":
					include_once ($this->ruta . "/formulario/muestra.php");
					break;	 
                                case "form":
					include_once ($this->ruta . "/formulario/form.php");
					break;
                                 case "inactivar":
					include_once ($this->ruta . "/formulario/inactivar.php");
					break;	 
                                case "detalle":
					include_once ($this->ruta . "/formulario/detalle.php");
					break;	
        		}
		}else{
			include_once ($this->ruta . "/formulario/form.php");
		}
	}
}
?>
