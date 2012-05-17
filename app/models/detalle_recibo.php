<?php

class DetalleRecibo extends AppModel {

    var $name = 'DetalleRecibo';
    var $displayField = 'NOMBRE';
    var $actsAs = array('Containable');
    
    /**
     *  Relaciones
     */
    var $belongsTo = 'Recibo';
}
?>