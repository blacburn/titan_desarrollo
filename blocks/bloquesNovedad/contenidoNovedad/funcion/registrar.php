<?php

namespace bloquesNovedad\contenidoNovedad\funcion;

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

        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    }

    function procesarFormulario() {

        //Aquí va la lógica de procesamiento
        var_dump($_REQUEST);
        exit;
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

        if ($aceptado == "true") {
            if (isset($_REQUEST['naturalezaCon'])) {
                switch ($_REQUEST['naturalezaCon']) {
                    case 1 :
                        $_REQUEST['naturalezaCon'] = 'Devenga';
                        break;
                    case 2 :
                        $_REQUEST['naturalezaCon'] = 'Deduce';
                        break;
                }
            }
            if (isset($_REQUEST['tipoNovedadCon'])) {
                switch ($_REQUEST['tipoNovedadCon']) {
                    case 1 :
                        $_REQUEST['tipoNovedadCon'] = 'Periodica';
                        break;
                    case 2 :
                        $_REQUEST['tipoNovedadCon'] = 'Esporadica';
                        break;
                }
            }



            $datosConcepto = array(
                'nombre' => $_REQUEST['nombreCon'],
                'tipo_novedad' => $_REQUEST['tipoNovedadCon'],
                'simbolo' => $_REQUEST['simboloCon'],
                'categoria' => $_REQUEST['categoriaNovedadCon'],
                'naturaleza' => $_REQUEST['naturalezaCon'],
                'descripcion' => $_REQUEST['descripcionCon'],
                'formula' => $_REQUEST['formulaConcepto']
            );

            $cadenaSql = $this->miSql->getCadenaSql("insertarConcepto", $datosConcepto);
            $id_concepto = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", "busqueda", $datosConcepto, "insertarConcepto");


            $arrayLeyes = explode(",", $_REQUEST['leyCon']);
            $count = 0;

            while ($count < count($arrayLeyes)) {

                $datosLeyesConcepto = array(
                    'fk_id_ley' => $arrayLeyes[$count],
                    'fk_concepto' => $id_concepto[0][0]
                );

                $cadenaSql = $this->miSql->getCadenaSql("insertarLeyesConcepto", $datosLeyesConcepto);
                $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso"); //********************************

                $count++;
            }


            $arrayCampos = explode(",", $_REQUEST['variablesCampo']);
            $cuentaRegistro = 0;

            $datosFormulario = array(
                'fk_nombreFormulario' => $_REQUEST['nombreCon'],
                'fk_id_novedad' => $id_concepto[0][0]
            );

            //CREACION DE FORMULARIO Y GUARDO EN BD
            $cadenaSql = $this->miSql->getCadenaSql("insertarFormulario", $datosFormulario);
            $id_formulario = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", "busqueda", $datosFormulario, "insertarFormulario");


            while ($cuentaRegistro < count($arrayCampos)) {
                $cuentaCampo = 0;
                while ($cuentaCampo < 5) {

                    $datosCampo = array(
                        'fk_nombreCampo' => $arrayCampos[$cuentaRegistro],
                        'fk_labelCampo' => $arrayCampos[$cuentaRegistro++],
                        'fk_tipoDatoCampo' => $arrayCampos[$cuentaRegistro++],
                        'fk_requeridoCampo' => $arrayCampos[$cuentaRegistro++],
                        'fk_formulacionCampo' => $arrayCampos[$cuentaRegistro++]
                    );


                    $cadenaSql = $this->miSql->getCadenaSql("insertarCampos", $datosLeyesConcepto);
                    $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

                    $cuentaCampo++;
                }
            }
        } else {

            $datosConcepto = array(
                'nombre' => $_REQUEST['nombreCon'],
                'tipo_novedad' => $_REQUEST['tipoNovedadCon'],
                'simbolo' => $_REQUEST['simboloCon'],
                'categoria' => $_REQUEST['categoriaNovedadCon'],
                'naturaleza' => $_REQUEST['naturalezaCon'],
                'descripcion' => $_REQUEST['descripcionCon'],
                'formula' => $_REQUEST['formulaConcepto'],
                'error' => $aceptado,
                'refError' => "En el Campo Fórmula, "
            );

            Redireccionador::redireccionar('noInserto', $datosConcepto);
            exit();
        }


        //----------------------------------------------------------------------------------------------------------
        //------------------------ Codigo A Ejecutar Una Vez VALIDADA la Formula -----------------------------------
        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
        //***************************VALIDAR Condiciones*************************************************************
        // ---------------- INICIO: Lista Variables Control--------------------------------------------------------
//        $cantidadCondiciones = $_REQUEST['cantidadCondicionesConcepto'];
//
//        // ---------------- FIN: Lista Variables Control--------------------------------------------------------
//        // --------------------------------- n Condiciones ----------------------------------
//
//        $count = 0;
//        $control = 0;
//        $limite = 0;
//
//        $arrayPartCondicion = explode(",", $_REQUEST['variablesRegistros']);
//
//        while ($control < $cantidadCondiciones) {
//
//            $arrayCondiciones[$control] = 'Si(' . $arrayPartCondicion[$limite++] . ') Entonces{' . $arrayPartCondicion[$limite++] . '}';
//
//            $control++;
//        }
//
//        while ($count < $cantidadCondiciones) {
//
//            //-------------------------- Seccion Validar Condiciones ------------------------------------------------
//            //Formato:
//            //					Si(condiciones) Entonces{Accion}
//            //-------------------------------------------------------------------------------------------------------
//
//            $_entradaCondicionCompilador = $arrayCondiciones[$count];
//
//
//
//
//
//
//            //----------------------------------------------------------------------------------------------------------
//            //------------------------ Codigo A Ejecutar Una Vez VALIDADA la Condicion -----------------------------------
//
//            $datosCondicion = array(
//                'cadena' => $arrayCondiciones[$count],
//                'fk_concepto' => $id_concepto[0][0]
//            );
//
//            $cadenaSql = $this->miSql->getCadenaSql("insertarCondicion", $datosCondicion);
//            $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso"); //********************************
//            //-------------------------------------------------------------------------------------------------------
//
//            $count++;
//        }


        if (!empty($id_concepto)) {
            Redireccionador::redireccionar('inserto', $datosConcepto);
            exit();
        } else {
            Redireccionador::redireccionar('noInserto', $datosConcepto);
            exit();
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST[$clave]);
            }
        }
    }

}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);

$resultado = $miProcesador->procesarFormulario();

