<?php

class Localizacion extends AppModel {

    var $name = 'Localizacion';
    var $actsAs = array('Containable');
    
    var $hasOne=array('Empleado');
    
    var $belongsTo=array('Departamento');
    
    function beforeSave(){
       // debug($this->data);
        
        return true;
    }
    
}