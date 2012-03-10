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
            $this->data['Contrato']['FECHA_INI'] = $this->formatoFechaBeforeSave($this->data['Contrato']['FECHA_INI']);
        }        
        return true;
    }
    
    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }
}
?>