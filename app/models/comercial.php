<?php

class Comercial extends AppModel {

    var $name = 'Comercial';
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
        if (isset($this->data['Comercial']['COMERCIAL_MES']) && isset($this->data['Comercial']['COMERCIAL_AÑO'])) {
            if (empty($this->data['Comercial']['COMERCIAL_MES']) || empty($this->data['Comercial']['COMERCIAL_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Comercial']['COMERCIAL_AÑO'])) {
                if ($this->data['Comercial']['COMERCIAL_AÑO'] < 1900 || $this->data['Comercial']['COMERCIAL_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }


            $this->data['Comercial']['FECHA'] = $this->data['Comercial']['COMERCIAL_AÑO'] . '-' . $this->data['Comercial']['COMERCIAL_MES'] . '-1';
        }

        if (!empty($this->data['Comercial']['FECHA'])) {
            $this->data['Comercial']['FECHA'] = formatoFechaBeforeSave($this->data['Comercial']['FECHA']);
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

}

?>