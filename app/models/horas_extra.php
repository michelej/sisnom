<?php

class HorasExtra extends AppModel {

    var $name = 'HorasExtra';
    var $displayField = 'TIPO';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Empleado';
    /**
     *   Validaciones   
     */
    var $validate = array( 
        'TIPO' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccion una Opcion'
        ),
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        )                
    );
    function beforeSave() {
        if (!empty($this->data['HorasExtra']['FECHA'])) {
            $this->data['HorasExtra']['FECHA'] = formatoFechaBeforeSave($this->data['HorasExtra']['FECHA']);
        }        
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (!isset($val['HorasExtra'])) {
                if (isset($val['FECHA'])) {
                    $results[$key]['FECHA'] = formatoFechaAfterFind($val['FECHA']);
                }
            }
            if (isset($val['HorasExtra']['FECHA'])) {
                $results[$key]['HorasExtra']['FECHA'] = formatoFechaAfterFind($val['HorasExtra']['FECHA']);
            }                       
        }
        return $results;
    }

}
?>