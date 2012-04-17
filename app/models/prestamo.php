<?php

class Prestamo extends AppModel {

    var $name = 'Prestamo';
    var $displayField = 'CANTIDAD';
    var $actsAs = array('Containable');
    var $belongsTo = 'Empleado';
    var $validate = array(
        'CANTIDAD' => array(
            'rule' => array('decimal'),
            'message' => 'Monto invalido ( ejm: 1500.00)',
        )
    );

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Prestamo']['PRESTAMO_MES']) && isset($this->data['Prestamo']['PRESTAMO_AÑO'])) {
            if (empty($this->data['Prestamo']['PRESTAMO_MES']) || empty($this->data['Prestamo']['PRESTAMO_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Prestamo']['PRESTAMO_AÑO'])) {
                if ($this->data['Prestamo']['PRESTAMO_AÑO'] < 1900 || $this->data['Prestamo']['PRESTAMO_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }


            $this->data['Prestamo']['FECHA'] = $this->data['Prestamo']['PRESTAMO_AÑO'] . '-' . $this->data['Prestamo']['PRESTAMO_MES'] . '-1';
        }

        if (!empty($this->data['Prestamo']['FECHA'])) {
            $this->data['Prestamo']['FECHA'] = formatoFechaBeforeSave($this->data['Prestamo']['FECHA']);
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Prestamo']['FECHA'])) {
                $results[$key]['Prestamo']['FECHA'] = formatoFechaAfterFind($val['Prestamo']['FECHA']);
                $results[$key]['Prestamo']['MES'] = $this->getMes($results[$key]['Prestamo']['FECHA']);
                $results[$key]['Prestamo']['AÑO'] = $this->getAño($results[$key]['Prestamo']['FECHA']);
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

}

?>