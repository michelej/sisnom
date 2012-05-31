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
    /**
     *
     * @return string 
     */
    function agruparSueldos() {
        $grupos = $this->Historial->find('all', array(
            'conditions' => array(
                'FECHA_FIN' => NULL
            ),
            'order' => array('SUELDO_BASE'=>'desc')
                )
        );
        $count = -1;        
        $sueldo = 0;
        foreach ($grupos as $value) {
            if ($sueldo != $value['Historial']['SUELDO_BASE']) {                
                $count++;                
                $grupo_sueldos[$count]['Sueldo'] = $value['Historial']['SUELDO_BASE'];
                $grupo_sueldos[$count]['cargos_id'][]=$value['Cargo']['id'];
                $grupo_sueldos[$count]['cargos_nombres']=$value['Cargo']['NOMBRE'];                
                $sueldo=$value['Historial']['SUELDO_BASE'];                                                                
            }else{
                $grupo_sueldos[$count]['cargos_id'][]=$value['Cargo']['id'];
                $grupo_sueldos[$count]['cargos_nombres']=$grupo_sueldos[$count]['cargos_nombres'].' , '.$value['Cargo']['NOMBRE'];                
            }
        }
        if(empty($grupo_sueldos)){
            return array();
        }else{
            return $grupo_sueldos;
        }        
    }
    
    function beforeSave() {
        if (!empty($this->data['Cargo']['NOMBRE'])) {
            $this->data['Cargo']['NOMBRE']=strtoupper($this->data['Cargo']['NOMBRE']);            
        }
        return true;
    }

}

?>