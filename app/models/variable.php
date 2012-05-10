<?php

class Variable extends AppModel {

    var $name = 'Variable';
    var $displayField = 'NOMBRE';
    var $errorMessage = '';

    function beforeSave() {
        if (isset($this->data['Variable']['VARIABLE_MES_INICIO']) && isset($this->data['Variable']['VARIABLE_AÑO_INICIO'])) {
            if (empty($this->data['Variable']['VARIABLE_MES_INICIO']) || empty($this->data['Variable']['VARIABLE_AÑO_INICIO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Variable']['VARIABLE_AÑO_INICIO'])) {
                if ($this->data['Variable']['VARIABLE_AÑO_INICIO'] < 1900 || $this->data['Variable']['VARIABLE_AÑO_INICIO'] > 2200) {
                    $this->errorMessage = "El año inicial es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año inicial tiene que ser un numero";
                return false;
            }

            if (empty($this->data['Variable']['QUINCENA_INICIO'])) {
                $this->errorMessage = "Seleccione una Quincena";
                return false;
            }

            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['Variable']['QUINCENA_INICIO'] == 'Primera') {
                $this->data['Variable']['FECHA_INI'] = $this->data['Variable']['VARIABLE_AÑO_INICIO'] . '-' . $this->data['Variable']['VARIABLE_MES_INICIO'] . '-1';
            }
            if ($this->data['Variable']['QUINCENA_INICIO'] == 'Segunda') {
                $this->data['Variable']['FECHA_INI'] = $this->data['Variable']['VARIABLE_AÑO_INICIO'] . '-' . $this->data['Variable']['VARIABLE_MES_INICIO'] . '-16';
            }

            // Si se ingreso una fecha final
            //
            if (!empty($this->data['Variable']['VARIABLE_MES_FIN']) && !empty($this->data['Variable']['VARIABLE_AÑO_FIN'])
                    && !empty($this->data['Variable']['QUINCENA_FIN'])) {

                if (is_numeric($this->data['Variable']['VARIABLE_AÑO_FIN'])) {
                    if ($this->data['Variable']['VARIABLE_AÑO_FIN'] < 1900 || $this->data['Variable']['VARIABLE_AÑO_FIN'] > 2200) {
                        $this->errorMessage = "El año final es Invalido";
                        return false;
                    }
                } else {
                    $this->errorMessage = "El año final tiene que ser un numero";
                    return false;
                }

                if ($this->data['Variable']['QUINCENA_FIN'] == 'Primera') {
                    $this->data['Variable']['FECHA_FIN'] = $this->data['Variable']['VARIABLE_AÑO_FIN'] . '-' . $this->data['Variable']['VARIABLE_MES_FIN'] . '-15';
                }
                if ($this->data['Variable']['QUINCENA_FIN'] == 'Segunda') {
                    $dia = strftime("%d", mktime(0, 0, 0, $this->data['Variable']['VARIABLE_MES_FIN'] + 1, 0, $this->data['Variable']['VARIABLE_AÑO_FIN']));
                    $this->data['Variable']['FECHA_FIN'] = $this->data['Variable']['VARIABLE_AÑO_FIN'] . '-' . $this->data['Variable']['VARIABLE_MES_FIN'] . '-' . $dia;
                }
            } else {
                $c = 0;
                if (!empty($this->data['Variable']['VARIABLE_MES_FIN'])) {
                    $c++;
                }
                if (!empty($this->data['Variable']['VARIABLE_AÑO_FIN'])) {
                    $c++;
                }
                if (!empty($this->data['Variable']['VARIABLE_QUINCENA_FIN'])) {
                    $c++;
                }
                if ($c == 0) {
                    $this->data['Variable']['FECHA_FIN'] = null;
                    $fecha_fin = null;
                }
                if ($c >= 1) {
                    $this->errorMessage = "La fecha final esta incompleta";
                    return false;
                }
            }
        }

        $fecha_ini = formatoFechaAfterFind($this->data['Variable']['FECHA_INI']);

        if ($this->data['Variable']['FECHA_FIN'] != null) {
            $fecha_fin = formatoFechaAfterFind($this->data['Variable']['FECHA_FIN']);
        }

        $this->recursive = -1;
        // buscamos los demas rangos de fecha de esta variable
        $variables = $this->find('all', array(
            'conditions' => array(
                'NOMBRE' => $this->data['Variable']['NOMBRE']
            )
                ));
        $result = Set::combine($variables, '{n}.Variable.id', '{n}.Variable');

        if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "variables")) {
            return false;
        }
        return true;
    }

    /**
     *
     * @param type $results
     * @return type 
     */
    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Variable']['FECHA_INI'])) {
                $results[$key]['Variable']['FECHA_INI'] = formatoFechaAfterFind($val['Variable']['FECHA_INI']);
            }
            if (isset($val['Variable']['FECHA_FIN'])) {
                $results[$key]['Variable']['FECHA_FIN'] = formatoFechaAfterFind($val['Variable']['FECHA_FIN']);
            }
        }
        return $results;
    }

}

?>