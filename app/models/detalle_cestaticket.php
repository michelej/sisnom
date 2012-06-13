<?php

class DetalleCestaticket extends AppModel {

    var $name = 'DetalleCestaticket';    
    var $actsAs = array('Containable');    
    
     /**
     *  Relaciones
     */    
    var $belongsTo =array('Empleado','Cestaticket');
}
?>