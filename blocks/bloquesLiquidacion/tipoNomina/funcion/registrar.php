<?php

namespace bloquesLiquidacion\tipoNomina\funcion;


include_once('Redireccionador.php');

class FormProcessor {
    
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;
    
    function __construct($lenguaje, $sql) {
        
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    
    }
    
    function procesarFormulario() {    

        //Aquí va la lógica de procesamiento
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
       
        
        
        
                
                if(isset($_REQUEST['tipoNomina'])){
                    switch($_REQUEST ['tipoNomina']){
                           case 1 :
					$_REQUEST ['tipoNomina']='Periodica';
			   break;
                       
                           case 2 :
					$_REQUEST ['tipoNomina']='Esporadica';
			   break;
                       
                           case 3 :
					$_REQUEST ['tipoNomina']='Mixta';
			   break;
                    }
                }
                
                if(isset($_REQUEST['estadoRegistroNomina'])){
                    switch($_REQUEST ['estadoRegistroNomina']){
                           case 1 :
					$_REQUEST ['estadoRegistroNomina']='Activo';
			   break;
                       
                           case 2 :
					$_REQUEST ['estadoRegistroNomina']='Inactivo';
			   break;
                    }
                }
                $periodo='';
                if(isset($_REQUEST['periodo'])){
                    switch($_REQUEST ['periodo']){
                                                
                           case 1 :
					$periodo='Enero';
			   break;
                           case 2 :
					$periodo='Febrero';
			   break;
                           case 3 :
					$periodo='Marzo';
			   break;
                           case 4 :
					$periodo='Abril';
			   break;
                           case 5 :
					$periodo='Mayo';
			   break;
                           case 6 :
					$periodo='Junio';
			   break;
                           case 7 :
					$periodo='Julio';
			   break;
                           case 8 :
					$periodo='Agosto';
			   break;
                           case 9 :
					$periodo='Septiembre';
			   break;
                           case 10 :
					$periodo='Octubre';
			   break;
                           case 11 :
					$periodo='Noviembre';
			   break;
                           case 12 :
					$periodo='Diciembre';
			   break;
                    }
                }
                
               
        
        $datos = array(
            
            'id' => $_REQUEST ['vinculacion'],
            'nombreNomina' => $_REQUEST ['nombreNomina'],
            'tipoNomina' => $_REQUEST ['tipoNomina'],
            'periodo' => $periodo,
            'estadoRegistroNomina' => $_REQUEST ['estadoRegistroNomina'],
            'descripcionNomina' => $_REQUEST ['descripcionNomina'],
            'variable' => $_REQUEST['variable']
        
        );
//       
       
                
//        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarRegistroNomina",$datos);
//        $resultado=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda",$datos,"insertarRegistroNomina");
//        //Al final se ejecuta la redirección la cual pasará el control a otra página
//         $arrayLeyes = explode(",", $_REQUEST['leyRegistros']);
//        $count = 0;
//       
//        
//        while($count < count($arrayLeyes)){
//        	
//        	$datosLeyesConcepto = array(
//        			'fk_id_ley' => $arrayLeyes[$count],
//        			'fk_concepto' => $resultado[0][0]
//        	);
//        	
//        	$cadenaSql = $this->miSql->getCadenaSql("insertarLeyesNomina",$datosLeyesConcepto);
//        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
//        	
//        	$count++;
//        
//        }
        exit;
        if (!empty($resultado)) {
              Redireccionador::redireccionar('inserto',$datos);
            exit();
        } else {
           Redireccionador::redireccionar('noInserto');
            exit();
        }
        
    	        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }
    
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado= $miProcesador->procesarFormulario ();

