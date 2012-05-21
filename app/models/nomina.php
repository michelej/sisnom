<?php

class Nomina extends AppModel {

    var $name = 'Nomina';
    var $displayField = 'FECHA_INI';
    var $actsAs = array('ExtendAssociations', 'Containable');

    /**
     *  Relaciones
     */
    var $hasMany = 'Recibo';

    /**
     *  Validaciones     
     */
    var $validate = array(
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione la Quincena',
        )
    );

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Nomina']['NOMINA_MES']) && isset($this->data['Nomina']['NOMINA_AÑO'])) {
            if (empty($this->data['Nomina']['NOMINA_MES']) || empty($this->data['Nomina']['NOMINA_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Nomina']['NOMINA_AÑO'])) {
                if ($this->data['Nomina']['NOMINA_AÑO'] < 1900 || $this->data['Nomina']['NOMINA_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }

            if ($this->data['Nomina']['QUINCENA'] == 'Primera') {
                $this->data['Nomina']['FECHA_INI'] = $this->data['Nomina']['NOMINA_AÑO'] . '-' . $this->data['Nomina']['NOMINA_MES'] . '-1';
                $this->data['Nomina']['FECHA_FIN'] = $this->data['Nomina']['NOMINA_AÑO'] . '-' . $this->data['Nomina']['NOMINA_MES'] . '-15';
            }
            if ($this->data['Nomina']['QUINCENA'] == 'Segunda') {
                $this->data['Nomina']['FECHA_INI'] = $this->data['Nomina']['NOMINA_AÑO'] . '-' . $this->data['Nomina']['NOMINA_MES'] . '-16';
                $dia = strftime("%d", mktime(0, 0, 0, $this->data['Nomina']['NOMINA_MES'] + 1, 0, $this->data['Nomina']['NOMINA_AÑO']));
                $this->data['Nomina']['FECHA_FIN'] = $this->data['Nomina']['NOMINA_AÑO'] . '-' . $this->data['Nomina']['NOMINA_MES'] . '-' . $dia;
            }
        }

        if (!empty($this->data['Nomina']['FECHA_INI'])) {
            $this->data['Nomina']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_INI']);
        }

        if (!empty($this->data['Nomina']['FECHA_FIN'])) {
            $this->data['Nomina']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_FIN']);
        }

        if (!empty($this->data['Nomina']['FECHA_ELA'])) {
            $this->data['Nomina']['FECHA_ELA'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_ELA']);
        }

        // Si existe el Nomina -> ID entonces es un update osea un generarNomina (que es donde se agregan los empleados)
        if ($this->existe($this->data['Nomina']) && !isset($this->data['Nomina']['id'])) {
            $this->errorMessage = "Ya existe una nomina para esta fecha.";
            return false;
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Nomina']['FECHA_INI'])) {
                $results[$key]['Nomina']['FECHA_INI'] = formatoFechaAfterFind($val['Nomina']['FECHA_INI']);
                $results[$key]['Nomina']['MES'] = $this->getMes($results[$key]['Nomina']['FECHA_INI']);
                $results[$key]['Nomina']['AÑO'] = $this->getAño($results[$key]['Nomina']['FECHA_INI']);
            }
            if (isset($val['Nomina']['FECHA_FIN'])) {
                $results[$key]['Nomina']['FECHA_FIN'] = formatoFechaAfterFind($val['Nomina']['FECHA_FIN']);
            }
            if (isset($val['Nomina']['FECHA_ELA'])) {
                $results[$key]['Nomina']['FECHA_ELA'] = formatoFechaAfterFind($val['Nomina']['FECHA_ELA']);
            }
        }
        return $results;
    }

    function getMes($date) {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre");
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $meses[((int) $mes) - 1];
    }

    function getAño($date) {
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $anio;
    }

    function existe($data) {
        $conditions['QUINCENA'] = $data['QUINCENA'];
        $conditions['FECHA_INI'] = $data['FECHA_INI'];
        $conditions['FECHA_FIN'] = $data['FECHA_FIN'];
        $data = $this->find('first', array(
            'conditions' => $conditions
                ));
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Buscamos los contratos que se encuentran activos en el rango de fechas
     * de la nomina (QUINCENA) y agregamos sus respectivos empleados
     * @param type $id ID de la Nomina
     */
    function generarNomina($id) {
        $this->Recibo->deleteAll(array(
            'nomina_id' => $id
        ));                

        $empleados = $this->calcularNomina($id);        
        foreach ($empleados as $empleado) {
            $data['CARGO'] = $empleado['Nomina_Empleado']['CARGO'];
            $data['DEPARTAMENTO'] = $empleado['Nomina_Empleado']['DEPARTAMENTO'];
            $data['MODALIDAD'] = $empleado['Nomina_Empleado']['MODALIDAD'];
            $data['DIAS_LABORADOS'] = $empleado['Nomina_Empleado']['DIAS_LABORADOS'];
            $data['SUELDO_BASE'] = $empleado['Nomina_Empleado']['SUELDO_BASE'];
            $data['empleado_id'] = $empleado['Nomina_Empleado']['ID_EMPLEADO'];
            $data['nomina_id'] = $empleado['Nomina_Empleado']['ID_NOMINA'];
            $this->Recibo->create();
            $this->Recibo->save($data);
            foreach ($empleado['Nomina_Empleado']['Asignaciones'] as $key => $asignacion) {
                $data_asig['CONCEPTO'] = 'Asignaciones';
                $data_asig['NOMBRE'] = $key;
                $data_asig['MONTO'] = $asignacion;
                $data_asig['recibo_id'] = $this->Recibo->getLastInsertID();
                $this->Recibo->DetalleRecibo->create();
                $this->Recibo->DetalleRecibo->save($data_asig);                
            }
            foreach ($empleado['Nomina_Empleado']['Deducciones'] as $key => $deduccion) {
                $data_dedu['CONCEPTO'] = 'Deducciones';
                $data_dedu['NOMBRE'] = $key;
                $data_dedu['MONTO'] = $deduccion;
                $data_dedu['recibo_id'] = $this->Recibo->getLastInsertID();
                $this->Recibo->DetalleRecibo->create();
                $this->Recibo->DetalleRecibo->save($data_dedu);                
            }
        }
    }

    /**
     * Realizamos los Calculos de la Nomina
     * @param type $id 
     */
    function calcularNomina($id) {
        $asignacion = ClassRegistry::init('Asignacion');
        $deduccion = ClassRegistry::init('Deduccion');

        $empleados = $this->buscarInformacionEmpleados($id);

        if ($this->verificarSueldos($empleados)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                Verifique que cada cargo tenga definido un sueldo al momento de la nomina";
            return array();
        }

        $nomina = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                )
        );

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);

        $sueldo_minimo = $this->verificarSueldoMinimo($fecha_ini, $fecha_fin);
        if (empty($sueldo_minimo)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                - Verifique que exista un Sueldo Minimo definido para este periodo";
            return array();
        }

        foreach ($empleados as $key => $empleado) {
            $empleados[$key]['Nomina_Empleado']['Empleado'] = $empleado['Empleado'];
            $empleados[$key]['Nomina_Empleado']['ID_NOMINA'] = $id;
            $empleados[$key]['Nomina_Empleado']['FECHA_INI'] = $fecha_ini;
            $empleados[$key]['Nomina_Empleado']['FECHA_FIN'] = $fecha_fin;
            $empleados[$key]['Nomina_Empleado']['ID_EMPLEADO'] = $empleado['Empleado']['id'];
            $empleados[$key]['Nomina_Empleado']['NOMBRE'] = $empleado['Empleado']['NOMBRE'];
            $empleados[$key]['Nomina_Empleado']['APELLIDO'] = $empleado['Empleado']['APELLIDO'];
            $empleados[$key]['Nomina_Empleado']['CEDULA'] = $empleado['Empleado']['CEDULA'];
            $empleados[$key]['Nomina_Empleado']['INGRESO'] = $empleado['Empleado']['INGRESO'];
            $empleados[$key]['Nomina_Empleado']['SUELDO_MINIMO'] = $sueldo_minimo;
            $empleados[$key]['Nomina_Empleado']['DIAS_HABILES'] = $this->nominaDiasHabiles($id);
            $empleados[$key]['Nomina_Empleado']['CARGO'] = $empleado['Cargo']['NOMBRE'];
            $empleados[$key]['Nomina_Empleado']['DEPARTAMENTO'] = $empleado['Departamento']['NOMBRE'];
            $empleados[$key]['Nomina_Empleado']['MODALIDAD'] = $empleado['Contrato']['MODALIDAD'];
            $empleados[$key]['Nomina_Empleado']['GRUPO'] = $empleado['Empleado']['Grupo']['NOMBRE'];
            // -- DIAS LABORADOS --
            if (check_in_range($fecha_ini, $fecha_fin, $empleado['Contrato']['FECHA_FIN'])) {
                $dias = numeroDeDias($fecha_ini, $empleado['Contrato']['FECHA_FIN']);
                $empleados[$key]['Nomina_Empleado']['DIAS_LABORADOS'] = $dias;
            } elseif (check_in_range($fecha_ini, $fecha_fin, $empleado['Contrato']['FECHA_INI'])) {
                $dias = numeroDeDias($empleado['Contrato']['FECHA_INI'], $fecha_fin);
                $empleados[$key]['Nomina_Empleado']['DIAS_LABORADOS'] = $dias;
            } else {
                $empleados[$key]['Nomina_Empleado']['DIAS_LABORADOS'] = '15';
            }
            // -- DIAS LABORADOS --
            // -- SUELDO --
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASE'] = $empleado['Cargo']['Historial']['0']['SUELDO_BASE'];
            $empleados[$key]['Nomina_Empleado']['SUELDO_DIARIO'] = $empleados[$key]['Nomina_Empleado']['SUELDO_BASE'] / 30;
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO'] = $empleados[$key]['Nomina_Empleado']['SUELDO_DIARIO'] * $empleados[$key]['Nomina_Empleado']['DIAS_LABORADOS']; // QUINCENA            
            // -- SUELDO --
            $empleados[$key]['Nomina_Empleado']['Asignaciones'] = $asignacion->calcularAsignaciones($empleados[$key]['Nomina_Empleado']);
            $totalasig = 0;
            foreach ($empleados[$key]['Nomina_Empleado']['Asignaciones'] as $value) {
                $totalasig = $totalasig + $value;
            }
            $empleados[$key]['Nomina_Empleado']['TOTAL_ASIGNACIONES'] = $totalasig;
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'] = $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO'] + $totalasig;
            $empleados[$key]['Nomina_Empleado']['Deducciones'] = $deduccion->calcularDeducciones($empleados[$key]['Nomina_Empleado']);
            $totaldedu = 0;
            foreach ($empleados[$key]['Nomina_Empleado']['Deducciones'] as $value) {
                $totaldedu = $totaldedu + $value;
            }
            $empleados[$key]['Nomina_Empleado']['TOTAL_DEDUCCIONES'] = $totaldedu;
            $empleados[$key]['Nomina_Empleado']['TOTAL_SUELDO'] = $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'] - $totaldedu;

            unset($empleados[$key]['Contrato']);
            unset($empleados[$key]['Cargo']);
            unset($empleados[$key]['Departamento']);
            unset($empleados[$key]['Empleado']);
            unset($empleados[$key]['Nomina_Empleado']['Empleado']);
        }

        if (empty($empleados)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                - Verifique que exista algun empleado trabajando para esa fecha o que se encuentre definido algun contrato";
        }

        return $empleados;
    }

    /**
     * Devuelve informacion asociada a cada empleado que se encuentra en esta nomina 
     * @param type $id ID de la Nomina
     * @return type Informacion de los empleados  
     */
    function buscarInformacionEmpleados($id) {
        $nomina = $this->find("first", array(
            'conditions' => array(
                'id' => $id)
                )
        );

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);

        // Buscamos los contratos de acuerdo a la fecha de la nomina
        // y el grupo indicado , tambien buscamos el historial de sueldos del
        // cargo correspondiente en la fecha de la nomina , y toda la informacion
        // de los empleados necesaria para las asignaciones y deducciones
        $contratos = $this->Recibo->Empleado->Contrato->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                )
            ),
            'contain' => array(
                'Empleado' => array(
                    'order' => array(
                        'Empleado.ID' => 'asc'
                    ),
                    'Grupo', 'Familiar', 'Titulo', 'Experiencia',
                    'HorasExtra' => array(
                        'conditions' => array(
                            '(FECHA BETWEEN ? AND ?)' => array($fecha_ini, $fecha_fin)
                        )
                    ),
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
                'Departamento',
                'Cargo' => array(
                    'Historial' => array(
                        'conditions' => array(
                            'OR' => array(
                                'FECHA_FIN > ' => $fecha_ini,
                                'FECHA_FIN' => NULL,
                            ),
                            'AND' => array(
                                'FECHA_INI < ' => $fecha_fin,
                            )
                        )
                    )
                )
            )
                ));
        return $contratos;
    }

    /**
     * Devuelve los dias habiles, descontando los sabados y domingos y los feriados
     * @param type $id_nomina
     * @return type 
     */
    function nominaDiasHabiles($id_nomina) {
        $feriado = ClassRegistry::init('Feriado');
        $cantidad = 0;
        $nomina = $this->find('first', array(
            'conditions' => array(
                'id' => $id_nomina)
                ));

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);

        $feriados = $feriado->find('all', array(
            'conditions' => array(
                '(FECHA BETWEEN ? AND ?)' => array($fecha_ini, $fecha_fin)
            )
                ));

        $number_of_days = numeroDeDias($fecha_ini, $fecha_fin);

        for ($i = 0; $i <= $number_of_days; $i++) {
            $day = Date('l', mktime(0, 0, 0, date('m', strtotime($fecha_ini)), date('d', strtotime($fecha_ini)) + $i, date('y', strtotime($fecha_ini))));
            if ($day == 'Saturday' || $day == 'Sunday') {
                $cantidad++;
            }
        }
        return ($number_of_days + 1) - $cantidad - count($feriados);
    }

    /**
     *
     * @param type $empleados
     * @return boolean 
     */
    function verificarSueldos($empleados) {
        $error = false;
        foreach ($empleados as $empleado) {
            if (empty($empleado['Cargo']['Historial'])) {
                $error = true;
            }
        }
        return $error;
    }

    /**
     *
     * @param type $fecha_ini
     * @param type $fecha_fin
     * @return type 
     */
    function verificarSueldoMinimo($fecha_ini, $fecha_fin) {
        $variable = ClassRegistry::init('Variable');
        $sueldo_minimo = $variable->find('first', array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                    'NOMBRE' => 'Sueldo Minimo'
                )
            )
                ));
        return $sueldo_minimo['Variable']['VALOR'];
    }

}

?>
