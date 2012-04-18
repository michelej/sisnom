<?php

class Empleado extends AppModel {

    var $name = 'Empleado';
    var $displayField = 'CEDULA';      
    var $actsAs = array('ExtendAssociations','Containable');
    /**
     *  Relaciones
     */
    var $hasMany = array('Contrato','Familiar','Titulo','HorasExtra','Prestamo','Comercial');
    
    var $hasAndBelongsToMany = array('Asignacion','Deduccion','Nomina');
    
    var $belongsTo ='Grupo';
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
    );

    function beforeSave() {
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

}
?>