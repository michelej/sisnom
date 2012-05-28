<?php

class Departamento extends AppModel {

    var $name = 'Departamento';
    var $displayField = 'NOMBRE';
    var $actsAs = array('Containable');

    /**
     *  Relaciones
     */
    var $hasMany = 'Contrato';
    
    var $belongsTo = 'Programa';
    
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
     
     function buscarPrograma($departamento){
         $data=$this->find('first',array(
             'conditions'=>array(
                 'NOMBRE'=>$departamento
             ),
             'fields'=>array(
                 'PROGRAMA'
             )
         ));
         return $data['Departamento']['PROGRAMA'];
     }
     
     function buscarActividad_Proyecto($departamento){
         $data=$this->find('first',array(
             'conditions'=>array(
                 'NOMBRE'=>$departamento
             ),
             'fields'=>array(
                 'ACTIVIDAD_PROYECTO'
             )
         ));
         return $data['Departamento']['ACTIVIDAD_PROYECTO'];
     }
}
?>