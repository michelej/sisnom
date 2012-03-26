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
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'FECHA_FIN' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        )        
    );
    function beforeSave() {
        if (!empty($this->data['Ausencia']['FECHA_INI'])) {
            $this->data['Ausencia']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Ausencia']['FECHA_INI']);
        }
        if (!empty($this->data['Ausencia']['FECHA_FIN'])) {
            $this->data['Ausencia']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Ausencia']['FECHA_FIN']);
        }
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (!isset($val['Ausencia'])) {
                if (isset($val['FECHA_INI'])) {
                    $results[$key]['FECHA_INI'] = formatoFechaAfterFind($val['FECHA_INI']);
                }
            }
            if (isset($val['Ausencia']['FECHA_INI'])) {
                $results[$key]['Ausencia']['FECHA_INI'] = formatoFechaAfterFind($val['Ausencia']['FECHA_INI']);
            }

            if (!isset($val['Ausencia'])) {
                if (isset($val['FECHA_FIN'])) {
                    $results[$key]['FECHA_FIN'] = formatoFechaAfterFind($val['FECHA_FIN']);
                }
            }
            if (isset($val['Ausencia']['FECHA_FIN'])) {
                $results[$key]['Ausencia']['FECHA_FIN'] = formatoFechaAfterFind($val['Ausencia']['FECHA_FIN']);
            }            
        }
        return $results;
    }

}
?>