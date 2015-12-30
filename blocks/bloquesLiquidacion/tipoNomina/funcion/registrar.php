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
       
        
        
        if(isset($_REQUEST['reglamentacion'])){
                    switch($_REQUEST ['reglamentacion']){
                           case 1 :
					$_REQUEST ['reglamentacion']='DI';
			   break;
                       
                           case 2 :
					$_REQUEST ['reglamentacion']='AS';
			   break;
                       
                           case 3 :
					$_REQUEST ['reglamentacion']='EJ';
			   break;
                       
                           case 4 :
					$_REQUEST ['reglamentacion']='TE';
			   break;
			   
                           case 5 :
					$_REQUEST ['reglamentacion']='AI';
			   break;
                       
                           case 6 :
					$_REQUEST ['reglamentacion']='TO';
			   break;
		           		
                           case 7 :
					$_REQUEST ['reglamentacion']='DC';
			   break;
                           
                           case 8 :
					$_REQUEST ['reglamentacion']='DP';
			   break;
                    
                    
                    }
                }
                
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
               
        
        $datos = array(
            
            'id' => $_REQUEST ['vinculacion'],
            'nombreNomina' => $_REQUEST ['nombreNomina'],
            'tipoNomina' => $_REQUEST ['tipoNomina'],
            'reglamentacion' => $_REQUEST ['reglamentacion'],
            'estadoRegistroNomina' => $_REQUEST ['estadoRegistroNomina'],
            'descripcionNomina' => $_REQUEST ['descripcionNomina'] 
        );
//       
        
                
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarRegistroNomina",$datos);
        $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
        Redireccionador::redireccionar('verDetalle2',$_REQUEST['variable']);
    	        
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
