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
        // Si existe el Nomina -> ID entonces es un update osea un generarNomina (que es donde se agregan los empleados)
        
        if (!isset($this->data['Ausencia']['id'])) {            
            if ($this->existe($this->data['Ausencia'])) {
                $this->errorMessage = "Ya existe una ausencia para esta fecha.";
                return false;
            }
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