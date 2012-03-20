<?php

class Familiar extends AppModel {

    var $name = 'Familiar';
    var $displayField = 'NOMBRE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Empleado';
    /**
     *   Validaciones   
     */
    var $validate = array( 
        'NOMBRE' => array(
            'rule' => 'notEmpty',
            'message' => 'Ingrese el Nombre'
        ),
        'FECHA_NAC' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'DISCAPACIDAD' => array(
            'rule' => 'notEmpty',
            'message' => 'Selecione una Opcion'
        ),
        'INSTRUCCION' => array(
            'rule' => 'notEmpty',
            'message' => 'Selecione una Opcion'
        ),
        'PARENTESCO' => array(
            'rule' => 'notEmpty',
            'message' => 'Selecione una Opcion'
        ),
        
    );

    function beforeSave() {
        if (!empty($this->data['Familiar']['FECHA_NAC'])) {
            $this->data['Familiar']['FECHA_NAC'] = formatoFechaBeforeSave($this->data['Familiar']['FECHA_NAC']);
        }
        return true;
    }

    function afterFind($results) {        
        foreach ($results as $key => $val) {
            if (!isset($val['Familiar'])) {
                if (isset($val['FECHA_NAC'])) {
                    $results[$key]['FECHA_NAC'] = formatoFechaAfterFind($val['FECHA_NAC']);
                }
            }
            if (isset($val['Familiar']['FECHA_NAC'])) {
                $results[$key]['Familiar']['FECHA_NAC'] = formatoFechaAfterFind($val['Familiar']['FECHA_NAC']);
            }
        }
        return $results;
    }

}