<?php

class DetalleEventualidad extends AppModel {

    var $name = 'DetalleEventualidad';
    var $belongsTo = array('Empleado', 'Eventualidad');
    
    var $validate = array(        
        'VALOR' => array(
            'rule' => array('numeric'),
            'message' => 'Ingrese un monto valido',
        ),
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione la Quincena',
        ),
        'EVENTO_MES' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'EVENTO_AÑO' => array(
            'eventoAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'eventoAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'eventoAño-r3' => array(
                'rule' => array('eventoAño'),
                'message' => 'El año es un valor invalido'
            )
        )
    );
    
    function eventoAño($check) {
        if ($check['EVENTO_AÑO'] < 1900 || $check['EVENTO_AÑO'] > 2200) {
            return false;
        }
        return true;
    }

    function beforeSave() {
        if (isset($this->data['DetalleEventualidad']['EVENTO_MES']) && isset($this->data['DetalleEventualidad']['EVENTO_AÑO'])) {
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