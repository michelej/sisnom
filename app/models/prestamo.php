<?php

class Prestamo extends AppModel {

    var $name = 'Prestamo';
    var $displayField = 'CANTIDAD';
    var $actsAs = array('Containable');
    var $belongsTo = 'Empleado';
    
    var $validate = array(
        'CANTIDAD' => array(
            'rule' => array('numeric'),
            'message' => 'Ingrese un monto valido',
        ),
        'PRESTAMO_MES' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'QUINCENA' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione una Quincena'
        ),
        'PRESTAMO_AÑO' => array(
            'prestamoAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'prestamoAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'prestamoAño-r3' => array(
                'rule' => array('prestamoAño'),
                'message' => 'El año es un valor invalido'
            )
        )
    );

     function prestamoAño($check) {
        if ($check['PRESTAMO_AÑO'] < 1900 || $check['PRESTAMO_AÑO'] > 2200) {
            return false;
        }
        return true;
    }
    
    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Prestamo']['PRESTAMO_MES']) && isset($this->data['Prestamo']['PRESTAMO_AÑO'])) {
            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['Prestamo']['QUINCENA'] == 'Primera') {
                $this->data['Prestamo']['FECHA'] = $this->data['Prestamo']['PRESTAMO_AÑO'] . '-' . $this->data['Prestamo']['PRESTAMO_MES'] . '-1';
            }
            if ($this->data['Prestamo']['QUINCENA'] == 'Segunda') {
                $this->data['Prestamo']['FECHA'] = $this->data['Prestamo']['PRESTAMO_AÑO'] . '-' . $this->data['Prestamo']['PRESTAMO_MES'] . '-16';
            }            
        }

        if (!empty($this->data['Prestamo']['FECHA'])) {
            $this->data['Prestamo']['FECHA'] = formatoFechaBeforeSave($this->data['Prestamo']['FECHA']);
        }
        if($this->existe($this->data['Prestamo'])){
            $this->errorMessage = "Ya existe un prestamo de caja de ahorro para esta fecha.";
            return false;
        }
        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Prestamo']['FECHA'])) {
                $results[$key]['Prestamo']['FECHA'] = formatoFechaAfterFind($val['Prestamo']['FECHA']);
                $results[$key]['Prestamo']['MES'] = $this->getMes($results[$key]['Prestamo']['FECHA']);
                $results[$key]['Prestamo']['AÑO'] = $this->getAño($results[$key]['Prestamo']['FECHA']);
                $results[$key]['Prestamo']['QUINCENA'] = $this->getQuincena($results[$key]['Prestamo']['FECHA']);
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