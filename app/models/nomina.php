<?php

class Nomina extends AppModel {

    var $name = 'Nomina';
    var $displayField = 'CODIGO';
    var $actsAs = array('ExtendAssociations', 'Containable');

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = 'Empleado';

    /**
     *  Validaciones     
     */
    var $validate = array(
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione la Quincena',
        ),
        'CODIGO' => array(
            'rule' => array('notEmpty'),
            'message' => 'Inserte un Codigo',
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

    /**
     * Buscamos los contratos que se encuentran activos en el rango de fechas
     * de la nomina (QUINCENA) y agregamos sus respectivos empleados
     * @param type $id ID de la Nomina
     */
    function generarNomina($id) {
        $nomina = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id),
            'fields' => array(
                'FECHA_INI',
                'FECHA_FIN')
                ));
        // Buscamos los contratos que se encontraban activos en esa fecha
        $contrato = ClassRegistry::init('Contrato');
        $listado_contratos = $contrato->buscarContratosPorFecha($nomina['Nomina']['FECHA_INI'], $nomina['Nomina']['FECHA_FIN']);
        foreach ($listado_contratos as $contrato) {
            $empleados[] = $contrato['Contrato']['empleado_id'];
        }
        if (!empty($empleados)) {
            $this->habtmDeleteAll('Empleado', $id);
            $this->habtmAdd('Empleado', $id, $empleados);
        }
    }

    /**
     * Realizamos los Calculos de la Nomina
     * @param type $id 
     */
    function calcularNomina($id, $grupo, $modalidad) {
        //***************************************************
        $time = time();
        //***************************************************
        $asignacion = ClassRegistry::init('Asignacion');
        $deduccion = ClassRegistry::init('Deduccion');

        $empleados = $this->buscarInformacionEmpleados($id, $grupo, $modalidad);

        if ($this->verificarSueldos($empleados)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                Verifique que cada cargo tenga definido un sueldo al momento de la nomina";
            return array();
        }

        $grupos = $this->Empleado->Grupo->find('list', array(
            'conditions' => array(
                'id' => $grupo)
                )
        );

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
                Verifique que exista un Sueldo Minimo definido para este periodo";
            return array();
        }


        foreach ($empleados as $key => $empleado) {
            $empleados[$key]['Nomina_Empleado']['Empleado'] = $empleado['Empleado'];
            $empleados[$key]['Nomina_Empleado']['ID_EMPLEADO'] = $empleado['Empleado']['id'];
            $empleados[$key]['Nomina_Empleado']['ID_NOMINA'] = $id;
            $empleados[$key]['Nomina_Empleado']['FECHA_INI'] = $fecha_ini;
            $empleados[$key]['Nomina_Empleado']['FECHA_FIN'] = $fecha_fin;
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
            $empleados[$key]['Nomina_Empleado']['Asignaciones'] = $asignacion->calcularAsignaciones($empleados[$key]['Nomina_Empleado'], $grupos);
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
        }
        //**************************************************
        $time_end = time() - $time;
        echo "TIEMPO: " . $time_end . " seg";
        echo "<br/>";
        $mem_usage = memory_get_usage(true);
        echo "MEMORIA: ";
        if ($mem_usage < 1024)
            echo $mem_usage . " bytes";
        elseif ($mem_usage < 1048576)
            echo round($mem_usage / 1024, 2) . " kilobytes";
        else
            echo round($mem_usage / 1048576, 2) . " megabytes";

        echo "<br/>";
        //**************************************************

        return $empleados;
    }

    /**
     * Devuelve informacion asociada a cada empleado que se encuentra en esta nomina 
     * @param type $id ID de la Nomina
     * @return type Informacion de los empleados  
     */
    function buscarInformacionEmpleados($id, $grupo, $modalidad) {
        $nomina = $this->find("first", array(
            'conditions' => array(
                'id' => $id,
            ),
            'contain' => array(
                'Empleado' => array(
                    'conditions' => array(
                        'grupo_id' => $grupo
                    ),
                    'fields' => array(
                        'id',
                    ),
                    'Grupo'
                )
            )
                ));
        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);
        $empleados = Set::extract('/Empleado/id', $nomina);

        // Buscamos los contratos de acuerdo a la fecha de la nomina
        // y el grupo indicado , tambien buscamos el historial de sueldos del
        // cargo correspondiente en la fecha de la nomina , y toda la informacion
        // de los empleados necesaria para las asignaciones y deducciones
        $contratos = $this->Empleado->Contrato->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                    'empleado_id' => $empleados,
                    'MODALIDAD' => $modalidad
                )
            ),
            'contain' => array(
                'Empleado' => array(
                    'order' => array(
                        'Empleado.NOMBRE' => 'asc'
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

    function verificarSueldos($empleados) {
        $error = false;
        foreach ($empleados as $empleado) {
            if (empty($empleado['Cargo']['Historial'])) {
                $error = true;
            }
        }
        return $error;
    }

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
                    'NOMBRE'=>'Sueldo Minimo'
                )
            )
                ));
        return $sueldo_minimo['Variable']['VALOR'];
    }

}

?>
