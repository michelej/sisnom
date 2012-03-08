<?php
class Asignacion extends AppModel{
    
    var $name='Asignacion';
    var $displayField = 'MODALIDAD';
    
    /**     
     *  Relaciones
     */
    var $belongsTo = array(
        'Cargo','Departamento','Empleado'
    );
    
    function beforeSave() {
        if (!empty($this->data['Asignacion']['FECHA_INI'])) {
            $this->data['Asignacion']['FECHA_INI'] = $this->formatoFechaBeforeSave($this->data['Asignacion']['FECHA_INI']);
        }        
        return true;
    }
    
    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }
}
?>