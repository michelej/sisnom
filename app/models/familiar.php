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
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'DISCAPACIDAD' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        'INSTRUCCION' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        'PARENTESCO' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        
    );

    function beforeSave() {
        if (!empty($this->data['Familiar']['FECHA'])) {
            $this->data['Familiar']['FECHA'] = formatoFechaBeforeSave($this->data['Familiar']['FECHA']);
        }
        return true;
    }

    function afterFind($results) {        
        foreach ($results as $key => $val) {
            if (!isset($val['Familiar'])) {
                if (isset($val['FECHA'])) {
                    $results[$key]['FECHA'] = formatoFechaAfterFind($val['FECHA']);
                }
            }
            if (isset($val['Familiar']['FECHA'])) {
                $results[$key]['Familiar']['FECHA'] = formatoFechaAfterFind($val['Familiar']['FECHA']);
            }
        }
        return $results;
    }

}