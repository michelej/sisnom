<?php 

class Ajuste extends AppModel {

    var $name = 'Ajuste';
    var $displayField = 'DESCRIPCION';
    var $actsAs = array('ExtendAssociations','Containable');

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = array('Asignacion','Deduccion');
    
    var $belongsTo = 'Empleado';
    
    function beforeSave() {
        // fecha de ingreso del empleado        
        
        
        if (!empty($this->data['Ajuste']['FECHA_INI'])) {
            $this->data['Ajuste']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_INI']);
        }        
        if (!empty($this->data['Ajuste']['FECHA_FIN'])) {
            $this->data['Ajuste']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_FIN']);
        }
        return true;
    }   
   
    
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Ajuste']['FECHA_INI'])) {
                $results[$key]['Ajuste']['FECHA_INI'] = formatoFechaAfterFind($val['Ajuste']['FECHA_INI']);
            }
            if (isset($val['Ajuste']['FECHA_FIN'])) {
                $results[$key]['Ajuste']['FECHA_FIN'] = formatoFechaAfterFind($val['Ajuste']['FECHA_FIN']);
            }
        }
        return $results;
    }  
}
?>