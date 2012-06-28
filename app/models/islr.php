<?php

class Islr extends AppModel {

    var $name = 'Islr';
    var $useTable = 'islr';
    var $displayField = 'CANTIDAD';
    var $actsAs = array('Containable');
    /**
     * Relaciones
     * 
     */
    var $belongsTo = 'Empleado';
    /**
     * Validaciones
     * 
     */
    var $validate = array(
        'PORCENTAJE' => array(
            'rule' => array('range', 0, 100),
            'message' => 'Porcentaje invalido',
        ),
        'ISLR_MES' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione una Quincena'
        ),
        'ISLR_AÑO' => array(
            'islrAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'islrAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'islrAño-r3' => array(
                'rule' => array('islrAño'),
                'message' => 'El año es un valor invalido'
            )
        )
    );
    
    function islrAño($check) {
        if ($check['ISLR_AÑO'] < 1900 || $check['ISLR_AÑO'] > 2200) {
            return false;
        }
        return true;
    }

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Islr']['ISLR_MES']) && isset($this->data['Islr']['ISLR_AÑO'])) {
            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['Islr']['QUINCENA'] == 'Primera') {
                $this->data['Islr']['FECHA'] = $this->data['Islr']['ISLR_AÑO'] . '-' . $this->data['Islr']['ISLR_MES'] . '-1';
            }
            if ($this->data['Islr']['QUINCENA'] == 'Segunda') {
                $this->data['Islr']['FECHA'] = $this->data['Islr']['ISLR_AÑO'] . '-' . $this->data['Islr']['ISLR_MES'] . '-16';
            }                        
        }

        if (!empty($this->data['Islr']['FECHA'])) {
            $this->data['Islr']['FECHA'] = formatoFechaBeforeSave($this->data['Islr']['FECHA']);
        }

        if ($this->existe($this->data['Islr'])) {
            $this->errorMessage = "Ya existe una retencion por impuesto sobre la renta para esta fecha.";
            return false;
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Islr']['FECHA'])) {
                $results[$key]['Islr']['FECHA'] = formatoFechaAfterFind($val['Islr']['FECHA']);
                $results[$key]['Islr']['MES'] = $this->getMes($results[$key]['Islr']['FECHA']);
                $results[$key]['Islr']['AÑO'] = $this->getAño($results[$key]['Islr']['FECHA']);
                $results[$key]['Islr']['QUINCENA'] = $this->getQuincena($results[$key]['Islr']['FECHA']);
            }
        }
        return $results;
    }

    function getMes($date) {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre");
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $meses[((int) $mes) - 1];
    }

    function getAño($date) {
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        return $anio;
    }    
    
    function getQuincena($date){
        list($dia, $mes, $anio) = preg_split('/-/', $date);
        if($dia=='1'){
            return 'Primera';
        }else{
            return 'Segunda';
        }
    }

    function existe($data) {
        $conditions['empleado_id'] = $data['empleado_id'];
        $conditions['FECHA'] = $data['FECHA'];
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