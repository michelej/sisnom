<?php
class Sueldo extends AppModel{
    
    var $name='Sueldo';
    var $displayField = 'SUELDO_BASE';
    
    /**     
     *  Relaciones
     */
    var $hasMany = 'Cargo';
}
?>