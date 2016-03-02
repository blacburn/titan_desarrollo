<?php

namespace bloquesNovedad\gestionNovedad\funcion;

include_once('Redireccionador.php');
include_once('Interprete.php');
include_once('NodoConcepto.php');

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
        
        
        
        //***************************VALIDAR Formula*****************************************************************
        
        
        
        //-------------------------- Seccion Validar Formula ------------------------------------------------
		//-------------------------------------------------------------------------------------------------------
             
        $_entradaFormulaCompilador = $_REQUEST['formulaConcepto'];
        
      
  
        
//        Interprete::evaluarSentencia($_entradaFormulaCompilador);
       $interprete = new Interprete();

//    $sentencia = 'IVAAA+((2+3)*RESRD)/+4-5';

$aceptado = $interprete->evaluarSentencia($_entradaFormulaCompilador);

echo "<br>".$aceptado."<br>";



//$arbol = $interprete->generarArbol($_entradaFormulaCompilador);
        
        //----------------------------------------------------------------------------------------------------------
        //------------------------ Codigo A Ejecutar Una Vez VALIDADA la Formula -----------------------------------
        
        if(isset($_REQUEST['naturalezaCon'])){
        	switch($_REQUEST['naturalezaCon']){
        		case 1 :
        			$_REQUEST['naturalezaCon']='Devenga';
        			break;
        		case 2 :
        			$_REQUEST['naturalezaCon']='Deduce';
        			break;
        	}
        }
        if(isset($_REQUEST['tipoNovedadCon'])){
        	switch($_REQUEST['tipoNovedadCon']){
        		case 1 :
        			$_REQUEST['tipoNovedadCon']='Periodica';
        			break;
        		case 2 :
        			$_REQUEST['tipoNovedadCon']='Esporadica';
        			break;
        	}
        }
        
        
        
        $datosConcepto = array (
            
                        'nombre' => $_REQUEST['nombreCon'], 
        		'tipo_novedad' => $_REQUEST['tipoNovedadCon'],
        		'simbolo' => $_REQUEST['simboloCon'],
        		'categoria' => $_REQUEST['categoriaConceptosCon'],
        		'naturaleza' => $_REQUEST['naturalezaCon'],
        		'descripcion' => $_REQUEST['descripcionCon'],
        		'formula' => $_REQUEST['formulaConcepto']
        );
        
        $cadenaSql = $this->miSql->getCadenaSql("insertarConcepto",$datosConcepto);
        $id_concepto = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $datosConcepto, "insertarConcepto");
        
        $arrayLeyes = explode(",", $_REQUEST['leyCon']);
        $count = 0;
        
        while($count < count($arrayLeyes)){
        	
        	$datosLeyesConcepto = array(
        			'fk_id_ley' => $arrayLeyes[$count],
        			'fk_concepto' => $id_concepto[0][0]
        	);
        	
        	$cadenaSql = $this->miSql->getCadenaSql("insertarLeyesConcepto",$datosLeyesConcepto);
        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        	
        	$count++;
        
        }
        
        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
        
        
        
        
        //***************************VALIDAR Condiciones*************************************************************
        
        
        // ---------------- INICIO: Lista Variables Control--------------------------------------------------------
        
        $cantidadCondiciones = $_REQUEST['cantidadCondicionesConcepto'];
        
        // ---------------- FIN: Lista Variables Control--------------------------------------------------------
        
        // --------------------------------- n Condiciones ----------------------------------
        
    	$count = 0;
    	$control = 0;
    	$limite = 0;
    	
    	$arrayPartCondicion = explode(",", $_REQUEST['variablesRegistros']);
    	
    	while($control < $cantidadCondiciones){
    		
    		$arrayCondiciones[$control] = 'Si(' .$arrayPartCondicion[$limite++]. ') Entonces{'.$arrayPartCondicion[$limite++].'}'; 
    		 
    		$control++;
    	}
   
        while($count < $cantidadCondiciones){
        	
        	//-------------------------- Seccion Validar Condiciones ------------------------------------------------
        	//Formato:
        	//					Si(condiciones) Entonces{Accion}
        	//-------------------------------------------------------------------------------------------------------
        	
        	$_entradaCondicionCompilador = $arrayCondiciones[$count];
        	
        	
        	
        	
        	
        	
        	//----------------------------------------------------------------------------------------------------------
        	//------------------------ Codigo A Ejecutar Una Vez VALIDADA la Condicion -----------------------------------
        	   
        	$datosCondicion = array(
        			'cadena' => $arrayCondiciones[$count],
        			'fk_concepto' => $id_concepto[0][0]
        	);
        	
        	$cadenaSql = $this->miSql->getCadenaSql("insertarCondicion",$datosCondicion);
        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        	
        	//-------------------------------------------------------------------------------------------------------

        	$count++;
        }
        
   
        if (!empty($id_concepto)) {
           Redireccionador::redireccionar('inserto',$datosConcepto);
            exit();
        } else {
           Redireccionador::redireccionar('noInserto',$datosConcepto);
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

