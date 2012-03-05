<?php

class Empleado extends AppModel {

    var $name = 'Empleado';
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
        'NOMBRE'=>array(
            'rule'=>'notEmpty',
            'message'=>'Nombres necesarios'
        ),
        'APELLIDO'=>array(
            'rule'=>'notEmpty',
            'message'=>'Apellidos necesarios',
        ),
        'FECHANAC'=>array(
            'rule'=>array('date','dmy'),
            'message'=>'Fecha incorrecta',
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
    
    function beforeFind(){
        
    }
    

    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }

    function Edad() {
        $fecha = $this->data['Empleado']['FECHANAC'];
        list($ano, $mes, $dia) = explode("-", $fecha);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

}

