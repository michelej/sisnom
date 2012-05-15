<?php

class Contrato extends AppModel {

    var $name = 'Contrato';
    var $displayField = 'MODALIDAD';
    var $actsAs = array('Containable');

    /**
     *  Relaciones
     */
    var $belongsTo = array(
        'Cargo', 'Departamento', 'Empleado'
    );

    /**
     *  Validaciones     
     */
    var $validate = array(
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'cargo_id' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Cargo',
        ),
        'departamento_id' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Departamento',
        ),
        'MODALIDAD' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione una Modalidad',
        )
    );

    function beforeSave() {
        // fecha de ingreso del empleado        
        $empleadoingreso = $this->Empleado->find('first', array(
            'conditions' => array('id' => $this->data['Contrato']['empleado_id']),
            'recursive' => '-1',
            'fields' => array('Empleado.INGRESO'),
                ));

        $ingreso = $empleadoingreso['Empleado']['INGRESO'];
        $fecha_ini = $this->data['Contrato']['FECHA_INI'];
        $fecha_fin = $this->data['Contrato']['FECHA_FIN'];

        // el rango de fechas no puede ser menor a la fecha de ingreso
        if (compara_fechas($ingreso, $fecha_ini) > 0) {
            $this->errorMessage = 'Las fechas no pueden preceder a la de ingreso del empleado ' . $ingreso;
            return false;
        }

        if ($fecha_fin == NULL) {
            $this->data['Contrato']['FECHA_FIN'] = NULL;
        }

        $this->recursive = -1;
        // buscamos los contratos de este empleado
        if (isset($this->data['Contrato']['id'])) {
            $contratos = $this->find('all', array(
                'conditions' => array(
                    'empleado_id' => $this->data['Contrato']['empleado_id'],
                    'NOT' => array(
                        'id' => $this->data['Contrato']['id']
                    )
                )
                    )
            );
        } else {
            $contratos = $this->findAllByEmpleadoId($this->data['Contrato']['empleado_id']);
        }
        $result = Set::combine($contratos, '{n}.Contrato.id', '{n}.Contrato');

        // Validamos para que no exista dos contratos en una misma quincena
        if (!empty($result)) {
            foreach ($result as $data) {
                $fecha_i = $data['FECHA_INI'];
                $fecha_f = $data['FECHA_FIN'];
                if ($fecha_f == null) {
                    if (compara_fechas($fecha_i, $fecha_ini) < 0) {
                        $dia = date('d', strtotime($fecha_ini));
                        $mes = date('m', strtotime($fecha_ini));
                        $año = date('Y', strtotime($fecha_ini));
                        $dia = $dia - 1;

                        if ($dia <= 15) {
                            $quincena_ini = $año . '-' . $mes . '-' . '1';
                            $quincena_fin = $año . '-' . $mes . '-' . '15';
                        } else {
                            $quincena_ini = $año . '-' . $mes . '-' . '16';
                            $dd = strftime("%d", mktime(0, 0, 0, $mes + 1, 0, $año));
                            $quincena_fin = $año . '-' . $mes . '-' . $dd;
                        }

                        if (date('d', strtotime($fecha_ini)) != 1) {
                            if (check_in_range($quincena_ini, $quincena_fin, $fecha_ini)) {
                                $this->errorMessage = 'No se puede terminar e iniciar un contrato en medio de una quincena';
                                return false;
                            }
                        }
                    }
                } else {
                    $dia = date('d', strtotime($fecha_f));
                    $mes = date('m', strtotime($fecha_f));
                    $año = date('Y', strtotime($fecha_f));

                    if ($dia <= 15) {
                        $quincena_ini = $año . '-' . $mes . '-' . '1';
                        $quincena_fin = $año . '-' . $mes . '-' . '15';
                    } else {
                        $quincena_ini = $año . '-' . $mes . '-' . '16';
                        $dd = strftime("%d", mktime(0, 0, 0, $mes + 1, 0, $año));
                        $quincena_fin = $año . '-' . $mes . '-' . $dd;
                    }
                    if (check_in_range($quincena_ini, $quincena_fin, $fecha_ini)) {
                        $this->errorMessage = 'No pueden existir dos contratos en una misma quincena';
                        return false;
                    }
                }
                //**                              
                $dia = date('d', strtotime($fecha_i));
                $mes = date('m', strtotime($fecha_i));
                $año = date('Y', strtotime($fecha_i));

                if ($dia < 15) {
                    $quincena_ini = $año . '-' . $mes . '-' . '1';
                    $quincena_fin = $año . '-' . $mes . '-' . '15';
                } else {
                    $quincena_ini = $año . '-' . $mes . '-' . '16';
                    $dd = strftime("%d", mktime(0, 0, 0, $mes + 1, 0, $año));
                    $quincena_fin = $año . '-' . $mes . '-' . $dd;
                }
                if (check_in_range($quincena_ini, $quincena_fin, $fecha_fin)) {
                    $this->errorMessage = 'No pueden existir dos contratos en una misma quincena';
                    return false;
                }
            }
        }

        if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "contratos")) {
            return false;
        }

        if (!empty($this->data['Contrato']['FECHA_INI'])) {
            $this->data['Contrato']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_INI']);
        }
        if (!empty($this->data['Contrato']['FECHA_FIN'])) {
            $this->data['Contrato']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_FIN']);
        }
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Contrato']['FECHA_INI'])) {
                $results[$key]['Contrato']['FECHA_INI'] = formatoFechaAfterFind($val['Contrato']['FECHA_INI']);
            }
            if (isset($val['Contrato']['FECHA_FIN'])) {
                $results[$key]['Contrato']['FECHA_FIN'] = formatoFechaAfterFind($val['Contrato']['FECHA_FIN']);
            }
        }
        return $results;
    }

    /**
     *  Buscamos los contratos que se encuentren en el rango de fechas dado
     * @param type $fecha_ini Fecha inicial
     * @param type $fecha_fin Fecha final
     * @return type Contratos que caen en ese rango
     */
    function buscarContratosPorFecha($fecha_ini, $fecha_fin) {
        $fecha_ini = formatoFechaBeforeSave($fecha_ini);
        $fecha_fin = formatoFechaBeforeSave($fecha_fin);

        // PURA MAGIA CUIDADO 
        $data = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                )
            )
                ));
        return $data;
    }

}

?>