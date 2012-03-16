<?php

class Empleado extends AppModel {

    var $name = 'Empleado';
    var $displayField = 'CEDULA';      

    /**
     *  Relaciones
     */
    var $hasMany = array(
        'Contrato' => array(
            'dependent' => true
            ));
    /**
     *  Validaciones
     */
    var $validate = array(
        'NACIONALIDAD' => array(
            'rule' => array('multiple', array('in' => array('Venezolano', 'Extranjero'))),
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
        'cargos_id' => array(
            'rule' => array('multiple', array('min' => '1')),
            'message' => 'Seleccione un cargo',
        ),
    );

    function beforeSave() {
        if (!empty($this->data['Empleado']['FECHANAC'])) {
            $this->data['Empleado']['FECHANAC'] = $this->formatoFechaBeforeSave($this->data['Empleado']['FECHANAC']);
        }
        if (!empty($this->data['Empleado']['INGRESO'])) {
            $this->data['Empleado']['INGRESO'] = $this->formatoFechaBeforeSave($this->data['Empleado']['INGRESO']);
        }
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Empleado']['FECHANAC'])) {
                $results[$key]['Empleado']['FECHANAC'] = $this->formatoFechaAfterFind($val['Empleado']['FECHANAC']);
            }
            if (isset($val['Empleado']['INGRESO'])) {
                $results[$key]['Empleado']['INGRESO'] = $this->formatoFechaAfterFind($val['Empleado']['INGRESO']);
            }
        }
        return $results;
    }

    function formatoFechaAfterFind($cadenaFecha) {
        return date('d-m-Y', strtotime($cadenaFecha));
    }

    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }

    function Edad($fechanac) {
        //$fecha = $this->data['Empleado']['FECHANAC'];
        list($dia, $mes, $ano) = explode("-", $fechanac);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

}

