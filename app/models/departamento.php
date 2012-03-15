<?php

class Departamento extends AppModel {

    var $name = 'Departamento';
    var $displayField = 'NOMBRE';

    /**
     *  Relaciones
     */
    var $hasMany = 'Contrato';

}

?>