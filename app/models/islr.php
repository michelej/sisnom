<?php

class Islr extends AppModel {

    var $name = 'Islr';
    var $useTable = 'islr';
    var $displayField = 'CANTIDAD';
    var $actsAs = array('Containable');
    var $belongsTo = 'Empleado';
    var $validate = array(
        'PORCENTAJE' => array(
            'rule' => array('decimal'),
            'message' => 'Porcentaje invalido ( ejm: 5.00)',
        )
    );

    function beforeSave() {
        // Cuando esto existe es porque viene del ADD es un nuevo registro
        if (isset($this->data['Islr']['ISLR_MES']) && isset($this->data['Islr']['ISLR_AÑO'])) {
            if (empty($this->data['Islr']['ISLR_MES']) || empty($this->data['Islr']['ISLR_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Islr']['ISLR_AÑO'])) {
                if ($this->data['Islr']['ISLR_AÑO'] < 1900 || $this->data['Islr']['ISLR_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }


            $this->data['Islr']['FECHA'] = $this->data['Islr']['ISLR_AÑO'] . '-' . $this->data['Islr']['ISLR_MES'] . '-1';
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