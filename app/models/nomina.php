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
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'FECHA_FIN' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Final incorrecta',
        ),
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione la Quincena',
        ),
        'CODIGO' => array(
            'rule' => array('notEmpty'),
            'message' => 'Ingrese un codigo',
        )
    );

    function beforeSave() {
        $fecha_ini = $this->data['Nomina']['FECHA_INI'];
        $fecha_fin = $this->data['Nomina']['FECHA_FIN'];

        if (compara_fechas($fecha_ini, $fecha_fin) > 0) {
            $this->errorMessage = 'Inserte un rango valido de fechas';
            return false;
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
            $this->habtmAdd('Empleado', $id, $contrato['Contrato']['empleado_id']);
        }
    }

    /**
     * Devuelve informacion asociada a cada empleado que se encuentra en esta nomina 
     * @param type $id ID de la Nomina
     * @return type Informacion de los empleados  
     */
    function buscarInformacionEmpleados($id, $grupo) {        
        $nomina = $this->find("first", array(
            'conditions' => array(
                'id' => $id),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id',
                    )
                )
            )
                ));

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);        
        $empleados = Set::extract('/Empleado/id', $nomina);
                
        // Buscamos los contratos de acuerdo a la fecha de la nomina
        // y el grupo indicado , tambien buscamos el historial de sueldos del
        // cargo correspondiente en la fecha de la nomina
        $contratos = $this->Empleado->Contrato->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                    'empleado_id' => $empleados,
                    'GRUPO' => $grupo
                )
            ),
            'contain' => array(
                'Empleado',
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
     * Realizamos los Calculos de la Nomina
     * @param type $id 
     */
    function calcularNomina($id, $grupo) {
        $asignacion = ClassRegistry::init('Asignacion');
        $empleados = $this->buscarInformacionEmpleados($id, $grupo);

        foreach ($empleados as $key => $empleado) {            
            $empleados[$key]['Nomina_Empleado']['CARGO'] = $empleado['Cargo']['NOMBRE'];
            $empleados[$key]['Nomina_Empleado']['DEPARTAMENTO'] = $empleado['Departamento']['NOMBRE'];
            $empleados[$key]['Nomina_Empleado']['MODALIDAD'] = $empleado['Contrato']['MODALIDAD'];
            $empleados[$key]['Nomina_Empleado']['GRUPO'] = $empleado['Contrato']['GRUPO'];
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASE'] = $empleado['Cargo']['Historial']['0']['SUELDO_BASE'];
            $empleados[$key]['Nomina_Empleado']['SUELDO_DIARIO'] = $empleados[$key]['Nomina_Empleado']['SUELDO_BASE'] / 30;
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO'] = $empleados[$key]['Nomina_Empleado']['SUELDO_DIARIO'] * 15; // QUINCENA
            $empleados[$key]['Nomina_Empleado']['DIAS_LABORADOS'] = '15';
            $empleados[$key]['Nomina_Empleado']['Asignaciones'] = $asignacion->calcularAsignaciones($id,$grupo, $empleado['Empleado']['id']);
            $totalasig=0;
            foreach ($empleados[$key]['Nomina_Empleado']['Asignaciones'] as $value) {
                $totalasig=$totalasig+$value;
            }
            $empleados[$key]['Nomina_Empleado']['TOTAL_ASIGNACIONES'] = $totalasig;
            $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'] = $empleados[$key]['Nomina_Empleado']['SUELDO_BASICO']+$totalasig;
            
            unset($empleados[$key]['Contrato']);
            unset($empleados[$key]['Cargo']);
            unset($empleados[$key]['Departamento']);
            //debug($empleados[$key]);
        }

        return $empleados;
    }

}

?>
