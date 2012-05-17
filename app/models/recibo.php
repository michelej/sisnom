<?php

class Recibo extends AppModel {

    var $name = 'Recibo';    
    var $actsAs = array('Containable');
    
    /**
     *  Relaciones
     */
    var $hasMany = array('DetalleRecibo');    
    var $belongsTo =array('Nomina','Contrato');
}
?>