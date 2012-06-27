<?php

class Comercial extends AppModel {

    var $name = 'Comercial';
    var $displayField = 'CANTIDAD';
    var $actsAs = array('Containable');
    var $belongsTo = 'Empleado';
    var $validate = array(
        'CANTIDAD' => array(
            'rule' => array('numeric'),
            'message' => 'Ingrese un monto valido',
        ),
        'COMERCIAL_MES' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'COMERCIAL_AÑO' => array(
            'comercialAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'comercialAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'comercialAño-r3' => array(
                'rule' => array('comercialAño'),
                'message' => 'El año es un valor invalido'
            )
        )
    );
    
    function comercialAño($check) {
        if ($check['COMERCIAL_AÑO'] < 1900 || $check['COMERCIAL_AÑO'] > 2200) {
            return false;
        }
        return true;
    }

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Comercial']['COMERCIAL_MES']) && isset($this->data['Comercial']['COMERCIAL_AÑO'])) {
            
            $this->data['Comercial']['FECHA'] = $this->data['Comercial']['COMERCIAL_AÑO'] . '-' . $this->data['Comercial']['COMERCIAL_MES'] . '-1';
        }

        if (!empty($this->data['Comercial']['FECHA'])) {
            $this->data['Comercial']['FECHA'] = formatoFechaBeforeSave($this->data['Comercial']['FECHA']);
        }
        
        if($this->existe($this->data['Comercial'])){
            $this->errorMessage = "Ya existe una deduccion por credito comercial para esta fecha.";
            return false;
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Comercial']['FECHA'])) {
                $results[$key]['Comercial']['FECHA'] = formatoFechaAfterFind($val['Comercial']['FECHA']);
                $results[$key]['Comercial']['MES'] = $this->getMes($results[$key]['Comercial']['FECHA']);
                $results[$key]['Comercial']['AÑO'] = $this->getAño($results[$key]['Comercial']['FECHA']);
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
    
    function existe($data){
        $conditions['empleado_id']=$data['empleado_id'];
        $conditions['FECHA']=$data['FECHA'];
        $data=$this->find('first',array(
            'conditions'=>$conditions
        ));
        if(!empty($data)){
            return true;
        }else{
            return false;
        }
    }

}

?>