<?php

class Cestaticket extends AppModel {

    var $name = 'Cestaticket';
    var $displayField = 'FECHA_INI';
    var $actsAs = array('ExtendAssociations', 'Containable');

    /**
     *  Relaciones
     */
    var $hasMany = 'DetalleCestaticket';

    /**
     *  Validaciones
     */
    var $validate = array(
        'VALOR_DIARIO' => array(
            'rule' => array('numeric'),
            'message' => 'Valor Diario Invalido',
        ),
        'SUELDO_MINIMO' => array(
            'rule' => array('numeric'),
            'message' => 'Sueldo Minimo Invalido',
        ),
        'CESTATICKET_MES' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'CESTATICKET_AÑO' => array(
            'cestaAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'cestaAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'cestaAño-r3' => array(
                'rule' => array('cestaAño'),
                'message' => 'El año es un valor invalido'
            )
        )
    );

    function cestaAño($check) {
        if ($check['CESTATICKET_AÑO'] < 1900 || $check['CESTATICKET_AÑO'] > 2200) {
            return false;
        }
        return true;
    }

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Cestaticket']['CESTATICKET_MES']) && isset($this->data['Cestaticket']['CESTATICKET_AÑO'])) {
            $this->data['Cestaticket']['FECHA_INI'] = $this->data['Cestaticket']['CESTATICKET_AÑO'] . '-' . $this->data['Cestaticket']['CESTATICKET_MES'] . '-1';
            $dia = strftime("%d", mktime(0, 0, 0, $this->data['Cestaticket']['CESTATICKET_MES'] + 1, 0, $this->data['Cestaticket']['CESTATICKET_AÑO']));
            $this->data['Cestaticket']['FECHA_FIN'] = $this->data['Cestaticket']['CESTATICKET_AÑO'] . '-' . $this->data['Cestaticket']['CESTATICKET_MES'] . '-' . $dia;
        }

        if (!empty($this->data['Cestaticket']['FECHA_INI'])) {
            $this->data['Cestaticket']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Cestaticket']['FECHA_INI']);
        }

        if (!empty($this->data['Cestaticket']['FECHA_FIN'])) {
            $this->data['Cestaticket']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Cestaticket']['FECHA_FIN']);
        }

        // Si existe el Cestaticket -> ID entonces es un update osea un generarCestaticket (que es donde se agregan los empleados)
        if (!isset($this->data['Cestaticket']['id'])) {
            if ($this->existe($this->data['Cestaticket'])) {
                $this->errorMessage = "Ya existe una nomina para esta fecha.";
                return false;
            }
        }

        return true;
    }

    /**
     *
     * @param type $results
     * @return type 
     */
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Cestaticket']['FECHA_INI'])) {
                $results[$key]['Cestaticket']['FECHA_INI'] = formatoFechaAfterFind($val['Cestaticket']['FECHA_INI']);
                $results[$key]['Cestaticket']['MES'] = $this->getMes($results[$key]['Cestaticket']['FECHA_INI']);
                $results[$key]['Cestaticket']['AÑO'] = $this->getAño($results[$key]['Cestaticket']['FECHA_INI']);
            }
            if (isset($val['Cestaticket']['FECHA_FIN'])) {
                $results[$key]['Cestaticket']['FECHA_FIN'] = formatoFechaAfterFind($val['Cestaticket']['FECHA_FIN']);
            }
        }
        return $results;
    }

    /**
     *
     * @param type $date
     * @return string 
     */
    function getMes($date) {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre");
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $meses[((int) $mes) - 1];
    }

    /**
     *
     * @param type $date
     * @return type 
     */
    function getAño($date) {
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $anio;
    }

    /**
     *
     * @param type $data
     * @return boolean 
     */
    function existe($data) {
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
     *
     * @param type $id 
     */
    function generarCestaticket($id) {
        $this->DetalleCestaticket->deleteAll(array(
            'cestaticket_id' => $id
        ));

        $empleados = $this->calcularCestaticket($id);
        foreach ($empleados as $empleado) {
            $data['CARGO'] = $empleado['Cestaticket_Empleado']['CARGO'];
            $data['DEPARTAMENTO'] = $empleado['Cestaticket_Empleado']['DEPARTAMENTO'];
            $data['MODALIDAD'] = $empleado['Cestaticket_Empleado']['MODALIDAD'];
            $data['DIAS_LABORADOS'] = $empleado['Cestaticket_Empleado']['DIAS_LABORADOS'];
            $data['DIAS_ADICIONALES'] = 0;
            $data['DIAS_DESCONTAR'] = $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR'];
            $data['TOTAL'] = $empleado['Cestaticket_Empleado']['MONTO'];
            $data['empleado_id'] = $empleado['Cestaticket_Empleado']['ID_EMPLEADO'];
            $data['cestaticket_id'] = $empleado['Cestaticket_Empleado']['ID_CESTATICKET'];
            $this->DetalleCestaticket->create();
            $this->DetalleCestaticket->save($data);
        }
    }

    /**
     *
     * @param type $id
     * @param type $grupo
     * @param type $modalidad
     * @return type 
     */
    function calcularCestaticket($id) {
        $empleados = $this->buscarInformacionEmpleados($id);

        if ($this->verificarSueldos($empleados)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                Verifique que cada cargo tenga definido un sueldo al momento de la nomina";
            return array();
        }

        $cestaticket = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                )
        );

        $fecha_ini = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_FIN']);

        $cestaticket_dia = $cestaticket['Cestaticket']['VALOR_DIARIO'];
        $sueldo_minimo = $cestaticket['Cestaticket']['SUELDO_MINIMO'];

        foreach ($empleados as $key => $empleado) {
            $dias = 22; // OJO ??????
            $empleados[$key]['Cestaticket_Empleado']['Empleado'] = $empleado['Empleado'];
            $empleados[$key]['Cestaticket_Empleado']['ID_CESTATICKET'] = $id;
            $empleados[$key]['Cestaticket_Empleado']['FECHA_INI'] = $fecha_ini;
            $empleados[$key]['Cestaticket_Empleado']['FECHA_FIN'] = $fecha_fin;
            $empleados[$key]['Cestaticket_Empleado']['ID_EMPLEADO'] = $empleado['Empleado']['id'];
            $empleados[$key]['Cestaticket_Empleado']['NOMBRE'] = $empleado['Empleado']['NOMBRE'];
            $empleados[$key]['Cestaticket_Empleado']['APELLIDO'] = $empleado['Empleado']['APELLIDO'];
            $empleados[$key]['Cestaticket_Empleado']['CEDULA'] = $empleado['Empleado']['CEDULA'];
            $empleados[$key]['Cestaticket_Empleado']['INGRESO'] = $empleado['Empleado']['INGRESO'];
            $empleados[$key]['Cestaticket_Empleado']['SUELDO_BASE'] = $empleado['Cargo']['Historial']['0']['SUELDO_BASE'];
            $empleados[$key]['Cestaticket_Empleado']['SUELDO_MINIMO'] = $sueldo_minimo;
            $empleados[$key]['Cestaticket_Empleado']['CESTATICKET_DIA'] = $cestaticket_dia;
            $empleados[$key]['Cestaticket_Empleado']['DIAS_HABILES'] = $this->nominaDiasHabiles($id);
            $empleados[$key]['Cestaticket_Empleado']['DIAS_LABORADOS'] = $dias;
            $empleados[$key]['Cestaticket_Empleado']['DEPARTAMENTO'] = $empleado['Departamento']['NOMBRE'];
            $empleados[$key]['Cestaticket_Empleado']['MODALIDAD'] = $empleado['Contrato']['MODALIDAD'];
            $empleados[$key]['Cestaticket_Empleado']['GRUPO'] = $empleado['Empleado']['Grupo']['NOMBRE'];
            if ($empleados[$key]['Cestaticket_Empleado']['MODALIDAD'] == 'Contratado') {
                $empleados[$key]['Cestaticket_Empleado']['CARGO'] = 'CONTRATADO';
            } else {
                $empleados[$key]['Cestaticket_Empleado']['CARGO'] = $empleado['Cargo']['NOMBRE'];
            }

            // CALCULOS DE LOS CESTATICKETS!!!!           
            $aus = 0;
            foreach ($empleado['Empleado']['Ausencia'] as $ausencia) {
                // Las ausencias no remuneradas son las que afectan al pago de cestaticket
                if ($ausencia['TIPO'] == 'No Remunerada') {
                    $aus++;
                }
            }
            $empleados[$key]['Cestaticket_Empleado']['DIAS_DESCONTAR'] = $aus;
            $dias = $dias - $aus;
            $empleados[$key]['Cestaticket_Empleado']['MONTO'] = $cestaticket_dia * $dias;

            unset($empleados[$key]['Contrato']);
            unset($empleados[$key]['Cargo']);
            unset($empleados[$key]['Departamento']);
            unset($empleados[$key]['Empleado']);
            unset($empleados[$key]['Cestaticket_Empleado']['Empleado']);
        }

        if (empty($empleados)) {
            $this->errorMessage = "No existe suficiente informacion para generar esta Nomina <br/>
                - Verifique que exista algun empleado trabajando para esa fecha o que se encuentre definido algun contrato";
        }

        return $empleados;
    }

    function mostrarCestaticket($id, $grupo, $modalidad) {
        $ids = $this->DetalleCestaticket->Empleado->Grupo->find('all', array(
            'conditions' => array(
                'NOMBRE' => $grupo
            ),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id')
                )
            )
                ));

        $id_empleados = Set::extract('/Empleado/id', $ids);

        $data = $this->DetalleCestaticket->find('all', array(
            'conditions' => array(
                'cestaticket_id' => $id,
                'empleado_id' => $id_empleados,
                'MODALIDAD' => $modalidad
            ),
            'contain' => array(
                'Cestaticket',
                'Empleado' => array(
                    'Grupo',
                )
            )
                ));
        foreach ($data as $key => $value) {
            $departamento = $this->DetalleCestaticket->Empleado->Contrato->Departamento->buscarInformacion($value['DetalleCestaticket']['DEPARTAMENTO']);
            $empleados[$key]['Cestaticket_Empleado']['PROGRAMA'] = $departamento['Programa']['CODIGO'];
            $empleados[$key]['Cestaticket_Empleado']['ACTIVIDAD_PROYECTO'] = $departamento['Programa']['NUMERO'];
            $empleados[$key]['Cestaticket_Empleado']['NOMBRE'] = $value['Empleado']['NOMBRE'];
            $empleados[$key]['Cestaticket_Empleado']['APELLIDO'] = $value['Empleado']['APELLIDO'];
            if ($value['Empleado']['NACIONALIDAD'] == 'Venezolano') {
                $empleados[$key]['Cestaticket_Empleado']['CEDULA'] = "V" . $value['Empleado']['CEDULA'];
            } else {
                $empleados[$key]['Cestaticket_Empleado']['CEDULA'] = "E" . $value['Empleado']['CEDULA'];
            }
            $empleados[$key]['Cestaticket_Empleado']['INGRESO'] = $value['Empleado']['INGRESO'];
            $empleados[$key]['Cestaticket_Empleado']['CARGO'] = $value['DetalleCestaticket']['CARGO'];
            $empleados[$key]['Cestaticket_Empleado']['DEPARTAMENTO'] = $value['DetalleCestaticket']['DEPARTAMENTO'];
            $empleados[$key]['Cestaticket_Empleado']['TOTAL'] = $value['DetalleCestaticket']['TOTAL'];
            $empleados[$key]['Cestaticket_Empleado']['DIAS_ADICIONALES'] = $value['DetalleCestaticket']['DIAS_ADICIONALES'];
            $empleados[$key]['Cestaticket_Empleado']['DIAS_DESCONTAR'] = $value['DetalleCestaticket']['DIAS_DESCONTAR'];
            $empleados[$key]['Cestaticket_Empleado']['VALOR_DIARIO'] = $value['Cestaticket']['VALOR_DIARIO'];
            $empleados[$key]['Cestaticket_Empleado']['DIAS_HABILES'] = 22; // OJO PILAS AQUI
            $empleados[$key]['Cestaticket_Empleado']['DIAS_LABORADOS'] = 22; // OJO PILAS AQUI
            $empleados[$key]['Cestaticket_Empleado']['TOTAL_DIAS'] = $value['DetalleCestaticket']['DIAS_ADICIONALES'] + $empleados[$key]['Cestaticket_Empleado']['DIAS_LABORADOS'];
            $empleados[$key]['Cestaticket_Empleado']['TOTAL_DIAS_EFEC'] = $empleados[$key]['Cestaticket_Empleado']['TOTAL_DIAS'] - $value['DetalleCestaticket']['DIAS_DESCONTAR'];
        }
        return $empleados;
    }

    function calcularResumen($nomina_empleado) {
        $data = $this->DetalleCestaticket->Empleado->Contrato->Departamento->Programa->find("all", array(
            'contain' => array(
                'Departamento'
            )
                ));
        // PARA CADA PROGRAMA        
        foreach ($data as $key => $programa) {
            // PARA CADA DEPARTAMENTO DE CADA PROGRAMA
            $total = 0;
            $dias_habiles = 0;
            $dias_laborados = 0;
            $dias_adicionales = 0;
            $dias_descontar = 0;
            $total_dias = 0;
            $total_efec = 0;
            foreach ($programa['Departamento'] as $departamento) {
                foreach ($nomina_empleado as $empleado) {
                    // BUSCAMOS LOS EMPLEADOS QUE PERTENESCAN A DICHO DEPARTAMENTO
                    if ($empleado['Cestaticket_Empleado']['DEPARTAMENTO'] == $departamento['NOMBRE']) {
                        $total = $total + $empleado['Cestaticket_Empleado']['TOTAL'];
                        $dias_habiles = $dias_habiles + $empleado['Cestaticket_Empleado']['DIAS_HABILES'];
                        $dias_adicionales = $dias_adicionales + $empleado['Cestaticket_Empleado']['DIAS_ADICIONALES'];
                        $dias_laborados = $dias_laborados + $empleado['Cestaticket_Empleado']['DIAS_LABORADOS'];
                        $dias_descontar = $dias_descontar + $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR'];
                        $total_dias = $total_dias + $empleado['Cestaticket_Empleado']['TOTAL_DIAS'];
                        $total_efec = $total_efec + $empleado['Cestaticket_Empleado']['TOTAL_DIAS_EFEC'];
                    }
                }
            }
            unset($data[$key]['Departamento']);
            $data[$key]['Programa']['TOTAL'] = $total;
            $data[$key]['Programa']['DIAS_HABILES'] = $dias_habiles;
            $data[$key]['Programa']['DIAS_LABORADOS'] = $dias_laborados;
            $data[$key]['Programa']['DIAS_ADICIONALES'] = $dias_adicionales;
            $data[$key]['Programa']['TOTAL_DIAS'] = $total_dias;
            $data[$key]['Programa']['DIAS_DESCONTAR'] = $dias_descontar;
            $data[$key]['Programa']['TOTAL_DIAS_EFEC'] = $total_efec;
        }

        return $data;
    }

    /**
     *
     * @param type $id
     * @param type $grupo
     * @param type $modalidad
     * @return type 
     */
    function buscarInformacionEmpleados($id) {
        $cestaticket = $this->find("first", array(
            'conditions' => array(
                'id' => $id)
                )
        );

        $fecha_ini = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_FIN']);

        // Buscamos los contratos de acuerdo a la fecha de la nomina
        // y el grupo indicado , tambien buscamos el historial de sueldos del
        // cargo correspondiente en la fecha de la nomina , y toda la informacion
        // de los empleados necesaria para las asignaciones y deducciones
        $contratos = $this->DetalleCestaticket->Empleado->Contrato->find('all', array(
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
                    'Grupo',
                    'Ausencia' => array(
                        'conditions' => array(
                            '(FECHA BETWEEN ? AND ?)' => array($fecha_ini, $fecha_fin)
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
     * @param type $id_nomina
     * @return type 
     */
    function nominaDiasHabiles($id_cestaticket) {
        $feriado = ClassRegistry::init('Feriado');
        $cantidad = 0;
        $cestaticket = $this->find('first', array(
            'conditions' => array(
                'id' => $id_cestaticket)
                ));

        $fecha_ini = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($cestaticket['Cestaticket']['FECHA_FIN']);

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

}

?>