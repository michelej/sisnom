<?php

class Ajuste extends AppModel {

    var $name = 'Ajuste';
    var $actsAs = array('ExtendAssociations', 'Containable');

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = array('Asignacion', 'Deduccion');
    var $belongsTo = 'Empleado';

    function beforeSave() {
        if (!isset($this->data['Ajuste']['id'])) {

            if (isset($this->data['Ajuste']['AJUSTE_MES_INICIO']) && isset($this->data['Ajuste']['AJUSTE_AÑO_INICIO'])) {
                if (empty($this->data['Ajuste']['AJUSTE_MES_INICIO']) || empty($this->data['Ajuste']['AJUSTE_AÑO_INICIO'])) {
                    $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                    return false;
                }
                if (is_numeric($this->data['Ajuste']['AJUSTE_AÑO_INICIO'])) {
                    if ($this->data['Ajuste']['AJUSTE_AÑO_INICIO'] < 1900 || $this->data['Ajuste']['AJUSTE_AÑO_INICIO'] > 2200) {
                        $this->errorMessage = "El año inicial es Invalido";
                        return false;
                    }
                } else {
                    $this->errorMessage = "El año inicial tiene que ser un numero";
                    return false;
                }

                if (empty($this->data['Ajuste']['QUINCENA_INICIO'])) {
                    $this->errorMessage = "Seleccione una Quincena";
                    return false;
                }

                // Determinamos las fechas en base a la quincena
                //            
                if ($this->data['Ajuste']['QUINCENA_INICIO'] == 'Primera') {
                    $this->data['Ajuste']['FECHA_INI'] = $this->data['Ajuste']['AJUSTE_AÑO_INICIO'] . '-' . $this->data['Ajuste']['AJUSTE_MES_INICIO'] . '-1';
                }
                if ($this->data['Ajuste']['QUINCENA_INICIO'] == 'Segunda') {
                    $this->data['Ajuste']['FECHA_INI'] = $this->data['Ajuste']['AJUSTE_AÑO_INICIO'] . '-' . $this->data['Ajuste']['AJUSTE_MES_INICIO'] . '-16';
                }

                // Si se ingreso una fecha final
                //
            if (!empty($this->data['Ajuste']['AJUSTE_MES_FIN']) && !empty($this->data['Ajuste']['AJUSTE_AÑO_FIN'])
                        && !empty($this->data['Ajuste']['QUINCENA_FIN'])) {

                    if (is_numeric($this->data['Ajuste']['AJUSTE_AÑO_FIN'])) {
                        if ($this->data['Ajuste']['AJUSTE_AÑO_FIN'] < 1900 || $this->data['Ajuste']['AJUSTE_AÑO_FIN'] > 2200) {
                            $this->errorMessage = "El año final es Invalido";
                            return false;
                        }
                    } else {
                        $this->errorMessage = "El año final tiene que ser un numero";
                        return false;
                    }

                    if ($this->data['Ajuste']['QUINCENA_FIN'] == 'Primera') {
                        $this->data['Ajuste']['FECHA_FIN'] = $this->data['Ajuste']['AJUSTE_AÑO_FIN'] . '-' . $this->data['Ajuste']['AJUSTE_MES_FIN'] . '-15';
                    }
                    if ($this->data['Ajuste']['QUINCENA_FIN'] == 'Segunda') {
                        $dia = strftime("%d", mktime(0, 0, 0, $this->data['Ajuste']['AJUSTE_MES_FIN'] + 1, 0, $this->data['Ajuste']['AJUSTE_AÑO_FIN']));
                        $this->data['Ajuste']['FECHA_FIN'] = $this->data['Ajuste']['AJUSTE_AÑO_FIN'] . '-' . $this->data['Ajuste']['AJUSTE_MES_FIN'] . '-' . $dia;
                    }
                } else {
                    $c = 0;
                    if (!empty($this->data['Ajuste']['AJUSTE_MES_FIN'])) {
                        $c++;
                    }
                    if (!empty($this->data['Ajuste']['AJUSTE_AÑO_FIN'])) {
                        $c++;
                    }
                    if (!empty($this->data['Ajuste']['AJUSTE_QUINCENA_FIN'])) {
                        $c++;
                    }
                    if ($c == 0) {
                        $this->data['Ajuste']['FECHA_FIN'] = null;
                        $fecha_fin = null;
                    }
                    if ($c >= 1) {
                        $this->errorMessage = "La fecha final esta incompleta";
                        return false;
                    }                    
                }
            }

            $fecha_ini = formatoFechaAfterFind($this->data['Ajuste']['FECHA_INI']);

            if ($this->data['Ajuste']['FECHA_FIN'] != null) {
                $fecha_fin = formatoFechaAfterFind($this->data['Ajuste']['FECHA_FIN']);
            }

            $this->recursive = -1;
            // buscamos los contratos de este empleado
            $ajustes = $this->findAllByEmpleadoId($this->data['Ajuste']['empleado_id']);
            $result = Set::combine($ajustes, '{n}.Ajuste.id', '{n}.Ajuste');

            if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "ajustes")) {
                return false;
            }
            return true;
        } else {

            if (!empty($this->data['Ajuste']['FECHA_INI'])) {
                $this->data['Ajuste']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_INI']);
            }
            if (!empty($this->data['Ajuste']['FECHA_FIN'])) {
                $this->data['Ajuste']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Ajuste']['FECHA_FIN']);
            }
            return true;
        }
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Ajuste']['FECHA_INI'])) {
                $results[$key]['Ajuste']['FECHA_INI'] = formatoFechaAfterFind($val['Ajuste']['FECHA_INI']);
            }
            if (isset($val['Ajuste']['FECHA_FIN'])) {
                $results[$key]['Ajuste']['FECHA_FIN'] = formatoFechaAfterFind($val['Ajuste']['FECHA_FIN']);
            }
        }
        return $results;
    }

}

?>