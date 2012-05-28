<?php

class Programa extends AppModel {

    var $name = 'Programa';
    var $displayField = 'CODIGO';
    var $actsAs = array('Containable');

    /**
     *  Relaciones
     */
    var $hasMany = 'Departamento';
    var $validate = array(
        'CODIGO' => array(
            'rule' => 'numeric',
            'message' => 'Codigo invalido'
        ),
        'NOMBRE' => array(
            'rule' => 'notEmpty',
            'message' => 'Nombre necesario'
        ),
        'TIPO' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una opcion'
        ),
        'NUMERO' => array(
            'rule' => 'numeric',
            'message' => 'Numero invalido'
        ),
    );

}