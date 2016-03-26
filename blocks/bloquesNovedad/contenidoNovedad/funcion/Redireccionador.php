<?php

namespace bloquesNovedad\contenidoNovedad\funcion;
                        
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		
	    
            $miConfigurador = \Configurador::singleton ();
            $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
            
		switch ($opcion) {
			case "inserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=inserto";
				break;
			
			case "noInserto" :
                                $variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noInserto";
                                break;
			
			case "opcion1" :
				$variable = "pagina=" . $miPaginaActual;
				$variable   = "&opcion=mensaje";
                                $variable   = "&mensaje=error";
                              
				
				break;
			case "verdetalle" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=verdetalle";
                                $variable .= '&variable=' . $valor;
                                break;	
                            
                            case "modificar" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=modificar";
                                $variable .= '&variable=' . $valor;
                                break;	
			case "form" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=form";
                                
                                break;	
                            case "inactivar" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=inactivar";
                                $variable .= '&variable=' . $valor;
                            break;    
                         case "modifico" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=mensaje";
                                $variable .= '&mensaje=modifico';
                               
                            break;    
                         case "nomodifico" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=mensaje";
                                $variable .= '&mensaje=nomodifico';
                            break;
                         case "periodica" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=periodica";
                              
                            break;    
                         case "esporadica" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=esporadica";
                                $variable .= "&tipoNovedad=" . $valor ['tipoNovedad'];
				$variable .= "&categoriaConceptos=" . $valor ['categoriaConceptos'];
                                $variable .= "&nombre=" . $valor ['nombre'];
				$variable .= "&simbolo=" . $valor ['simbolo'];
                                $variable .= "&ley=" . $valor ['ley'];
                                $variable .= "&leyRegistros=" . $valor ['leyRegistros'];
				$variable .= "&naturaleza=" . $valor ['naturaleza'];
                                $variable .= "&descripcion=" . $valor ['descripcion'];
                            break;
			case "esporadicaMod" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=esporadicaMod";
                                $variable .= "&tipoNovedad=" . $valor ['tipoNovedad'];
				$variable .= "&categoriaConceptos=" . $valor ['categoriaConceptos'];
                                $variable .= "&nombre=" . $valor ['nombre'];
				$variable .= "&simbolo=" . $valor ['simbolo'];
                                $variable .= "&ley=" . $valor ['ley'];
                                $variable .= "&leyRegistros=" . $valor ['leyRegistros'];
				$variable .= "&naturaleza=" . $valor ['naturaleza'];
                                $variable .= "&descripcion=" . $valor ['descripcion'];
                            break;
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		$_REQUEST [$enlace] = $variable;
		$_REQUEST ["recargar"] = true;
		
		return true;
	}
}
?>