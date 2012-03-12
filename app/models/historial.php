<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';

    function beforeSave() {         
        $this->recursive=-1;
        $historiales=$this->findAllByCargoId($this->data['Historial']['cargo_id']);
        
        // Verificar que fecha final sea mayor a fecha inicial
        if($this->data['Historial']['FECHA_INI']>$this->data['Historial']['FECHA_FIN']){
            return false;
        }
        
        
        // Verificar si alguna de las fecha se encuentra en el rango de alguna ya existente
        if(!empty($historiales)){            
            foreach ($historiales as $historial) {                
                if($this->check_in_range($historial['Historial']['FECHA_INI'],$historial['Historial']['FECHA_FIN'],$this->data['Historial']['FECHA_INI'])){
                    return false;
                }
                if($this->check_in_range($historial['Historial']['FECHA_INI'],$historial['Historial']['FECHA_FIN'],$this->data['Historial']['FECHA_FIN'])){
                    return false;
                }                    
            } 
        }
        
        
        
        if (!empty($this->data['Historial']['FECHA_INI'])) {
            $this->data['Historial']['FECHA_INI'] = $this->formatoFechaBeforeSave($this->data['Historial']['FECHA_INI']);
        }
        if (!empty($this->data['Historial']['FECHA_FIN'])) {
            $this->data['Historial']['FECHA_FIN'] = $this->formatoFechaBeforeSave($this->data['Historial']['FECHA_FIN']);
        }        
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Historial']['FECHA_INI'])) {
                $results[$key]['Historial']['FECHA_INI'] = $this->formatoFechaAfterFind($val['Historial']['FECHA_INI']);
            }
            if (isset($val['Historial']['FECHA_FIN'])) {
                $results[$key]['Historial']['FECHA_FIN'] = $this->formatoFechaAfterFind($val['Historial']['FECHA_FIN']);
            }
        }
        return $results;
    }

    function formatoFechaAfterFind($cadenaFecha) {
        return date('d-m-Y', strtotime($cadenaFecha));
    }

    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }

    /**
     * Verifica que una fecha esté dentro del rango de fechas establecidas
     * @param $start_date fecha de inicio
     * @param $end_date fecha final
     * @param $evaluame fecha a comparar
     * @return true si esta en el rango, false si no lo está
     */
    function check_in_range($start_date, $end_date, $evaluame) {
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($evaluame);
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

}

?>
