<?php

class Feriado extends AppModel{
    var $name = 'Feriado';
    var $displayField = 'DESCRIPCION';
    
    /**
     *   Validaciones   
     */
    var $validate = array( 
        'DESCRIPCION' => array(
            'rule' => 'notEmpty',
            'message' => 'Ingrese una Descripcion'
        ),
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        )        
    );
    
    function beforeSave() {
        if (!empty($this->data['Feriado']['FECHA'])) {
            $this->data['Feriado']['FECHA'] = formatoFechaBeforeSave($this->data['Feriado']['FECHA']);
        }        
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Feriado']['FECHA'])) {
                $results[$key]['Feriado']['FECHA'] = formatoFechaAfterFind($val['Feriado']['FECHA']);
            }           
        }
        return $results;
    }  
    
    function getFeriados(){
        // TODO: hacer una lista de los feriados 
    }
    
}

?>