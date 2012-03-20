<?php

class Titulo extends AppModel {
        
    var $name = 'Titulo';
    var $displayField = 'TITULO';
    
    /**
     *  Relaciones
     */
    var $belongsTo = 'Empleado';
    
    /**
     *  Validaciones   
     */    
    var $validate = array( 
        'TITULO' => array(
            'rule' => 'notEmpty',
            'message' => 'Selecione una Opcion'
        ),
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'INSTITUCION' => array(
            'rule' => 'notEmpty',
            'message' => 'Escriba el nombre de la Instuticion'
        ),
        'ESPECIALIDAD' => array(
            'rule' => 'notEmpty',
            'message' => 'Escriba la especialidad'
        )
        
    );
    
    function beforeSave() {
        if (!empty($this->data['Titulo']['FECHA'])) {
            $this->data['Titulo']['FECHA'] = formatoFechaBeforeSave($this->data['Titulo']['FECHA']);
        }
        return true;
    }

    function afterFind($results) {        
        foreach ($results as $key => $val) {
            if (!isset($val['Titulo'])) {
                if (isset($val['FECHA'])) {
                    $results[$key]['FECHA'] = formatoFechaAfterFind($val['FECHA']);
                }
            }
            if (isset($val['Titulo']['FECHA'])) {
                $results[$key]['Titulo']['FECHA'] = formatoFechaAfterFind($val['Titulo']['FECHA']);
            }
        }
        return $results;
    }
}
?>