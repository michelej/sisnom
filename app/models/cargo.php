<?php

class Cargo extends AppModel {

    var $name = 'Cargo';
    var $displayField = 'NOMBRE';
    var $actsAs = array('Containable');
    /**
     *  Relaciones
     */
    var $hasMany = array('Contrato', 'Historial');
    
    /**
     *   Validaciones
     */
     var $validate = array(       
        'NOMBRE' => array(
            'nombreRule-1' => array(
                'rule' => 'notEmpty',
                'message' => 'Nombre del Cargo necesario',
                'last' => true
            ),
            'nombreRule-2' => array(
                'rule' => 'isUnique',
                'message' => 'Este Cargo ya existe'
            )
        )         
     );
}
?>