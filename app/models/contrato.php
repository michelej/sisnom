<?php
class Contrato extends AppModel{
    
    var $name='Contrato';
    var $displayField = 'MODALIDAD';
    
    /**     
     *  Relaciones
     */
    var $belongsTo = array(
        'Cargo','Departamento','Empleado'
    );
    
    function beforeSave() {
        // fecha de ingreso del empleado        
        $empleadoingreso=$this->Empleado->find('first',array(
            'conditions'=>array('id'=>$this->data['Contrato']['empleado_id']),
            'recursive'=>'-1',
            'fields'=>array('Empleado.INGRESO'),
            ));        
        $ingreso=$empleadoingreso['Empleado']['INGRESO'];
        $fecha_ini=$this->data['Contrato']['FECHA_INI'];
        $fecha_fin=$this->data['Contrato']['FECHA_FIN'];
        
        // el rango de fechas no puede ser menor a la fecha de ingreso
        if(compara_fechas($ingreso, $fecha_ini)>0){
            $this->errorMessage='Las fechas no pueden preceder a la de ingreso del empleado '.$ingreso;
            return false;
        }
        
        if($fecha_fin==NULL){
            $this->data['Contrato']['FECHA_FIN']=NULL;
        }
        
        $this->recursive = -1;
        // buscamos los contratos de este empleado
        $contratos = $this->findAllByEmpleadoId($this->data['Contrato']['empleado_id']);        
        $result = Set::combine($contratos, '{n}.Contrato.id', '{n}.Contrato');        
        
        if (!$this->validacionFechas($fecha_ini,$fecha_fin,$result,"contratos")) {
            return false;
        }
        
        if (!empty($this->data['Contrato']['FECHA_INI'])) {
            $this->data['Contrato']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_INI']);
        }        
        if (!empty($this->data['Contrato']['FECHA_FIN'])) {
            $this->data['Contrato']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Contrato']['FECHA_FIN']);
        }
        return true;
    }   
    
    /**
     *
     * @param type $results
     * @return type 
     */
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Contrato']['FECHA_INI'])) {
                $results[$key]['Contrato']['FECHA_INI'] = formatoFechaAfterFind($val['Contrato']['FECHA_INI']);
            }
            if (isset($val['Contrato']['FECHA_FIN'])) {
                $results[$key]['Contrato']['FECHA_FIN'] = formatoFechaAfterFind($val['Contrato']['FECHA_FIN']);
            }
        }
        return $results;
    }
}
?>