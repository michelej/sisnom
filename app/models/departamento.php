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
     
     function buscarInformacion($departamento){
         $data=$this->find('first',array(
             'conditions'=>array(
                 'Departamento.NOMBRE'=>$departamento
             ),
             'contain'=>array(
                 'Programa'
             )
         ));
         return $data;
     }
     
     function beforeSave() {
        if (!empty($this->data['Departamento']['NOMBRE'])) {
            $this->data['Departamento']['NOMBRE']=strtoupper($this->data['Departamento']['NOMBRE']);            
        }
        return true;
    }
     
}
?>