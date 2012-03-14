<?php
class Contrato extends AppModel{
    
    var $name='Contrato';
    var $displayField = 'MODALIDAD';
    
    /**     
     *  Relaciones
     */
    var $belongsTo = array(
        'Cargo','Departamento','Empleado'
    );
    
    function beforeSave() {
        if (!empty($this->data['Contrato']['FECHA_INI'])) {
            $this->data['Contrato']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_INI']);
        }        
        if (!empty($this->data['Contrato']['FECHA_FIN'])) {
            $this->data['Contrato']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_FIN']);
        }
        return true;
    }   
    
    /**
     *
     * @param type $results
     * @return type 
     */
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Contrato']['FECHA_INI'])) {
                $results[$key]['Contrato']['FECHA_INI'] = formatoFechaAfterFind($val['Contrato']['FECHA_INI']);
            }
            if (isset($val['Contrato']['FECHA_FIN'])) {
                $results[$key]['Contrato']['FECHA_FIN'] = formatoFechaAfterFind($val['Contrato']['FECHA_FIN']);
            }
        }
        return $results;
    }
}
?>