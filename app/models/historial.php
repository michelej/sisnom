<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';
    var $errorMessage = '';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';

    /**
     *  Validaciones
     */
    var $validate = array(
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'SUELDO_BASE' => array(
            'rule' => array('numeric'),
            'message' => 'Sueldo Base invalido',
        ),
        'QUINCENA_INICIO' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione la Quincena',
        ),
        'HISTORIAL_MES_INICIO' => array(
            'rule' => array('notEmpty'),
            'message' => 'Seleccione un Mes'
        ),
        'HISTORIAL_AÑO_INICIO' => array(
            'histAño-r1' => array(
                'rule' => array('notEmpty'),
                'message' => 'Ingrese el año',
                'last' => true,
            ),
            'histAño-r2' => array(
                'rule' => array('numeric'),
                'message' => 'El año debe ser un Numero',
                'last' => true
            ),
            'histAño-r3' => array(
                'rule' => array('histAño'),
                'message' => 'El año es un valor invalido'
            )
        ),
        'QUINCENA_FIN' => array(
            'rule' => array('customValidation'),
            'message' => 'Seleccione la Quincena',
        ),
        'HISTORIAL_MES_FIN' => array(
            'rule' => array('customValidation'),
            'message' => 'Seleccione un Mes',
        ),
        'HISTORIAL_AÑO_FIN' => array(
            'rule' => array('customValidation'),
            'message' => 'Ingrese un valor valido',
        )
    );
    
    
    function customValidation($check) {
        if (isset($check['QUINCENA_FIN'])) {
            if (empty($check['QUINCENA_FIN'])) {
                if (!empty($this->data['Historial']['HISTORIAL_AÑO_FIN']) || !empty($this->data['Historial']['HISTORIAL_MES_FIN'])) {
                    return false;
                }
            }
        }
        if (isset($check['HISTORIAL_AÑO_FIN'])) {
            if (empty($check['HISTORIAL_AÑO_FIN'])) {
                if (!empty($this->data['Historial']['QUINCENA_FIN']) || !empty($this->data['Historial']['HISTORIAL_MES_FIN'])) {
                    return false;
                }
            } else {
                if (is_numeric($check['HISTORIAL_AÑO_FIN'])) {
                    if ($check['HISTORIAL_AÑO_FIN'] < 1900 || $check['HISTORIAL_AÑO_FIN'] > 2200) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
        if (isset($check['HISTORIAL_MES_FIN'])) {
            if (empty($check['HISTORIAL_MES_FIN'])) {
                if (!empty($this->data['Historial']['HISTORIAL_AÑO_FIN']) || !empty($this->data['Historial']['QUINCENA_FIN'])) {
                    return false;
                }
            }
        }
        return true;
    }

    function histAño($check) {
        if (isset($check['HISTORIAL_AÑO_INICIO'])) {
            if ($check['HISTORIAL_AÑO_INICIO'] < 1900 || $check['HISTORIAL_AÑO_INICIO'] > 2200) {
                return false;
            }
        }
        if (isset($check['HISTORIAL_AÑO_FIN'])) {
            if ($check['HISTORIAL_AÑO_FIN'] < 1900 || $check['HISTORIAL_AÑO_FIN'] > 2200) {
                return false;
            }
        }

        return true;
    }

    // TODO: Falta validar la fecha final 
    /**
     *
     * @return boolean 
     */
    function beforeSave() {
        if (isset($this->data['Historial']['HISTORIAL_MES_INICIO']) && isset($this->data['Historial']['HISTORIAL_AÑO_INICIO'])) {
            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['Historial']['QUINCENA_INICIO'] == 'Primera') {
                $this->data['Historial']['FECHA_INI'] = $this->data['Historial']['HISTORIAL_AÑO_INICIO'] . '-' . $this->data['Historial']['HISTORIAL_MES_INICIO'] . '-1';
            }
            if ($this->data['Historial']['QUINCENA_INICIO'] == 'Segunda') {
                $this->data['Historial']['FECHA_INI'] = $this->data['Historial']['HISTORIAL_AÑO_INICIO'] . '-' . $this->data['Historial']['HISTORIAL_MES_INICIO'] . '-16';
            }

            // Si se ingreso una fecha final
            //
            if (!empty($this->data['Historial']['HISTORIAL_MES_FIN']) && !empty($this->data['Historial']['HISTORIAL_AÑO_FIN'])
                    && !empty($this->data['Historial']['QUINCENA_FIN'])) {

                if ($this->data['Historial']['QUINCENA_FIN'] == 'Primera') {
                    $this->data['Historial']['FECHA_FIN'] = $this->data['Historial']['HISTORIAL_AÑO_FIN'] . '-' . $this->data['Historial']['HISTORIAL_MES_FIN'] . '-15';
                }
                if ($this->data['Historial']['QUINCENA_FIN'] == 'Segunda') {
                    $dia = strftime("%d", mktime(0, 0, 0, $this->data['Historial']['HISTORIAL_MES_FIN'] + 1, 0, $this->data['Historial']['HISTORIAL_AÑO_FIN']));
                    $this->data['Historial']['FECHA_FIN'] = $this->data['Historial']['HISTORIAL_AÑO_FIN'] . '-' . $this->data['Historial']['HISTORIAL_MES_FIN'] . '-' . $dia;
                }
            } else {
                $c = 0;
                if (!empty($this->data['Historial']['HISTORIAL_MES_FIN'])) {
                    $c++;
                }
                if (!empty($this->data['Historial']['HISTORIAL_AÑO_FIN'])) {
                    $c++;
                }
                if (!empty($this->data['Historial']['HISTORIAL_QUINCENA_FIN'])) {
                    $c++;
                }
                if ($c == 0) {
                    $this->data['Historial']['FECHA_FIN'] = null;
                    $fecha_fin = null;
                }
                if ($c >= 1) {
                    $this->errorMessage = "La fecha final esta incompleta";
                    return false;
                }
            }
        }

        $fecha_ini = formatoFechaAfterFind($this->data['Historial']['FECHA_INI']);

        if ($this->data['Historial']['FECHA_FIN'] != null) {
            $fecha_fin = formatoFechaAfterFind($this->data['Historial']['FECHA_FIN']);
        }

        if (!empty($this->data['Historial']['FECHA_RET'])) {
            $fecha_ret = formatoFechaAfterFind($this->data['Historial']['FECHA_RET']);
        } else {
            $fecha_ret = null;
            $this->data['Historial']['FECHA_RET'] = NULL;
        }


        $this->recursive = -1;
        // buscamos los historiales de sueldo de este cargo
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);
        $result = Set::combine($historiales, '{n}.Historial.id', '{n}.Historial');

        if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "historiales")) {
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
            if (isset($val['Historial']['FECHA_INI'])) {
                $results[$key]['Historial']['FECHA_INI'] = formatoFechaAfterFind($val['Historial']['FECHA_INI']);
            }
            if (isset($val['Historial']['FECHA_FIN'])) {
                $results[$key]['Historial']['FECHA_FIN'] = formatoFechaAfterFind($val['Historial']['FECHA_FIN']);
            }
            if (isset($val['Historial']['FECHA_RET'])) {
                $results[$key]['Historial']['FECHA_RET'] = formatoFechaAfterFind($val['Historial']['FECHA_RET']);
            }
        }
        return $results;
    }

}

?>