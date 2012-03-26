<?php

class Departamento extends AppModel {

    var $name = 'Departamento';
    var $displayField = 'NOMBRE';

    /**
     *  Relaciones
     */
    var $hasMany = 'Contrato';
    
    /**
     *   Validaciones
     */
     var $validate = array(       
        'NOMBRE' => array(
            'nombreRule-1' => array(
                'rule' => 'notEmpty',
                'message' => 'Nombre del Departamento necesario',
                'last' => true
            ),
            'nombreRule-2' => array(
                'rule' => 'isUnique',
                'message' => 'Este Departamento ya existe'
            )
        )         
     );
}
?>