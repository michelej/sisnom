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
        
         // Si existe el Nomina -> ID entonces es un update osea un generarNomina (que es donde se agregan los empleados)
        
        if (!isset($this->data['HorasExtra']['id'])) {            
            if ($this->existe($this->data['HorasExtra'])) {
                $this->errorMessage = "Ya existe una Hora Extra para esta fecha.";
                return false;
            }
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
    
    
    function existe($data){        
        $conditions['FECHA'] = $data['FECHA'];        
        $data = $this->find('first', array(
            'conditions' => $conditions
                ));
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

}
?>