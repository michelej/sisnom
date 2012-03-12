<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';    

}

?>
