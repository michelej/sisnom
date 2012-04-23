<?php 

class Ajuste extends AppModel {

    var $name = 'Ajuste';    
    var $actsAs = array('ExtendAssociations','Containable');

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = array('Asignacion','Deduccion');
    
    var $belongsTo = 'Empleado';
    
    function beforeSave() {
        // fecha de ingreso del empleado        
        $empleadoingreso=$this->Empleado->find('first',array(
            'conditions'=>array('id'=>$this->data['Ajuste']['empleado_id']),
            'recursive'=>'-1',
            'fields'=>array('Empleado.INGRESO'),
            ));        
        $ingreso=$empleadoingreso['Empleado']['INGRESO'];
        $fecha_ini=$this->data['Ajuste']['FECHA_INI'];
        $fecha_fin=$this->data['Ajuste']['FECHA_FIN'];
        
        // el rango de fechas no puede ser menor a la fecha de ingreso
        if(compara_fechas($ingreso, $fecha_ini)>0){
            $this->errorMessage='Las fechas no pueden preceder a la de ingreso del empleado '.$ingreso;
            return false;
        }
        
        // el rango de fechas no puede ser menor a la fecha de ingreso
        if(compara_fechas($ingreso, $fecha_ini)>0){
            $this->errorMessage='Las fechas no pueden preceder a la de ingreso del empleado '.$ingreso;
            return false;
        }
        
        if($fecha_fin==NULL){
            $this->data['Ajuste']['FECHA_FIN']=NULL;
        }
        
        $this->recursive = -1;
        // buscamos los contratos de este empleado
        $ajustes = $this->findAllByEmpleadoId($this->data['Ajuste']['empleado_id']);        
        $result = Set::combine($ajustes, '{n}.Ajuste.id', '{n}.Ajuste');        
        
        if (!$this->validacionFechas($fecha_ini,$fecha_fin,$result,"ajustes")) {
            return false;
        }
        
        
        if (!empty($this->data['Ajuste']['FECHA_INI'])) {
            $this->data['Ajuste']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_INI']);
        }        
        if (!empty($this->data['Ajuste']['FECHA_FIN'])) {
            $this->data['Ajuste']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_FIN']);
        }
        return true;
    }   
   
    
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Ajuste']['FECHA_INI'])) {
                $results[$key]['Ajuste']['FECHA_INI'] = formatoFechaAfterFind($val['Ajuste']['FECHA_INI']);
            }
            if (isset($val['Ajuste']['FECHA_FIN'])) {
                $results[$key]['Ajuste']['FECHA_FIN'] = formatoFechaAfterFind($val['Ajuste']['FECHA_FIN']);
            }
        }
        return $results;
    }  
}
?>