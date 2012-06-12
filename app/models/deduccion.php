<?php

class Deduccion extends AppModel {

    var $name = 'Deduccion';
    var $displayField = 'DESCRIPCION';
    var $actsAs = array('Containable');

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = 'Ajuste';
    var $constante = array(
        '1' => array('id' => '1', 'CODIGO' => 'S.S.O', 'DESCRIPCION' => 'Seguro Social Obligatorio', 'PORCENTAJE' => '4%'),
        '2' => array('id' => '2', 'CODIGO' => 'R.P.E', 'DESCRIPCION' => 'Régimen Prestacional de Empleo ', 'PORCENTAJE' => '0.5%'),
        '3' => array('id' => '3', 'CODIGO' => 'FAOV', 'DESCRIPCION' => 'Fondo de Ahorro Obligatorio de Vivienda', 'PORCENTAJE' => '1%'),
        '4' => array('id' => '4', 'CODIGO' => 'F.P', 'DESCRIPCION' => 'Fondo de Pensiones', 'PORCENTAJE' => '3%'),
        '5' => array('id' => '5', 'CODIGO' => 'C.A', 'DESCRIPCION' => 'Caja de Ahorros', 'PORCENTAJE' => '10%'),
        '6' => array('id' => '6', 'CODIGO' => 'PC', 'DESCRIPCION' => 'Prestamo Caja de Ahorros', 'PORCENTAJE' => ''),
        '7' => array('id' => '7', 'CODIGO' => 'DC', 'DESCRIPCION' => 'Deducciones Comerciales', 'PORCENTAJE' => ''),
        '8' => array('id' => '8', 'CODIGO' => 'T', 'DESCRIPCION' => 'Deducciones por Tribunales', 'PORCENTAJE' => ''),
        '9' => array('id' => '9', 'CODIGO' => 'ISLR', 'DESCRIPCION' => 'Declaracion impuesto sobre la renta', 'PORCENTAJE' => ''),
    );

    /**
     *
     * @param type $queryData
     * @return boolean 
     */
    function beforeFind($queryData) {
        $this->verificar();
        return true;
    }

    /**
     *  Verifica si los datos en la tabla son iguales a los que estan aqui declarados
     *  la idea es trabajar todo desde aqui (el Modelo) si se quiere agregar algo se hace 
     *  desde aqui. 
     *            
     *  El (id) es importante se usa para saber que tipo se va a usar
     */
    function verificar() {
        $this->data = $this->constante;

        // Para que esto funcione debemos de convertir lo que traigamos del query
        // en algo parecido a lo que tenemos arriba
        // no podemos usar find aqui porque se crea un loop infinito ya que esta funcion
        // es invocada desde el beforeFind
        $data = $this->query("SELECT * FROM deducciones as Deduccion");
        $result = Set::combine($data, '{n}.Deduccion.id', '{n}.Deduccion');
        // buscamos las diferencias
        $diff = array_diff_key($result, $this->data);
        // si no encuentro nada lo creamos con los valores default
        if (empty($data)) {
            $this->saveAll($this->data);
        } else {
            // Si son diferentes los regrabamos            
            if ($result != $this->data) {
                $this->saveAll($this->data);
                if (!empty($diff)) {
                    foreach ($diff as $value) {
                        // Borramos aquellos que hayan sido agregados en la BD y no esten declaradas aqui
                        $this->delete($id = $value['id']);
                    }
                }
            }
        }
    }

    /**
     *
     * @param type $id_nomina
     * @param type $id_empleado
     * @param type $monto_asignaciones
     * @return type 
     */
    function calcularDeducciones($nomina_empleado) {
        // Buscamos todas las deducciones
        /*$data = $this->find('all', array(
            'recursive' => -1,
                ));*/
        $grupo=$nomina_empleado['GRUPO'];        
        if($nomina_empleado['MODALIDAD']=='Contratado'){
            $grupo='Contratados';
        }
        $data = $this->ordenDeDeducciones($grupo);        
        
        $id_empleado = $nomina_empleado['ID_EMPLEADO'];
        $id_nomina = $nomina_empleado['ID_NOMINA'];
        $fecha_ini = $nomina_empleado['FECHA_INI'];
        $fecha_fin = $nomina_empleado['FECHA_FIN']; 
        $sueldo_base = $nomina_empleado['SUELDO_BASE'];
        $sueldo_diario = $nomina_empleado['SUELDO_DIARIO'];
        $sueldo_basico = $nomina_empleado['SUELDO_BASICO'];
        $monto_asignaciones=$nomina_empleado['TOTAL_ASIGNACIONES'];
        $sueldo_minimo = $nomina_empleado['SUELDO_MINIMO'];               
        $empleado['Empleado']=$nomina_empleado['Empleado'];
        
        
        // OJO CANTIDAD DE LUNES DEL MES O QUINCENA????
        $cant_lunes = cantidadLunes(formatoFechaAfterFind($fecha_ini), formatoFechaAfterFind($fecha_fin));            
        
        foreach ($data as $value) {            
            switch ($value['id']) {
                //------------------------------------------------------------//
                //
                //                  SEGURO SOCIAL OBLIGATORIO   
                //
                //------------------------------------------------------------//
                case "1":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (($sueldo_base + ($monto_asignaciones * 2)) / $sueldo_minimo > 5) {
                            $valor = (float) (((5 * $sueldo_minimo * 12) / 52) * 0.04) * $cant_lunes;
                        } else {
                            $valor = (((($sueldo_base + $monto_asignaciones * 2) * 12) / 52) * 0.04) * $cant_lunes;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                   REGIMEN PRESTACIONAL DE EMPLEO
                //
                //------------------------------------------------------------//
                case "2":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (($sueldo_base + ($monto_asignaciones * 2)) / $sueldo_minimo > 5) {
                            $valor = (((5 * $sueldo_minimo * 12) / 52) * 0.005) * $cant_lunes;
                        } else {
                            $valor = (((($sueldo_base + $monto_asignaciones * 2) * 12) / 52) * 0.005) * $cant_lunes;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                  FONDO DE AHORRO OBLIGATORIO
                //
                //------------------------------------------------------------//
                case "3":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $valor = ($sueldo_basico + $monto_asignaciones) * 0.01;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                   FONDO DE PENSIONES
                //
                //------------------------------------------------------------//    
                case "4":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $valor = $sueldo_basico * 0.03;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                     CAJA DE AHORROS
                //
                //------------------------------------------------------------//    
                case "5":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $valor = $sueldo_basico * 0.10;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 PRESTAMOS DE CAJA DE AHORROS
                //
                //------------------------------------------------------------//    
                case "6":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (!empty($empleado['Empleado']['Prestamo'])) {
                            $valor = $empleado['Empleado']['Prestamo']['0']['CANTIDAD'];
                        } else {
                            $valor = 0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //             DEDUCCIONES POR CREDITOS COMERCIALES   
                //
                //------------------------------------------------------------//    
                case "7":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (!empty($empleado['Empleado']['Comercial'])) {
                            $valor = $empleado['Empleado']['Comercial']['0']['CANTIDAD'];
                        } else {
                            $valor = 0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 DEDUCCIONES POR TRIBUNALES
                //
                //------------------------------------------------------------//    
                case "8":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (!empty($empleado['Empleado']['Tribunal'])) {
                            $valor = $empleado['Empleado']['Tribunal']['0']['CANTIDAD'];
                        } else {
                            $valor = 0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //          RETENCION DE IMPUESTO SOBRE LA RENTA
                //
                //------------------------------------------------------------//       
                case "9":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if (!empty($empleado['Empleado']['Islr'])) {                            
                            $valor = (($sueldo_basico+$monto_asignaciones) * $empleado['Empleado']['Islr']['0']['PORCENTAJE']) / 100;
                        } else {
                            $valor = 0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['DESCRIPCION']] = $valor;
                    break;
            }
        }
        return $deducciones;
    }

    /**
     *
     * @param type $id_empleado
     * @param type $id_deduccion
     * @return boolean 
     */
    function empleadoTieneDeduccion($id_empleado, $id_deduccion,$fecha_ini,$fecha_fin) {          
        $empleado = $this->Ajuste->find("first", array(            
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                    'empleado_id' => $id_empleado
                )
            ),
            'contain'=>array(
                'Deduccion'=>array(
                    'conditions'=>array(
                        'id'=>$id_deduccion
                    )
                )
            )
                ));

        if (empty($empleado['Deduccion'])) {
            return false;
        } else {
            return true;
        }
    }
    /**
     *
     * @param type $tipo
     * @return type 
     */
    
    function ordenDeDeducciones($tipo) {
        if ($tipo == 'Empleado') {
            $orden = array('1', '2', '3', '4', '5', '6','7','9');
        }
        if ($tipo == 'Obrero') {
            $orden = array('1', '2', '3', '5', '6','8','7');
        }
        if ($tipo == 'Contratados') {
            $orden = array('1', '2', '3','5', '6', '7','9');
        }
        foreach ($orden as $value) {
            $resultado[] = $this->constante[$value];
        }
        return $resultado;
    }

}

?>