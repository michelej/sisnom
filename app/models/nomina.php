<?php

class Nomina extends AppModel{

    var $name = 'Nomina';
    var $displayField = 'CODIGO';   
    var $actsAs = 'ExtendAssociations';

    /**
     *  Relaciones
     */        
    var $hasAndBelongsToMany = 'Empleado';
    /**
     *  Validaciones     
     */
    var $validate = array(                
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'FECHA_FIN' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Final incorrecta',
        ),
        'QUINCENA' => array(
            'rule'=> array('notEmpty'),
            'message'=>'Seleccione la Quincena',
        ),
        'CODIGO' => array(
            'rule'=> array('notEmpty'),
            'message'=>'Ingrese un codigo',
        )
    );
    
    function beforeSave() {
        $fecha_ini=$this->data['Nomina']['FECHA_INI'];
        $fecha_fin=$this->data['Nomina']['FECHA_FIN'];
        
        if(compara_fechas($fecha_ini, $fecha_fin)>0){
            $this->errorMessage='Inserte un rango valido de fechas';
            return false;
        }
        
        if (!empty($this->data['Nomina']['FECHA_INI'])) {
            $this->data['Nomina']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_INI']);
        }
        if (!empty($this->data['Nomina']['FECHA_FIN'])) {
            $this->data['Nomina']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_FIN']);
        }
        if (!empty($this->data['Nomina']['FECHA_ELA'])) {
            $this->data['Nomina']['FECHA_ELA'] = formatoFechaBeforeSave($this->data['Nomina']['FECHA_ELA']);
        }
        return true;
    }
    
     function afterFind($results) {        
        foreach ($results as $key => $val) {
            
            if (isset($val['Nomina']['FECHA_INI'])) {
                $results[$key]['Nomina']['FECHA_INI'] = formatoFechaAfterFind($val['Nomina']['FECHA_INI']);
                $results[$key]['Nomina']['MES'] = $this->getMes($results[$key]['Nomina']['FECHA_INI']);
                $results[$key]['Nomina']['AÑO'] = $this->getAño($results[$key]['Nomina']['FECHA_INI']);
            }
            if (isset($val['Nomina']['FECHA_FIN'])) {
                $results[$key]['Nomina']['FECHA_FIN'] = formatoFechaAfterFind($val['Nomina']['FECHA_FIN']);
            }
            if (isset($val['Nomina']['FECHA_ELA'])) {
                $results[$key]['Nomina']['FECHA_ELA'] = formatoFechaAfterFind($val['Nomina']['FECHA_ELA']);
            }
            
            
            
        }
        return $results;
    }
    
    function getMes($date){
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
        "Noviembre", "Diciembre"); 
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $meses[((int) $mes) - 1];
    }
    
    function getAño($date){
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $anio;
    }
}
?>
