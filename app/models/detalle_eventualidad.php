<?php

class DetalleEventualidad extends AppModel {

    var $name = 'DetalleEventualidad';
    var $belongsTo = array('Empleado', 'Eventualidad');
    
    var $validate = array(
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'VALOR' => array(
            'rule' => array('decimal'),
            'message' => 'Sueldo Base invalido ( ejm: 1500.00)',
        ),
    );

    function beforeSave() {
        if (isset($this->data['DetalleEventualidad']['EVENTO_MES']) && isset($this->data['DetalleEventualidad']['EVENTO_AÑO'])) {
            if (empty($this->data['DetalleEventualidad']['EVENTO_MES']) || empty($this->data['DetalleEventualidad']['EVENTO_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['DetalleEventualidad']['EVENTO_AÑO'])) {
                if ($this->data['DetalleEventualidad']['EVENTO_AÑO'] < 1900 || $this->data['DetalleEventualidad']['EVENTO_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }

            if (empty($this->data['DetalleEventualidad']['QUINCENA'])) {
                $this->errorMessage = "Seleccione una Quincena";
                return false;
            }

            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['DetalleEventualidad']['QUINCENA'] == 'Primera') {
                $this->data['DetalleEventualidad']['FECHA'] = $this->data['DetalleEventualidad']['EVENTO_AÑO'] . '-' . $this->data['DetalleEventualidad']['EVENTO_MES'] . '-1';
            }
            if ($this->data['DetalleEventualidad']['QUINCENA'] == 'Segunda') {
                $this->data['DetalleEventualidad']['FECHA'] = $this->data['DetalleEventualidad']['EVENTO_AÑO'] . '-' . $this->data['DetalleEventualidad']['EVENTO_MES'] . '-16';
            }
        }
        
        if ($this->existe($this->data['DetalleEventualidad']) && !isset($this->data['DetalleEventualidad']['id'])) {
            $this->errorMessage = "Ya existe para esta fecha.";
            return false;
        }
        return true;
    }
    
     function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['DetalleEventualidad']['FECHA'])) {
                $results[$key]['DetalleEventualidad']['FECHA'] = formatoFechaAfterFind($val['DetalleEventualidad']['FECHA']);
                $results[$key]['DetalleEventualidad']['MES'] = $this->getMes($results[$key]['DetalleEventualidad']['FECHA']);
                $results[$key]['DetalleEventualidad']['AÑO'] = $this->getAño($results[$key]['DetalleEventualidad']['FECHA']);
                $results[$key]['DetalleEventualidad']['QUINCENA'] = $this->getQuincena($results[$key]['DetalleEventualidad']['FECHA']);
            }            
        }
        return $results;
    }
    /**
     *
     * @param type $date
     * @return string 
     */    
    function getMes($date) {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre");
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $meses[((int) $mes) - 1];
    }

    /**
     *
     * @param type $date
     * @return type 
     */
    function getAño($date) {
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $anio;
    }
    /**
     * 
     */
    function getQuincena($date){
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        if($dia=='1'){
            return "Primera";
        }else{
           return "Segunda";
        }
    }    

    /**
     *
     * @param type $data
     * @return boolean 
     */
    function existe($data) {
        $conditions['FECHA'] = $data['FECHA'];
        $conditions['empleado_id']=$data['empleado_id'];
        $conditions['eventualidad_id']=$data['eventualidad_id'];
        $data = $this->find('first', array(
            'conditions' => $conditions
                ));
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

}

?>