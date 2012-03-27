<?php

class Ausencia extends AppModel {

    var $name = 'Ausencia';
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
        if (!empty($this->data['Ausencia']['FECHA'])) {
            $this->data['Ausencia']['FECHA'] = formatoFechaBeforeSave($this->data['Ausencia']['FECHA']);
        }        
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (!isset($val['Ausencia'])) {
                if (isset($val['FECHA'])) {
                    $results[$key]['FECHA'] = formatoFechaAfterFind($val['FECHA']);
                }
            }
            if (isset($val['Ausencia']['FECHA'])) {
                $results[$key]['Ausencia']['FECHA'] = formatoFechaAfterFind($val['Ausencia']['FECHA']);
            }                       
        }
        return $results;
    }

}
?>