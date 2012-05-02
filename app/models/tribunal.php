<?php

class Tribunal extends AppModel {

    var $name = 'Tribunal';
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
        if (isset($this->data['Tribunal']['TRIBUNAL_MES']) && isset($this->data['Tribunal']['TRIBUNAL_AÑO'])) {
            if (empty($this->data['Tribunal']['TRIBUNAL_MES']) || empty($this->data['Tribunal']['TRIBUNAL_AÑO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Tribunal']['TRIBUNAL_AÑO'])) {
                if ($this->data['Tribunal']['TRIBUNAL_AÑO'] < 1900 || $this->data['Tribunal']['TRIBUNAL_AÑO'] > 2200) {
                    $this->errorMessage = "El año es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año tiene que ser un numero";
                return false;
            }


            $this->data['Tribunal']['FECHA'] = $this->data['Tribunal']['TRIBUNAL_AÑO'] . '-' . $this->data['Tribunal']['TRIBUNAL_MES'] . '-1';
        }

        if (!empty($this->data['Tribunal']['FECHA'])) {
            $this->data['Tribunal']['FECHA'] = formatoFechaBeforeSave($this->data['Tribunal']['FECHA']);
        }
        
        if ($this->existe($this->data['Tribunal'])) {
            $this->errorMessage = "Ya existe una deduccion por tribunales para esta fecha.";
            return false;
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {

            if (isset($val['Tribunal']['FECHA'])) {
                $results[$key]['Tribunal']['FECHA'] = formatoFechaAfterFind($val['Tribunal']['FECHA']);
                $results[$key]['Tribunal']['MES'] = $this->getMes($results[$key]['Tribunal']['FECHA']);
                $results[$key]['Tribunal']['AÑO'] = $this->getAño($results[$key]['Tribunal']['FECHA']);
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