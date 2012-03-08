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
}
?>