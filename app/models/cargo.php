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

    function agruparSueldos() {
        $grupos = $this->Historial->find('all', array(
            'conditions' => array(
                'FECHA_FIN' => NULL
            ),
            'order' => 'SUELDO_BASE'
                )
        );
        $count = -1;        
        $sueldo = 0;
        foreach ($grupos as $value) {
            if ($sueldo != $value['Historial']['SUELDO_BASE']) {                
                $count++;
                $sub=0;
                $grupo_sueldos[$count]['Sueldo'] = $value['Historial']['SUELDO_BASE'];
                $grupo_sueldos[$count]['Cargos'][$sub]['id']=$value['Cargo']['id'];
                $grupo_sueldos[$count]['Cargos'][$sub]['NOMBRE']=$value['Cargo']['NOMBRE'];
                $grupo_sueldos[$count]['Cargos'][$sub]['DESCRIPCION']=$value['Cargo']['DESCRIPCION'];
                $sueldo=$value['Historial']['SUELDO_BASE'];                                
                $sub++;                
            }else{
                $grupo_sueldos[$count]['Cargos'][$sub]['id']=$value['Cargo']['id'];
                $grupo_sueldos[$count]['Cargos'][$sub]['NOMBRE']=$value['Cargo']['NOMBRE'];
                $grupo_sueldos[$count]['Cargos'][$sub]['DESCRIPCION']=$value['Cargo']['DESCRIPCION'];
                $sub++;                
            }
        }



        return $grupo_sueldos;
    }

}

?>