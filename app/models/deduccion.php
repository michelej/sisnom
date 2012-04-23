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
    function calcularDeducciones($id_nomina, $id_empleado, $monto_asignaciones, $sueldo_base) {
        // Buscamos todas las deducciones
        $data = $this->find('all', array(
            'recursive' => -1,
                ));

        $nomina = $this->Empleado->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id_nomina
            )
                ));

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);


        $empleado = $this->Empleado->find('first', array(
            'contain' => array(
                'Familiar', 'Titulo',
                'Prestamo' => array(
                    'conditions' => array(
                        'AND' => array(
                            'DATE_FORMAT(Prestamo.FECHA,"%m") = DATE_FORMAT("' . $fecha_ini . '","%m")',
                            'DATE_FORMAT(Prestamo.FECHA,"%y") = DATE_FORMAT("' . $fecha_ini . '","%y")'
                        )
                    )
                ),
                'Comercial' => array(
                    'conditions' => array(
                        'AND' => array(
                            'DATE_FORMAT(Comercial.FECHA,"%m") = DATE_FORMAT("' . $fecha_ini . '","%m")',
                            'DATE_FORMAT(Comercial.FECHA,"%y") = DATE_FORMAT("' . $fecha_ini . '","%y")'
                        )
                    )
                ),
                'Tribunal' => array(
                    'conditions' => array(
                        'AND' => array(
                            'DATE_FORMAT(Tribunal.FECHA,"%m") = DATE_FORMAT("' . $fecha_ini . '","%m")',
                            'DATE_FORMAT(Tribunal.FECHA,"%y") = DATE_FORMAT("' . $fecha_ini . '","%y")'
                        )
                    )
                ),
                'Islr' => array(
                    'conditions' => array(
                        'AND' => array(
                            'DATE_FORMAT(Islr.FECHA,"%m") = DATE_FORMAT("' . $fecha_ini . '","%m")',
                            'DATE_FORMAT(Islr.FECHA,"%y") = DATE_FORMAT("' . $fecha_ini . '","%y")'
                        )
                    )
                )
            ),
            'conditions' => array(
                'id' => $id_empleado
            )
                ));
        //debug($empleado);

        foreach ($data as $value) {
            // OJO CANTIDAD DE LUNES DEL MES O QUINCENA????
            $cant_lunes = cantidadLunes($nomina['Nomina']['FECHA_INI'], $nomina['Nomina']['FECHA_FIN']);
            // OJO BUSCAR EL SUELDO MINIMO!!
            $sueldo_minimo = 1548.22;
            $sueldo_diario = $sueldo_base / 30;
            $sueldo_basico = $sueldo_diario * 15;

            switch ($value['Deduccion']['id']) {
                //------------------------------------------------------------//
                //
                //                  SEGURO SOCIAL OBLIGATORIO   
                //
                //------------------------------------------------------------//
                case "1":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (($sueldo_base + ($monto_asignaciones * 2)) / $sueldo_minimo > 5) {
                            $valor = (float) (((5 * $sueldo_minimo * 12) / 52) * 0.04) * $cant_lunes;
                        } else {
                            $valor = (((($sueldo_base + $monto_asignaciones * 2) * 12) / 52) * 0.04) * $cant_lunes;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                   REGIMEN PRESTACIONAL DE EMPLEO
                //
                //------------------------------------------------------------//
                case "2":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (($sueldo_base + ($monto_asignaciones * 2)) / $sueldo_minimo > 5) {
                            $valor = (((5 * $sueldo_minimo * 12) / 52) * 0.005) * $cant_lunes;
                        } else {
                            $valor = (((($sueldo_base + $monto_asignaciones * 2) * 12) / 52) * 0.005) * $cant_lunes;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                  FONDO DE AHORRO OBLIGATORIO
                //
                //------------------------------------------------------------//
                case "3":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        $valor = ($sueldo_basico + $monto_asignaciones) * 0.01;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                   FONDO DE PENSIONES
                //
                //------------------------------------------------------------//    
                case "4":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        $valor = $sueldo_basico * 0.03;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                     CAJA DE AHORROS
                //
                //------------------------------------------------------------//    
                case "5":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        $valor = $sueldo_basico * 0.10;
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 PRESTAMOS DE CAJA DE AHORROS
                //
                //------------------------------------------------------------//    
                case "6":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (!empty($empleado['Prestamo'])) {
                            $valor = $empleado['Prestamo']['0']['CANTIDAD'];
                        }else{
                            $valor=0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //             DEDUCCIONES POR CREDITOS COMERCIALES   
                //
                //------------------------------------------------------------//    
                case "7":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (!empty($empleado['Comercial'])) {
                            $valor = $empleado['Comercial']['0']['CANTIDAD'];
                        }else{
                            $valor=0;
                        }                            
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 DEDUCCIONES POR TRIBUNALES
                //
                //------------------------------------------------------------//    
                case "8":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (!empty($empleado['Tribunal'])) {
                            $valor = $empleado['Tribunal']['0']['CANTIDAD'];
                        }else{
                            $valor=0;
                        } 
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //          RETENCION DE IMPUESTO SOBRE LA RENTA
                //
                //------------------------------------------------------------//       
                case "9":
                    if ($this->empleadoTieneDeduccion($id_empleado, $value['Deduccion']['id'])) {
                        if (!empty($empleado['Islr'])) {
                            $valor = ($sueldo_basico*$empleado['Islr']['0']['PORCENTAJE'])/100;
                        }else{
                            $valor=0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $deducciones[$value['Deduccion']['DESCRIPCION']] = $valor;
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
    function empleadoTieneDeduccion($id_empleado, $id_deduccion) {
        $empleado = $this->Empleado->find("first", array(
            'conditions' => array(
                'id' => $id_empleado
            ),
            'contain' => array(
                'Deduccion' => array(
                    'conditions' => array(
                        'id' => $id_deduccion
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

}

?>