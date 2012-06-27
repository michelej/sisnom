<?php

class Empleado extends AppModel {

    var $name = 'Empleado';
    var $displayField = 'CEDULA';
    var $actsAs = array('ExtendAssociations', 'Containable');

    /**
     *  Relaciones
     */
    var $hasMany = array('DetalleEventualidad', 'DetalleCestaticket', 'Recibo', 'Ausencia', 'Contrato', 'Familiar', 'Titulo', 'HorasExtra', 'Prestamo', 'Comercial', 'Tribunal', 'Islr', 'Experiencia', 'Ajuste');
    var $belongsTo = array('Grupo', 'Localizacion');

    /**
     *  Validaciones
     */
    var $validate = array(
        'NACIONALIDAD' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una opcion'
        ),
        'CEDULA' => array(
            'cedulaRule-1' => array(
                'rule' => 'notEmpty',
                'message' => 'Cedula Necesaria',
                'last' => true
            ),
            'cedulaRule-2' => array(
                'rule' => 'numeric',
                'message' => 'Cedula Invalida'
            )
        ),
        'SEXO' => array(
            'rule' => array('multiple', array('in' => array('Masculino', 'Femenino'))),
            'message' => 'Seleccione una opcion'
        ),
        'NOMBRE' => array(
            'rule' => 'notEmpty',
            'message' => 'Nombres necesarios'
        ),
        'APELLIDO' => array(
            'rule' => 'notEmpty',
            'message' => 'Apellidos necesarios',
        ),
        'FECHANAC' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'INGRESO' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'grupo_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una opcion'
        ),
        'EDOCIVIL' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una opcion'
        ),
        'PESO' => array(
            'rule' => 'numeric',
            'allowEmpty' => true,
            'message' => 'Debe ser Numerico'
        ),
        'TPANTALOM' => array(
            'rule' => 'numeric',
            'allowEmpty' => true,
            'message' => 'Debe ser Numerico'
        ),
        'TCALZADO' => array(
            'rule' => 'numeric',
            'allowEmpty' => true,
            'message' => 'Debe ser Numerico'
        ),
        'ESTATURA' => array(
            'rule' => 'numeric',
            'allowEmpty' => true,
            'message' => 'Debe ser un Numero'
        ),
    );

    function beforeSave() {
        if (!empty($this->data['Empleado']['NOMBRE']) && !empty($this->data['Empleado']['APELLIDO'])) {
            $this->data['Empleado']['NOMBRE'] = strtoupper($this->data['Empleado']['NOMBRE']);
            $this->data['Empleado']['APELLIDO'] = strtoupper($this->data['Empleado']['APELLIDO']);
        }
        if (!empty($this->data['Empleado']['FECHANAC'])) {
            $this->data['Empleado']['FECHANAC'] = formatoFechaBeforeSave($this->data['Empleado']['FECHANAC']);
        }
        if (!empty($this->data['Empleado']['INGRESO'])) {
            $this->data['Empleado']['INGRESO'] = formatoFechaBeforeSave($this->data['Empleado']['INGRESO']);
        }
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Empleado']['FECHANAC'])) {
                $results[$key]['Empleado']['FECHANAC'] = formatoFechaAfterFind($val['Empleado']['FECHANAC']);
                $results[$key]['Empleado']['EDAD'] = $this->Edad($results[$key]['Empleado']['FECHANAC']);
            }
            if (isset($val['Empleado']['INGRESO'])) {
                $results[$key]['Empleado']['INGRESO'] = formatoFechaAfterFind($val['Empleado']['INGRESO']);
            }
        }
        return $results;
    }

    function Edad($fechanac) {
        list($dia, $mes, $ano) = explode("-", $fechanac);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

    function busqueda($parametros) {
        $options = array();

        if ($parametros['SEXO'] != "0") {
            $options['conditions'][] = array('Empleado.SEXO' => $parametros['SEXO']);
        }
        if ($parametros['EDOCIVIL'] != "0") {
            $options['conditions'][] = array('Empleado.EDOCIVIL' => $parametros['EDOCIVIL']);
        }

        $hoy = date('d-m-Y');
        $options['contain'] = array(
            'Familiar', 'Grupo', 'Titulo',
            'Localizacion' => array(
                'Departamento'
            ),
            'Contrato' => array(
                'Cargo' => array(
                    'Historial' => array(
                        'conditions' => array(
                            'OR' => array(
                                'FECHA_FIN > ' => $hoy,
                                'FECHA_FIN' => NULL,
                            ),
                            'AND' => array(
                                'FECHA_INI < ' => $hoy,
                            )
                        )
                    )
                ),
                'Departamento',
                'order' => array(
                    'Contrato.FECHA_INI' => 'desc'),
            ),
            'Ajuste' => array(
                'Asignacion', 'Deduccion',
                'order' => array(
                    'Ajuste.FECHA_INI' => 'desc')
            )
        );

        $data = $this->find('all', $options);
        //debug($data);        
        foreach ($data as $key => $empleado) {
            // SI TIENE HIJOS
            if ($parametros['HIJOS'] == '1') {
                if (empty($empleado['Familiar'])) {
                    unset($data[$key]);
                } else {
                    $data[$key]['Empleado']['HIJOS'] = count($empleado['Familiar']);
                    unset($data[$key]['Familiar']);
                }
            }
            // SI NO TIENE HIJOS
            if ($parametros['HIJOS'] == '2') {
                if (!empty($empleado['Familiar'])) {
                    unset($data[$key]);
                } else {
                    unset($data[$key]['Familiar']);
                }
            }

            if (!empty($parametros['EDAD'])) {
                if ($parametros['EDAD_SIGNO'] == '0') {
                    if ($empleado['Empleado']['EDAD'] != $parametros['EDAD']) {
                        unset($data[$key]);
                    }
                }
                if ($parametros['EDAD_SIGNO'] == '1') {
                    if ($empleado['Empleado']['EDAD'] <= $parametros['EDAD']) {
                        unset($data[$key]);
                    }
                }
                if ($parametros['EDAD_SIGNO'] == '2') {
                    if ($empleado['Empleado']['EDAD'] >= $parametros['EDAD']) {
                        unset($data[$key]);
                    }
                }
            }
            if (!empty($parametros['CARGO'])) {
                if (!empty($empleado['Contrato'])) {
                    if ($empleado['Contrato']['0']['Cargo']['id'] != $parametros['CARGO']) {
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }
            if (!empty($parametros['DEPARTAMENTO'])) {
                if (!empty($empleado['Contrato'])) {
                    if ($empleado['Contrato']['0']['Departamento']['id'] != $parametros['DEPARTAMENTO']) {
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }

            if (!empty($parametros['FISICO'])) {
                if (isset($empleado['Localizacion']['Departamento'])) {
                    if ($empleado['Localizacion']['departamento_id'] != $parametros['FISICO']) {
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }

            if (!empty($parametros['MODALIDAD'])) {
                if (!empty($empleado['Contrato'])) {
                    if ($empleado['Contrato']['0']['MODALIDAD'] != $parametros['MODALIDAD']) {
                        unset($data[$key]);
                    }
                }
            }

            if (!empty($parametros['GRUPO'])) {
                if ($empleado['Grupo']['NOMBRE'] != $parametros['GRUPO']) {
                    unset($data[$key]);
                }
            }

            if (!empty($parametros['DEDUCCIONES'])) {
                if (empty($empleado['Ajuste'])) {
                    unset($data[$key]);
                } else {
                    $hoy = date("d-m-Y");
                    $fecha = $empleado['Ajuste']['0']['FECHA_FIN'];
                    if ($fecha != null) {
                        if (compara_fechas($hoy, $fecha) > 0) {
                            unset($data[$key]);
                        } else {
                            $flag = false;
                            foreach ($empleado['Ajuste']['0']['Deduccion'] as $deduc) {
                                if ($deduc['id'] == $parametros['DEDUCCIONES']) {
                                    $flag = true;
                                }
                            }
                            if (!$flag) {
                                unset($data[$key]);
                            }
                        }
                    }
                }
            }

            if (!empty($parametros['TITULO'])) {
                if (empty($empleado['Titulo'])) {
                    unset($data[$key]);
                } else {
                    foreach ($empleado['Titulo'] as $titulo) {
                        $flag = false;
                        if ($titulo['TITULO'] == $parametros['TITULO']) {
                            $flag = true;
                        }
                        if (!$flag) {
                            unset($data[$key]);
                        }
                    }
                }
            }

            if (!empty($parametros['SUELDO'])) {
                if (!empty($empleado['Contrato']['0']['Cargo']['Historial'])) {
                    $sueldo = $empleado['Contrato']['0']['Cargo']['Historial']['0']['SUELDO_BASE'];

                    if ($parametros['SUELDO_SIGNO'] == 0) {
                        if ($sueldo != $parametros['SUELDO']) {
                            unset($data[$key]);
                        }
                    }
                    if ($parametros['SUELDO_SIGNO'] == 1) {
                        if ($sueldo <= $parametros['SUELDO']) {
                            unset($data[$key]);
                        }
                    }
                    if ($parametros['SUELDO_SIGNO'] == 2) {
                        if ($sueldo >= $parametros['SUELDO']) {
                            unset($data[$key]);
                        }
                    }
                }
            }
            ////////////////////////////////////////
            if ($parametros['ACTIVO'] == '1') {
                if (empty($empleado['Contrato'])) {
                    unset($data[$key]);
                } else {
                    $hoy = date("d-m-Y");
                    $fecha = $empleado['Contrato']['0']['FECHA_FIN'];
                    if ($fecha != null) {
                        if (compara_fechas($hoy, $fecha) > 0) {
                            unset($data[$key]);
                        }
                    }
                }
                // INACTIVOS
            } else {
                if (!empty($empleado['Contrato'])) {
                    $hoy = date("d-m-Y");
                    $fecha = $empleado['Contrato']['0']['FECHA_FIN'];
                    if ($fecha != null) {
                        if (compara_fechas($hoy, $fecha) < 0) {
                            unset($data[$key]);
                        }
                    } else {
                        unset($data[$key]);
                    }
                }
            }

            if (isset($data[$key]['Empleado'])) {
                $data[$key]['Empleado']['GRUPO'] = $empleado['Grupo']['NOMBRE'];
                if (isset($empleado['Localizacion']['Departamento'])) {
                    $data[$key]['Empleado']['LOCALIZACION'] = $empleado['Localizacion']['Departamento']['NOMBRE'];
                } else {
                    $data[$key]['Empleado']['LOCALIZACION'] = "";
                }

                if (!empty($empleado['Contrato'])) {
                    $data[$key]['Empleado']['MODALIDAD'] = $empleado['Contrato']['0']['MODALIDAD'];
                    $data[$key]['Empleado']['CARGO'] = $empleado['Contrato']['0']['Cargo']['NOMBRE'];
                    $data[$key]['Empleado']['DEPARTAMENTO'] = $empleado['Contrato']['0']['Departamento']['NOMBRE'];
                    $data[$key]['Empleado']['SUELDO'] = $empleado['Contrato']['0']['Cargo']['Historial']['0']['SUELDO_BASE'];
                } else {
                    $data[$key]['Empleado']['MODALIDAD'] = "";
                    $data[$key]['Empleado']['CARGO'] = "";
                    $data[$key]['Empleado']['DEPARTAMENTO'] = "";
                    $data[$key]['Empleado']['SUELDO'] = 0;
                }
                if (!empty($empleado['Familiar'])) {
                    $count = 0;
                    foreach ($empleado['Familiar'] as $famil) {
                        if ($famil['PARENTESCO'] == "Hijo(a)") {
                            $count++;
                        }
                    }
                    $data[$key]['Empleado']['HIJOS'] = $count;
                } else {
                    $data[$key]['Empleado']['HIJOS'] = 0;
                }
            }

            unset($data[$key]['Grupo']);
            unset($data[$key]['Localizacion']);
            unset($data[$key]['Contrato']);
            unset($data[$key]['Familiar']);
            unset($data[$key]['Ajuste']);
            unset($data[$key]['Titulo']);
        }
        return $data;
    }

}

?>